<?php
require_once "../modelo/conexion.php";

if (isset($_POST["guardar"])) {
    $pdo->prepare("INSERT INTO grupo_grado (grado, grupo, id_especialidad, id_turno, id_ciclo) VALUES (?, ?, ?, ?, ?)")
        ->execute([
            $_POST["grado"],
            strtoupper(trim($_POST["grupo"])),
            $_POST["id_especialidad"] ?: null,
            $_POST["id_turno"] ?: null,
            $_POST["id_ciclo"] ?: null,
        ]);
    header("Location: grupos.php"); exit;
}
if (isset($_GET["borrar"])) {
    $pdo->prepare("DELETE FROM grupo_grado WHERE id_grupo = ?")->execute([$_GET["borrar"]]);
    header("Location: grupos.php"); exit;
}

$especialidades = $pdo->query("SELECT * FROM especialidad ORDER BY nombre")->fetchAll();
$turnos         = $pdo->query("SELECT * FROM turno ORDER BY nombre")->fetchAll();
$ciclos         = $pdo->query("SELECT * FROM ciclo_escolar ORDER BY nombre DESC")->fetchAll();

$lista = $pdo->query("
    SELECT g.*, e.nombre AS especialidad, t.nombre AS turno, c.nombre AS ciclo
    FROM grupo_grado g
    LEFT JOIN especialidad e ON e.id_especialidad = g.id_especialidad
    LEFT JOIN turno t ON t.id_turno = g.id_turno
    LEFT JOIN ciclo_escolar c ON c.id_ciclo = g.id_ciclo
    ORDER BY g.grado, g.grupo
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Grupo y grado</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Grupo y grado</h1>

<form method="post">
  <input type="number" name="grado" placeholder="Grado" min="1" max="9" required>
  <input type="text" name="grupo" placeholder="Grupo (A, B...)" maxlength="5" required>

  <select name="id_especialidad">
    <option value="">-- Especialidad --</option>
    <?php foreach ($especialidades as $e): ?>
      <option value="<?= $e["id_especialidad"] ?>"><?= htmlspecialchars($e["nombre"]) ?></option>
    <?php endforeach; ?>
  </select>

  <select name="id_turno">
    <option value="">-- Turno --</option>
    <?php foreach ($turnos as $t): ?>
      <option value="<?= $t["id_turno"] ?>"><?= htmlspecialchars($t["nombre"]) ?></option>
    <?php endforeach; ?>
  </select>

  <select name="id_ciclo">
    <option value="">-- Ciclo escolar --</option>
    <?php foreach ($ciclos as $c): ?>
      <option value="<?= $c["id_ciclo"] ?>"><?= htmlspecialchars($c["nombre"]) ?></option>
    <?php endforeach; ?>
  </select>

  <button name="guardar">Guardar</button>
</form>

<table>
  <tr><th>ID</th><th>Grado</th><th>Grupo</th><th>Especialidad</th><th>Turno</th><th>Ciclo</th><th></th></tr>
  <?php foreach ($lista as $g): ?>
  <tr>
    <td><?= $g["id_grupo"] ?></td>
    <td><?= $g["grado"] ?></td>
    <td><?= htmlspecialchars($g["grupo"]) ?></td>
    <td><?= htmlspecialchars($g["especialidad"] ?? "") ?></td>
    <td><?= htmlspecialchars($g["turno"] ?? "") ?></td>
    <td><?= htmlspecialchars($g["ciclo"] ?? "") ?></td>
    <td><a href="?borrar=<?= $g["id_grupo"] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
  </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
