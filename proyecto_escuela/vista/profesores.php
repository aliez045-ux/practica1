<?php
require_once "../modelo/conexion.php";

if (isset($_POST["guardar"])) {
    $pdo->prepare("INSERT INTO profesor (nombre, apellidos) VALUES (?, ?)")
        ->execute([trim($_POST["nombre"]), trim($_POST["apellidos"])]);
    header("Location: profesores.php"); exit;
}
if (isset($_GET["borrar"])) {
    $pdo->prepare("DELETE FROM profesor WHERE id_profesor = ?")->execute([$_GET["borrar"]]);
    header("Location: profesores.php"); exit;
}
$lista = $pdo->query("SELECT * FROM profesor ORDER BY apellidos, nombre")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Profesores</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Profesores</h1>

<form method="post">
  <input type="text" name="nombre" placeholder="Nombre(s)" required>
  <input type="text" name="apellidos" placeholder="Apellidos" required>
  <button name="guardar">Guardar</button>
</form>

<table>
  <tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th></th></tr>
  <?php foreach ($lista as $p): ?>
  <tr>
    <td><?= $p["id_profesor"] ?></td>
    <td><?= htmlspecialchars($p["nombre"]) ?></td>
    <td><?= htmlspecialchars($p["apellidos"]) ?></td>
    <td><a href="?borrar=<?= $p["id_profesor"] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
  </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
