<?php
require_once "../modelo/conexion.php";

if (isset($_POST["guardar"])) {
    $pdo->prepare("INSERT INTO ciclo_escolar (nombre) VALUES (?)")->execute([trim($_POST["nombre"])]);
    header("Location: ciclos.php"); exit;
}
if (isset($_GET["borrar"])) {
    $pdo->prepare("DELETE FROM ciclo_escolar WHERE id_ciclo = ?")->execute([$_GET["borrar"]]);
    header("Location: ciclos.php"); exit;
}
$lista = $pdo->query("SELECT * FROM ciclo_escolar ORDER BY id_ciclo")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Ciclo escolar</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Ciclo escolar</h1>

<form method="post">
  <input type="text" name="nombre" placeholder="Ej: 2026-2027" required>
  <button name="guardar">Guardar</button>
</form>

<table>
  <tr><th>ID</th><th>Ciclo</th><th></th></tr>
  <?php foreach ($lista as $c): ?>
  <tr>
    <td><?= $c["id_ciclo"] ?></td>
    <td><?= htmlspecialchars($c["nombre"]) ?></td>
    <td><a href="?borrar=<?= $c["id_ciclo"] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
  </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
