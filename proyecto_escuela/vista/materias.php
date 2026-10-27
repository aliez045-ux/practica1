<?php
require_once "../modelo/conexion.php";

if (isset($_POST["guardar"])) {
    $pdo->prepare("INSERT INTO materia (nombre) VALUES (?)")->execute([trim($_POST["nombre"])]);
    header("Location: materias.php"); exit;
}
if (isset($_GET["borrar"])) {
    $pdo->prepare("DELETE FROM materia WHERE id_materia = ?")->execute([$_GET["borrar"]]);
    header("Location: materias.php"); exit;
}
$lista = $pdo->query("SELECT * FROM materia ORDER BY nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Materias</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Materias</h1>

<form method="post">
  <input type="text" name="nombre" placeholder="Nombre de la materia" required>
  <button name="guardar">Guardar</button>
</form>

<table>
  <tr><th>ID</th><th>Materia</th><th></th></tr>
  <?php foreach ($lista as $m): ?>
  <tr>
    <td><?= $m["id_materia"] ?></td>
    <td><?= htmlspecialchars($m["nombre"]) ?></td>
    <td><a href="?borrar=<?= $m["id_materia"] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
  </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
