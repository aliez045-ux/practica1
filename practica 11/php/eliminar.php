<?php
require_once '../modelo/conexion.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id > 0) {
    $conexion->query("DELETE FROM animales WHERE id = $id");
}
header("Location: animales_marinos.php");
exit;
?>