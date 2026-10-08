<?php
require_once '../modelo/conexion.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $especie = $conexion->real_escape_string($_POST['especie']);
    $habitat = $conexion->real_escape_string($_POST['habitat']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $imagen_url = $conexion->real_escape_string($_POST['imagen_url']);

    $sql = "UPDATE animales SET nombre='$nombre', especie='$especie', habitat='$habitat', descripcion='$descripcion', imagen_url='$imagen_url' WHERE id=$id";
    if ($conexion->query($sql)) {
        header("Location: animales_marinos.php");
        exit;
    }
}

$res = $conexion->query("SELECT * FROM animales WHERE id=$id");
$animal = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Registro</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <h2>Modificar Animal Marino #<?php echo $animal['id']; ?></h2>
    <form method="POST">
        Nombre: <br><input type="text" name="nombre" value="<?php echo htmlspecialchars($animal['nombre']); ?>" required><br><br>
        Especie: <br><input type="text" name="especie" value="<?php echo htmlspecialchars($animal['especie']); ?>" required><br><br>
        Hábitat: <br><input type="text" name="habitat" value="<?php echo htmlspecialchars($animal['habitat']); ?>"><br><br>
        URL Imagen: <br><input type="url" name="imagen_url" value="<?php echo htmlspecialchars($animal['imagen_url']); ?>"><br><br>
        Descripción: <br><textarea name="descripcion"><?php echo htmlspecialchars($animal['descripcion']); ?></textarea><br><br>
        <button type="submit">Actualizar</button>
        <a href="animales_marinos.php">Cancelar</a>
    </form>
</body>
</html>