<?php
require_once "../modelo/conexion.php";
require_once "evaluacion.php";

$id_grupo   = $_GET["id_grupo"]   ?? "";
$id_materia = $_GET["id_materia"] ?? "";
$PESOS      = pesos();

$grupos   = $pdo->query("SELECT id_grupo, grado, grupo FROM grupo_grado ORDER BY grado, grupo")->fetchAll();
$materias = $pdo->query("SELECT * FROM materia ORDER BY nombre")->fetchAll();

$filas = [];
if ($id_grupo !== "" && $id_materia !== "") {
    $q = $pdo->prepare("SELECT id_alumno, matricula, nombre, apellidos FROM alumno WHERE id_grupo = ? ORDER BY apellidos, nombre");
    $q->execute([$id_grupo]);
    foreach ($q->fetchAll() as $a) {
        $p1 = resultadoParcial($pdo, $a["id_alumno"], $id_grupo, $id_materia, 1);
        $p2 = resultadoParcial($pdo, $a["id_alumno"], $id_grupo, $id_materia, 2);
        $filas[] = [
            "alumno" => $a,
            "parciales" => [1 => $p1, 2 => $p2],
            "final" => ($p1["total"] + $p2["total"]) / 2,
        ];
    }
}

function nota($n) { return number_format($n, 1); }
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Ver resultados</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Ver resultados</h1>

<form method="get">
  <select name="id_grupo" required>
    <option value="">-- Grupo --</option>
    <?php foreach ($grupos as $g): ?>
      <option value="<?= $g["id_grupo"] ?>" <?= $id_grupo == $g["id_grupo"] ? "selected" : "" ?>>
        <?= $g["grado"] . "° " . htmlspecialchars($g["grupo"]) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <select name="id_materia" required>
    <option value="">-- Materia --</option>
    <?php foreach ($materias as $m): ?>
      <option value="<?= $m["id_materia"] ?>" <?= $id_materia == $m["id_materia"] ? "selected" : "" ?>>
        <?= htmlspecialchars($m["nombre"]) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <button>Ver resultados</button>
</form>

<?php if ($id_grupo !== "" && $id_materia !== ""): ?>
  <?php if (!$filas): ?>
    <p>Este grupo no tiene alumnos registrados.</p>
  <?php else: ?>
  <div class="tabla-scroll">
  <table class="resultados">
    <tr>
      <th rowspan="2">Matrícula</th>
      <th rowspan="2">Alumno</th>
      <th rowspan="2">Apellidos</th>
      <th colspan="5" class="centro">Parcial 1</th>
      <th colspan="5" class="centro">Parcial 2</th>
      <th rowspan="2" class="centro">Calificación final</th>
    </tr>
    <tr>
      <?php for ($i = 1; $i <= 2; $i++): ?>
        <th class="centro">Actividades</th>
        <th class="centro">Prácticas</th>
        <th class="centro">Examen</th>
        <th class="centro">Asistencias</th>
        <th class="centro">Total</th>
      <?php endfor; ?>
    </tr>
    <?php foreach ($filas as $f): ?>
    <tr>
      <td><?= htmlspecialchars($f["alumno"]["matricula"]) ?></td>
      <td><?= htmlspecialchars($f["alumno"]["nombre"]) ?></td>
      <td><?= htmlspecialchars($f["alumno"]["apellidos"]) ?></td>
      <?php foreach ([1, 2] as $p): $d = $f["parciales"][$p]["detalle"]; ?>
        <td class="centro"><?= nota($d["tarea"]["puntos"]) ?></td>
        <td class="centro"><?= nota($d["practica"]["puntos"]) ?></td>
        <td class="centro"><?= nota($d["examen"]["puntos"]) ?></td>
        <td class="centro"><?= $d["asistencia"]["asistio"] ?>/<?= $d["asistencia"]["clases"] ?></td>
        <td class="centro"><strong><?= nota($f["parciales"][$p]["total"]) ?></strong></td>
      <?php endforeach; ?>
      <td class="centro final"><?= nota($f["final"]) ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
  </div>

  <p>Actividades (tareas), prácticas y examen van de 0 a 10. Asistencias = clases a las que asistió de <?= totalAsistencias() ?>.</p>
  <p>Cada parcial vale: examen <?= $PESOS["examen"] ?>%, prácticas <?= $PESOS["practica"] ?>%,
     tareas <?= $PESOS["tarea"] ?>%, asistencia <?= $PESOS["asistencia"] ?>%.
     La calificación final es el promedio de los dos parciales.</p>
  <?php endif; ?>
<?php endif; ?>
</body>
</html>
