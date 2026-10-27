<?php
require_once "../modelo/conexion.php";

if (isset($_POST["guardar"])) {
    $pdo->prepare("INSERT INTO turno (nombre) VALUES (?)")->execute([trim($_POST["nombre"])]);
    header("Location: turnos.php"); exit;
}
if (isset($_GET["borrar"])) {
    $pdo->prepare("DELETE FROM turno WHERE id_turno = ?")->execute([$_GET["borrar"]]);
    header("Location: turnos.php"); exit;
}
$turnos = $pdo->query("SELECT * FROM turno ORDER BY id_turno")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Turnos</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Turnos</h1>

<form method="post">
  <input type="text" name="nombre" placeholder="Ej: Matutino" required>
  <button name="guardar">Guardar</button>
</form>

<table>
  <tr><th>ID</th><th>Nombre</th><th></th></tr>
  <?php foreach ($turnos as $t): ?>
  <tr>
    <td><?= $t["id_turno"] ?></td>
    <td><?= htmlspecialchars($t["nombre"]) ?></td>
    <td><a href="?borrar=<?= $t["id_turno"] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
  </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
