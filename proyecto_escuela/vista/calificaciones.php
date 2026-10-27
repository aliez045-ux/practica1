<?php
require_once "../modelo/conexion.php";
require_once "evaluacion.php";

// ---------- Datos que se van arrastrando de paso en paso ----------
$ctx = [
    "id_grupo"    => $_GET["id_grupo"]    ?? "",
    "id_materia"  => $_GET["id_materia"]  ?? "",
    "id_profesor" => $_GET["id_profesor"] ?? "",
    "parcial"     => $_GET["parcial"]     ?? "",
];
$completo  = !in_array("", $ctx, true);
$paso      = (int) ($_GET["paso"] ?? 1);
$id_alumno = $_GET["id_alumno"] ?? "";
$TIPOS     = tipos();
$PESOS     = pesos();
$tipo      = $_GET["tipo"] ?? "tarea";
if (!isset($TIPOS[$tipo])) $tipo = "tarea";

if ($paso >= 2 && !$completo) $paso = 1;
if ($paso == 3 && $id_alumno === "") $paso = 2;

function enlace($datos) { return "calificaciones.php?" . http_build_query($datos); }

// ---------- Acciones (POST) ----------
if ($_SERVER["REQUEST_METHOD"] === "POST" && $completo) {
    $accion = $_POST["accion"] ?? "";

    // Cuántas tareas / prácticas / exámenes tiene este parcial
    if ($accion === "config") {
        $sql = $pdo->prepare("INSERT INTO config_evaluacion (id_grupo, id_materia, parcial, tipo, cantidad)
                              VALUES (?, ?, ?, ?, ?)
                              ON DUPLICATE KEY UPDATE cantidad = VALUES(cantidad)");
        foreach (array_keys($TIPOS) as $t) {
            $n = max(1, min(20, (int) ($_POST["cantidad"][$t] ?? 1)));
            $sql->execute([$ctx["id_grupo"], $ctx["id_materia"], $ctx["parcial"], $t, $n]);
        }
        header("Location: " . enlace($ctx + ["paso" => 2, "ok" => 1])); exit;
    }

    // Guardar (o corregir) las calificaciones de UN tipo de UN alumno
    if ($accion === "guardar" && $id_alumno !== "") {
        $n = cantidadActividades($pdo, $ctx["id_grupo"], $ctx["id_materia"], $ctx["parcial"], $tipo);
        $up  = $pdo->prepare("INSERT INTO calificacion (id_alumno, id_materia, id_profesor, parcial, tipo, numero, calificacion, fecha)
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                              ON DUPLICATE KEY UPDATE calificacion = VALUES(calificacion),
                                                      id_profesor = VALUES(id_profesor), fecha = VALUES(fecha)");
        $del = $pdo->prepare("DELETE FROM calificacion WHERE id_alumno=? AND id_materia=? AND parcial=? AND tipo=? AND numero=?");
        $hayError = false;
        for ($i = 1; $i <= $n; $i++) {
            $v = trim(str_replace(",", ".", $_POST["cal"][$i] ?? ""));
            if ($v === "") {                                   // vacío = sin calificación
                $del->execute([$id_alumno, $ctx["id_materia"], $ctx["parcial"], $tipo, $i]);
            } elseif (is_numeric($v) && $v >= 0 && $v <= 10) {
                $up->execute([$id_alumno, $ctx["id_materia"], $ctx["id_profesor"], $ctx["parcial"],
                              $tipo, $i, $v, date("Y-m-d")]);
            } else {
                $hayError = true;
            }
        }
        header("Location: " . enlace($ctx + ["paso" => 3, "id_alumno" => $id_alumno, "tipo" => $tipo, ($hayError ? "err" : "ok") => 1]));
        exit;
    }
}

// ---------- Datos para mostrar ----------
$grupos     = $pdo->query("SELECT id_grupo, grado, grupo FROM grupo_grado ORDER BY grado, grupo")->fetchAll();
$materias   = $pdo->query("SELECT * FROM materia ORDER BY nombre")->fetchAll();
$profesores = $pdo->query("SELECT * FROM profesor ORDER BY apellidos, nombre")->fetchAll();

if ($completo) {
    $q = $pdo->prepare("SELECT CONCAT(grado,'° ',grupo) FROM grupo_grado WHERE id_grupo=?");
    $q->execute([$ctx["id_grupo"]]);            $nombreGrupo = $q->fetchColumn();
    $q = $pdo->prepare("SELECT nombre FROM materia WHERE id_materia=?");
    $q->execute([$ctx["id_materia"]]);          $nombreMateria = $q->fetchColumn();
    $q = $pdo->prepare("SELECT CONCAT(nombre,' ',apellidos) FROM profesor WHERE id_profesor=?");
    $q->execute([$ctx["id_profesor"]]);         $nombreProfesor = $q->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Calificaciones</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Registrar calificaciones</h1>
<p class="pasos">Paso <?= $paso ?> de 3:
  <?= [1 => "elige grupo, materia y parcial", 2 => "elige al alumno", 3 => "captura las calificaciones"][$paso] ?></p>

<?php if (isset($_GET["ok"])): ?><p class="mensaje">Guardado ✓</p><?php endif; ?>
<?php if (isset($_GET["err"])): ?><p class="mensaje">Alguna calificación no se guardó: debe estar entre 0 y 10.</p><?php endif; ?>

<?php if ($paso == 1): ?>
<!-- ================= PASO 1 ================= -->
<form method="get">
  <input type="hidden" name="paso" value="2">
  <p>
    <label>Grupo:
      <select name="id_grupo" required>
        <option value="">-- Seleccionar --</option>
        <?php foreach ($grupos as $g): ?>
          <option value="<?= $g["id_grupo"] ?>" <?= $ctx["id_grupo"] == $g["id_grupo"] ? "selected" : "" ?>><?= $g["grado"] . "° " . htmlspecialchars($g["grupo"]) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </p>
  <p>
    <label>Materia:
      <select name="id_materia" required>
        <option value="">-- Seleccionar --</option>
        <?php foreach ($materias as $m): ?>
          <option value="<?= $m["id_materia"] ?>" <?= $ctx["id_materia"] == $m["id_materia"] ? "selected" : "" ?>><?= htmlspecialchars($m["nombre"]) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </p>
  <p>
    <label>Profesor que la imparte:
      <select name="id_profesor" required>
        <option value="">-- Seleccionar --</option>
        <?php foreach ($profesores as $p): ?>
          <option value="<?= $p["id_profesor"] ?>" <?= $ctx["id_profesor"] == $p["id_profesor"] ? "selected" : "" ?>><?= htmlspecialchars($p["nombre"] . " " . $p["apellidos"]) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </p>
  <p>
    <label>Parcial:
      <select name="parcial" required>
        <option value="1" <?= $ctx["parcial"] == 1 ? "selected" : "" ?>>1</option>
        <option value="2" <?= $ctx["parcial"] == 2 ? "selected" : "" ?>>2</option>
      </select>
    </label>
  </p>
  <button>Continuar →</button>
</form>

<h2>Cómo se evalúa</h2>
<table>
  <tr><th>Concepto</th><th>Vale</th></tr>
  <tr><td>Examen</td><td><?= $PESOS["examen"] ?>%</td></tr>
  <tr><td>Prácticas</td><td><?= $PESOS["practica"] ?>%</td></tr>
  <tr><td>Tareas</td><td><?= $PESOS["tarea"] ?>%</td></tr>
  <tr><td>Asistencia</td><td><?= $PESOS["asistencia"] ?>%</td></tr>
</table>

<?php elseif ($paso == 2): ?>
<!-- ================= PASO 2 ================= -->
<p><strong><?= htmlspecialchars($nombreMateria) ?></strong> · Grupo <?= htmlspecialchars($nombreGrupo) ?> ·
   Parcial <?= $ctx["parcial"] ?> · Prof. <?= htmlspecialchars($nombreProfesor) ?>
   <a href="<?= enlace($ctx + ["paso" => 1]) ?>">(cambiar)</a></p>

<h2>¿Cuántas actividades tiene este parcial?</h2>
<p>Si hay 2 tareas, cada una vale la mitad del <?= $PESOS["tarea"] ?>% de tareas.</p>
<form method="post">
  <input type="hidden" name="accion" value="config">
  <?php foreach ($TIPOS as $clave => $nombres): ?>
    <label><?= $nombres[1] ?>:
      <input type="number" name="cantidad[<?= $clave ?>]" min="1" max="20" style="width:70px"
             value="<?= cantidadActividades($pdo, $ctx["id_grupo"], $ctx["id_materia"], $ctx["parcial"], $clave) ?>">
    </label>
  <?php endforeach; ?>
  <button>Guardar cantidades</button>
</form>

<h2>Elige al alumno</h2>
<?php
$q = $pdo->prepare("SELECT id_alumno, matricula, nombre, apellidos FROM alumno WHERE id_grupo=? ORDER BY apellidos, nombre");
$q->execute([$ctx["id_grupo"]]);
$alumnos = $q->fetchAll();
?>
<?php if (!$alumnos): ?>
  <p>Este grupo no tiene alumnos. Regístralos primero en <a href="alumnos.php">Alumnos</a>.</p>
<?php else: ?>
<table>
  <tr><th>Matrícula</th><th>Alumno</th><th>Parcial <?= $ctx["parcial"] ?></th><th></th></tr>
  <?php foreach ($alumnos as $a):
        $res = resultadoParcial($pdo, $a["id_alumno"], $ctx["id_grupo"], $ctx["id_materia"], $ctx["parcial"]); ?>
  <tr>
    <td><?= htmlspecialchars($a["matricula"]) ?></td>
    <td><?= htmlspecialchars($a["apellidos"] . " " . $a["nombre"]) ?></td>
    <td class="centro"><?= number_format($res["total"], 1) ?></td>
    <td><a href="<?= enlace($ctx + ["paso" => 3, "id_alumno" => $a["id_alumno"], "tipo" => "tarea"]) ?>">Calificar →</a></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>

<?php else: ?>
<!-- ================= PASO 3 ================= -->
<?php
$q = $pdo->prepare("SELECT matricula, nombre, apellidos FROM alumno WHERE id_alumno=?");
$q->execute([$id_alumno]);
$al = $q->fetch();
$n = cantidadActividades($pdo, $ctx["id_grupo"], $ctx["id_materia"], $ctx["parcial"], $tipo);

$q = $pdo->prepare("SELECT numero, calificacion FROM calificacion WHERE id_alumno=? AND id_materia=? AND parcial=? AND tipo=?");
$q->execute([$id_alumno, $ctx["id_materia"], $ctx["parcial"], $tipo]);
$actuales = [];
foreach ($q->fetchAll() as $r) $actuales[$r["numero"]] = $r["calificacion"];
$res = resultadoParcial($pdo, $id_alumno, $ctx["id_grupo"], $ctx["id_materia"], $ctx["parcial"]);
?>
<p><strong><?= htmlspecialchars($al["apellidos"] . " " . $al["nombre"]) ?></strong> (<?= htmlspecialchars($al["matricula"]) ?>) ·
   <?= htmlspecialchars($nombreMateria) ?> · Parcial <?= $ctx["parcial"] ?>
   <a href="<?= enlace($ctx + ["paso" => 2]) ?>">← otro alumno</a></p>

<!-- Un tipo a la vez -->
<p class="tabs">
  <?php foreach ($TIPOS as $clave => $nombres): ?>
    <a class="<?= $clave == $tipo ? "activo" : "" ?>"
       href="<?= enlace($ctx + ["paso" => 3, "id_alumno" => $id_alumno, "tipo" => $clave]) ?>"><?= $nombres[1] ?></a>
  <?php endforeach; ?>
</p>

<form method="post">
  <input type="hidden" name="accion" value="guardar">
  <h2><?= $TIPOS[$tipo][1] ?></h2>
  <p>Hay <?= $n ?> <?= mb_strtolower($n == 1 ? $TIPOS[$tipo][0] : $TIPOS[$tipo][1]) ?>;
     cada una vale <?= round($PESOS[$tipo] / $n, 2) ?>% del parcial.
     Deja vacío si aún no tiene calificación.</p>
  <?php for ($i = 1; $i <= $n; $i++): ?>
    <p>
      <label><?= $TIPOS[$tipo][0] ?> <?= $i ?> (0-10):
        <input type="number" name="cal[<?= $i ?>]" min="0" max="10" step="0.1"
               value="<?= isset($actuales[$i]) ? $actuales[$i] + 0 : "" ?>">
      </label>
    </p>
  <?php endfor; ?>
  <button>Guardar <?= mb_strtolower($TIPOS[$tipo][1]) ?></button>
</form>

<h2>Resumen del parcial <?= $ctx["parcial"] ?></h2>
<table>
  <tr><th>Concepto</th><th>Calificación</th><th>Vale</th><th>Aporta</th></tr>
  <?php foreach ($TIPOS as $clave => $nombres): ?>
  <tr>
    <td><?= $nombres[1] ?></td>
    <td class="centro"><?= number_format($res["detalle"][$clave]["puntos"], 1) ?></td>
    <td class="centro"><?= $PESOS[$clave] ?>%</td>
    <td class="centro"><?= number_format($res["detalle"][$clave]["aporta"], 2) ?></td>
  </tr>
  <?php endforeach; ?>
  <tr>
    <td>Asistencia (<?= $res["detalle"]["asistencia"]["asistio"] ?> de <?= $res["detalle"]["asistencia"]["clases"] ?>)</td>
    <td class="centro"><?= number_format($res["detalle"]["asistencia"]["puntos"], 1) ?></td>
    <td class="centro"><?= $PESOS["asistencia"] ?>%</td>
    <td class="centro"><?= number_format($res["detalle"]["asistencia"]["aporta"], 2) ?></td>
  </tr>
  <tr><td colspan="3"><strong>Total del parcial</strong></td><td class="centro"><strong><?= number_format($res["total"], 1) ?></strong></td></tr>
</table>
<?php endif; ?>
</body>
</html>
