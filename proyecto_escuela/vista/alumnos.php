<?php
require_once "../modelo/conexion.php";

$error = "";
if (isset($_POST["guardar"])) {
    try {
        $pdo->prepare("INSERT INTO alumno (matricula, nombre, apellidos, id_grupo) VALUES (?, ?, ?, ?)")
            ->execute([
                trim($_POST["matricula"]),
                trim($_POST["nombre"]),
                trim($_POST["apellidos"]),
                $_POST["id_grupo"] ?: null,
            ]);
        header("Location: alumnos.php"); exit;
    } catch (PDOException $e) {
        $error = "No se pudo guardar (¿matrícula repetida?).";
    }
}
if (isset($_GET["borrar"])) {
    $pdo->prepare("DELETE FROM alumno WHERE id_alumno = ?")->execute([$_GET["borrar"]]);
    header("Location: alumnos.php"); exit;
}

$grupos = $pdo->query("SELECT id_grupo, grado, grupo FROM grupo_grado ORDER BY grado, grupo")->fetchAll();
$lista = $pdo->query("
    SELECT a.*, g.grado, g.grupo
    FROM alumno a
    LEFT JOIN grupo_grado g ON g.id_grupo = a.id_grupo
    ORDER BY a.apellidos, a.nombre
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css"><title>Alumnos</title></head>
<body>
<a href="index.php">← Menú</a>
<h1>Alumnos</h1>
<?php if ($error): ?><p class="mensaje"><?= $error ?></p><?php endif; ?>

<form method="post">
  <input type="text" name="matricula" placeholder="Matrícula" required>
  <input type="text" name="nombre" placeholder="Nombre(s)" required>
  <input type="text" name="apellidos" placeholder="Apellidos" required>
  <select name="id_grupo">
    <option value="">-- Grupo --</option>
    <?php foreach ($grupos as $g): ?>
      <option value="<?= $g["id_grupo"] ?>"><?= $g["grado"] . "° " . htmlspecialchars($g["grupo"]) ?></option>
    <?php endforeach; ?>
  </select>
  <button name="guardar">Guardar</button>
</form>

<table>
  <tr><th>ID</th><th>Matrícula</th><th>Nombre</th><th>Apellidos</th><th>Grupo</th><th></th></tr>
  <?php foreach ($lista as $a): ?>
  <tr>
    <td><?= $a["id_alumno"] ?></td>
    <td><?= htmlspecialchars($a["matricula"]) ?></td>
    <td><?= htmlspecialchars($a["nombre"]) ?></td>
    <td><?= htmlspecialchars($a["apellidos"]) ?></td>
    <td><?= $a["grado"] ? $a["grado"] . "° " . htmlspecialchars($a["grupo"]) : "" ?></td>
    <td><a href="?borrar=<?= $a["id_alumno"] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a></td>
  </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
