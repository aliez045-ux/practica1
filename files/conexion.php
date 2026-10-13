<?php
// Muestra errores en pantalla para poder ver qué pasa
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_OFF);

$usuario    = "root";
$base_datos = "5BVP";
$hosts      = ["localhost", "127.0.0.1"];
$passwords  = ["abcd1234", ""];   // prueba tu contraseña y también sin contraseña (XAMPP por defecto)

if (!function_exists('mysqli_connect')) {
    die("<h3 style='color:red'>La extensión mysqli no está activada en PHP. Abre php.ini, quita el ';' de 'extension=mysqli' y reinicia Apache.</h3>");
}

$conexion = false;
$ultimo_error = "";
foreach ($hosts as $h) {
    foreach ($passwords as $p) {
        $c = @mysqli_connect($h, $usuario, $p);
        if ($c) { $conexion = $c; break 2; }
        $ultimo_error = mysqli_connect_error();
    }
}

if (!$conexion) {
    die("<h3 style='color:red'>No se pudo conectar a MySQL.</h3>
         <p>1) Revisa en el panel de XAMPP que <b>MySQL esté en verde (Start)</b>.<br>
            2) Si sigue fallando, la contraseña de root no es 'abcd1234' ni vacía: cámbiala en <b>conexion.php</b> (línea \$passwords).</p>
         <p>Error de MySQL: " . htmlspecialchars($ultimo_error) . "</p>");
}

mysqli_set_charset($conexion, "utf8mb4");

// Crear la base de datos si no existe y seleccionarla
mysqli_query($conexion, "CREATE DATABASE IF NOT EXISTS `$base_datos` CHARACTER SET utf8mb4");
if (!mysqli_select_db($conexion, $base_datos)) {
    die("<h3 style='color:red'>No se pudo usar la base de datos $base_datos: " . htmlspecialchars(mysqli_error($conexion)) . "</h3>");
}

// Si existe una tabla agenda vieja (con Idusuario), se respalda con otro nombre
$r = mysqli_query($conexion, "SHOW TABLES LIKE 'agenda'");
if ($r && mysqli_num_rows($r) > 0) {
    $c = mysqli_query($conexion, "SHOW COLUMNS FROM agenda LIKE 'Id_persona'");
    if ($c && mysqli_num_rows($c) == 0) {
        mysqli_query($conexion, "DROP TABLE IF EXISTS agenda_vieja");
        mysqli_query($conexion, "RENAME TABLE agenda TO agenda_vieja");
    }
}

// Crear la tabla del pizarrón si no existe
$ok = mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS agenda (
    Id_persona VARCHAR(8)  NOT NULL PRIMARY KEY,
    Nombre     VARCHAR(30) NOT NULL,
    Direccion  VARCHAR(40) NOT NULL,
    Email      VARCHAR(40) NOT NULL,
    Telefono   VARCHAR(12) NOT NULL,
    Sexo       VARCHAR(1)  NOT NULL
)");
if (!$ok) {
    die("<h3 style='color:red'>No se pudo crear la tabla agenda: " . htmlspecialchars(mysqli_error($conexion)) . "</h3>");
}
