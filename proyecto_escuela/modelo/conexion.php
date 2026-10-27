<?php
date_default_timezone_set("America/Mexico_City");
// Conexión a la base de datos (único archivo PHP dentro de /modelo)
$host = "localhost";
$bd   = "escuela";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$bd;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
