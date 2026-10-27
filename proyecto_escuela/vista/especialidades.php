<?php
require_once "../modelo/conexion.php";

if (isset($_POST["guardar"])) {
    $pdo->prepare("INSERT INTO especialidad (nombre) VALUES (?)")->execute([trim($_POST["nombre"])]);
    header("Location: especialidades.php"); exit;
}
if (isset($_GET["borrar"])) {
    $pdo->prepare("DELETE FROM especialidad WHERE id_especialidad = ?")->execute([$_GET["borrar"]]);
    header("Location: especialidades.php"); exit;
}
$lista = $pdo->query("SELECT * FROM especialidad ORDER BY id_especialidad")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Especialidades</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Especialidades</h1>

<form method="post">
  <input type="text" name="nombre" placeholder="Ej: Programación" required>
  <button name="guardar">Guardar</button>
</form>

<table>
  <tr><th>ID</th><th>Nombre</th><th></th></tr>
  <?php foreach ($lista as $e): ?>
  <tr>
    <td><?= $e["id_especialidad"] ?></td>
    <td><?= htmlspecialchars($e["nombre"]) ?></td>
    <td><a href="?borrar=<?= $e["id_especialidad"] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
  </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
