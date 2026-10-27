<?php
require_once "../modelo/conexion.php";
require_once "evaluacion.php";

$ctx = [
    "id_grupo"   => $_GET["id_grupo"]   ?? "",
    "id_materia" => $_GET["id_materia"] ?? "",
    "parcial"    => $_GET["parcial"]    ?? "",
];
$completo = !in_array("", $ctx, true);
$paso     = (int) ($_GET["paso"] ?? 1);
$fecha    = $_GET["fecha"] ?? date("Y-m-d");
if ($paso >= 2 && !$completo) $paso = 1;

function enlace($datos) { return "asistencia.php?" . http_build_query($datos); }

// Alumnos del grupo
$alumnos = [];
if ($completo) {
    $q = $pdo->prepare("SELECT id_alumno, matricula, nombre, apellidos FROM alumno WHERE id_grupo=? ORDER BY apellidos, nombre");
    $q->execute([$ctx["id_grupo"]]);
    $alumnos = $q->fetchAll();
}

// ---------- Acciones (POST) ----------
if ($_SERVER["REQUEST_METHOD"] === "POST" && $completo) {
    $accion = $_POST["accion"] ?? "";

    // Guardar (o corregir) la lista de un día, con su hora
    if ($accion === "guardar") {
        $f = $_POST["fecha"];
        $h = $_POST["hora"] ?: date("H:i");

        // No se pueden registrar más clases que las del parcial (20)
        if ($alumnos) {
            $ids = implode(",", array_map("intval", array_column($alumnos, "id_alumno")));
            $q = $pdo->prepare("SELECT COUNT(DISTINCT fecha), SUM(fecha = ?) FROM asistencia
                                WHERE id_materia=? AND parcial=? AND id_alumno IN ($ids)");
            $q->execute([$f, $ctx["id_materia"], $ctx["parcial"]]);
            list($clases, $esaFecha) = $q->fetch(PDO::FETCH_NUM);
            if ((int) $esaFecha == 0 && (int) $clases >= totalAsistencias()) {
                header("Location: " . enlace($ctx + ["paso" => 2, "lleno" => 1])); exit;
            }
        }
        $up = $pdo->prepare("INSERT INTO asistencia (id_alumno, id_materia, parcial, fecha, hora, presente)
                             VALUES (?, ?, ?, ?, ?, ?)
                             ON DUPLICATE KEY UPDATE hora = VALUES(hora), presente = VALUES(presente)");
        foreach ($alumnos as $a) {
            $presente = isset($_POST["presente"][$a["id_alumno"]]) ? 1 : 0;
            $up->execute([$a["id_alumno"], $ctx["id_materia"], $ctx["parcial"], $f, $h, $presente]);
        }
        header("Location: " . enlace($ctx + ["paso" => 2, "ok" => 1])); exit;
    }

    // Borrar la lista completa de un día
    if ($accion === "borrar") {
        $del = $pdo->prepare("DELETE FROM asistencia WHERE id_alumno=? AND id_materia=? AND parcial=? AND fecha=?");
        foreach ($alumnos as $a) {
            $del->execute([$a["id_alumno"], $ctx["id_materia"], $ctx["parcial"], $_POST["fecha"]]);
        }
        header("Location: " . enlace($ctx + ["paso" => 2, "ok" => 1])); exit;
    }
}

$grupos   = $pdo->query("SELECT id_grupo, grado, grupo FROM grupo_grado ORDER BY grado, grupo")->fetchAll();
$materias = $pdo->query("SELECT * FROM materia ORDER BY nombre")->fetchAll();

if ($completo) {
    $q = $pdo->prepare("SELECT CONCAT(grado,'° ',grupo) FROM grupo_grado WHERE id_grupo=?");
    $q->execute([$ctx["id_grupo"]]);   $nombreGrupo = $q->fetchColumn();
    $q = $pdo->prepare("SELECT nombre FROM materia WHERE id_materia=?");
    $q->execute([$ctx["id_materia"]]); $nombreMateria = $q->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Asistencia</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Asistencia</h1>
<p class="pasos">Paso <?= $paso ?> de 3:
  <?= [1 => "elige grupo, materia y parcial", 2 => "historial de asistencias", 3 => "pasar lista"][$paso] ?></p>
<?php if (isset($_GET["ok"])): ?><p class="mensaje">Guardado ✓</p><?php endif; ?>
<?php if (isset($_GET["lleno"])): ?><p class="mensaje">Ya están las <?= totalAsistencias() ?> asistencias del parcial. Corrige una fecha existente.</p><?php endif; ?>

<?php if ($paso == 1): ?>
<!-- ================= PASO 1 ================= -->
<form method="get">
  <input type="hidden" name="paso" value="2">
  <p><label>Grupo:
    <select name="id_grupo" required>
      <option value="">-- Seleccionar --</option>
      <?php foreach ($grupos as $g): ?>
        <option value="<?= $g["id_grupo"] ?>" <?= $ctx["id_grupo"] == $g["id_grupo"] ? "selected" : "" ?>><?= $g["grado"] . "° " . htmlspecialchars($g["grupo"]) ?></option>
      <?php endforeach; ?>
    </select></label></p>
  <p><label>Materia:
    <select name="id_materia" required>
      <option value="">-- Seleccionar --</option>
      <?php foreach ($materias as $m): ?>
        <option value="<?= $m["id_materia"] ?>" <?= $ctx["id_materia"] == $m["id_materia"] ? "selected" : "" ?>><?= htmlspecialchars($m["nombre"]) ?></option>
      <?php endforeach; ?>
    </select></label></p>
  <p><label>Parcial:
    <select name="parcial" required>
      <option value="1" <?= $ctx["parcial"] == 1 ? "selected" : "" ?>>1</option>
      <option value="2" <?= $ctx["parcial"] == 2 ? "selected" : "" ?>>2</option>
    </select></label></p>
  <button>Continuar →</button>
</form>

<?php elseif ($paso == 2): ?>
<!-- ================= PASO 2: historial ================= -->
<p><strong><?= htmlspecialchars($nombreMateria) ?></strong> · Grupo <?= htmlspecialchars($nombreGrupo) ?> · Parcial <?= $ctx["parcial"] ?>
   <a href="<?= enlace($ctx + ["paso" => 1]) ?>">(cambiar)</a></p>

<?php
// Todas las asistencias del grupo en esta materia y parcial
$sesiones = [];   // "fecha" => hora
$marcas   = [];   // [id_alumno][fecha] => presente
if ($alumnos) {
    $ids = implode(",", array_map("intval", array_column($alumnos, "id_alumno")));
    $q = $pdo->prepare("SELECT id_alumno, fecha, hora, presente FROM asistencia
                        WHERE id_materia=? AND parcial=? AND id_alumno IN ($ids)
                        ORDER BY fecha, hora");
    $q->execute([$ctx["id_materia"], $ctx["parcial"]]);
    foreach ($q->fetchAll() as $r) {
        $sesiones[$r["fecha"]] = $r["hora"];
        $marcas[$r["id_alumno"]][$r["fecha"]] = (int) $r["presente"];
    }
}
?>
<p>Clases registradas: <strong><?= count($sesiones) ?> de <?= totalAsistencias() ?></strong>
   <?= count($sesiones) < totalAsistencias() ? "(faltan " . (totalAsistencias() - count($sesiones)) . ")" : "(completo)" ?></p>
<?php if (count($sesiones) < totalAsistencias()): ?>
<p><a class="boton" href="<?= enlace($ctx + ["paso" => 3, "fecha" => date("Y-m-d")]) ?>">+ Pasar lista de hoy</a></p>
<?php endif; ?>

<?php if (!$alumnos): ?>
  <p>Este grupo no tiene alumnos. Regístralos en <a href="alumnos.php">Alumnos</a>.</p>
<?php else: ?>
<p>Cada columna es una clase (toca la fecha para corregirla). ✓ = asistió, vacío = faltó.</p>
<table>
  <tr>
    <th>Alumno</th>
    <?php foreach ($sesiones as $f => $h): ?>
      <th class="centro"><a class="claro" href="<?= enlace($ctx + ["paso" => 3, "fecha" => $f]) ?>">
        <?= date("d/m", strtotime($f)) ?><br><small><?= substr($h, 0, 5) ?></small></a></th>
    <?php endforeach; ?>
    <th>Asistencias</th><th>Calif.</th>
  </tr>
  <?php foreach ($alumnos as $a):
        list($asistio, $total, $pts) = puntosAsistencia($pdo, $a["id_alumno"], $ctx["id_materia"], $ctx["parcial"]); ?>
  <tr>
    <td><?= htmlspecialchars($a["apellidos"] . " " . $a["nombre"]) ?></td>
    <?php foreach ($sesiones as $f => $h): ?>
      <td class="centro check"><?= !empty($marcas[$a["id_alumno"]][$f]) ? "✓" : "" ?></td>
    <?php endforeach; ?>
    <td class="centro"><?= $asistio ?> de <?= $total ?></td>
    <td class="centro"><strong><?= number_format($pts, 1) ?></strong></td>
  </tr>
  <?php endforeach; ?>
</table>
<p>El parcial tiene <?= totalAsistencias() ?> asistencias: las <?= totalAsistencias() ?> = 10, la mitad = 5.
   La asistencia vale <?= pesos()["asistencia"] ?>% del parcial.</p>
<?php endif; ?>

<?php else: ?>
<!-- ================= PASO 3: pasar lista ================= -->
<?php
// ¿Ya existe lista de esa fecha? Si sí, se carga para corregirla.
$existentes = [];
$horaGuardada = null;
if ($alumnos) {
    $ids = implode(",", array_map("intval", array_column($alumnos, "id_alumno")));
    $q = $pdo->prepare("SELECT id_alumno, hora, presente FROM asistencia
                        WHERE id_materia=? AND parcial=? AND fecha=? AND id_alumno IN ($ids)");
    $q->execute([$ctx["id_materia"], $ctx["parcial"], $fecha]);
    foreach ($q->fetchAll() as $r) {
        $existentes[$r["id_alumno"]] = (int) $r["presente"];
        $horaGuardada = $r["hora"];
    }
}
$esNueva = !$existentes;
?>
<p><strong><?= htmlspecialchars($nombreMateria) ?></strong> · Grupo <?= htmlspecialchars($nombreGrupo) ?> · Parcial <?= $ctx["parcial"] ?>
   <a href="<?= enlace($ctx + ["paso" => 2]) ?>">← historial</a></p>
<p>Hora actual: <strong id="reloj">--:--:--</strong></p>

<?php if (!$alumnos): ?>
  <p>Este grupo no tiene alumnos.</p>
<?php else: ?>
<form method="post">
  <input type="hidden" name="accion" value="guardar">
  <p>
    <label>Fecha:
      <input type="date" name="fecha" value="<?= htmlspecialchars($fecha) ?>" required
             onchange="location.href='<?= enlace($ctx + ["paso" => 3]) ?>&fecha='+this.value">
    </label>
    <label>Hora:
      <input type="time" name="hora" id="hora" value="<?= $horaGuardada ? substr($horaGuardada, 0, 5) : date("H:i") ?>"
             <?= $esNueva ? 'data-auto="1"' : "" ?> required>
    </label>
  </p>
  <p><?= $esNueva ? "Lista nueva: todos aparecen con ✓, quita la palomita a quien faltó." : "Corrigiendo la lista de esta fecha." ?></p>

  <table>
    <tr><th>Matrícula</th><th>Alumno</th><th>Asistió</th></tr>
    <?php foreach ($alumnos as $a):
          $marcado = $esNueva ? true : !empty($existentes[$a["id_alumno"]]); ?>
    <tr>
      <td><?= htmlspecialchars($a["matricula"]) ?></td>
      <td><?= htmlspecialchars($a["apellidos"] . " " . $a["nombre"]) ?></td>
      <td class="centro"><input type="checkbox" name="presente[<?= $a["id_alumno"] ?>]" <?= $marcado ? "checked" : "" ?>></td>
    </tr>
    <?php endforeach; ?>
  </table>
  <br>
  <button>Guardar asistencia</button>
</form>

<?php if (!$esNueva): ?>
<form method="post" onsubmit="return confirm('¿Borrar la lista de esta fecha?')">
  <input type="hidden" name="accion" value="borrar">
  <input type="hidden" name="fecha" value="<?= htmlspecialchars($fecha) ?>">
  <button>Borrar esta lista</button>
</form>
<?php endif; ?>
<?php endif; ?>

<script>
function tic() {
  var d = new Date();
  var hh = String(d.getHours()).padStart(2, "0"), mm = String(d.getMinutes()).padStart(2, "0"), ss = String(d.getSeconds()).padStart(2, "0");
  document.getElementById("reloj").textContent = hh + ":" + mm + ":" + ss;
  var campo = document.getElementById("hora");
  if (campo && campo.dataset.auto === "1" && !campo.dataset.tocado) campo.value = hh + ":" + mm;
}
var campoHora = document.getElementById("hora");
if (campoHora) campoHora.addEventListener("input", function () { campoHora.dataset.tocado = "1"; });
tic(); setInterval(tic, 1000);
</script>
<?php endif; ?>
</body>
</html>
