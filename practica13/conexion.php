<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_OFF);

$usuario    = "root";
$base_datos = "5BVP";
$hosts      = ["localhost", "127.0.0.1"];
$passwords  = ["abcd1234", ""];   // prueba tu contraseña y también sin contraseña (XAMPP por defecto)

// ---- Listas del <select> (pizarrón: Carrera -> Select(4), Grupo -> Select(4)). Cámbialas si quieres ----
$carreras = ["Programación", "Contabilidad", "Electrónica", "Mecánica"];
$grupos   = ["5AVP", "5BVP", "5CVP", "5DVP"];

// ---- Calificación mínima para aprobar ----
$minima_aprobatoria = 6;

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

mysqli_query($conexion, "CREATE DATABASE IF NOT EXISTS `$base_datos` CHARACTER SET utf8mb4");
if (!mysqli_select_db($conexion, $base_datos)) {
    die("<h3 style='color:red'>No se pudo usar la base de datos $base_datos: " . htmlspecialchars(mysqli_error($conexion)) . "</h3>");
}

// Si existe una tabla Alumnos con otra estructura, se respalda con otro nombre
$r = mysqli_query($conexion, "SHOW TABLES LIKE 'Alumnos'");
if ($r && mysqli_num_rows($r) > 0) {
    $c = mysqli_query($conexion, "SHOW COLUMNS FROM Alumnos LIKE 'Id_control'");
    if ($c && mysqli_num_rows($c) == 0) {
        mysqli_query($conexion, "DROP TABLE IF EXISTS Alumnos_vieja");
        mysqli_query($conexion, "RENAME TABLE Alumnos TO Alumnos_vieja");
    }
}

$ok = mysqli_query($conexion, "CREATE TABLE IF NOT EXISTS Alumnos (
    Id_control VARCHAR(10)  NOT NULL PRIMARY KEY,
    Nombre     VARCHAR(40)  NOT NULL,
    Carrera    VARCHAR(30)  NOT NULL,
    Grupo      VARCHAR(10)  NOT NULL,
    Parcial_1  DECIMAL(4,1) NOT NULL,
    Parcial_2  DECIMAL(4,1) NOT NULL,
    Parcial_3  DECIMAL(4,1) NOT NULL,
    Promedio   DECIMAL(4,2) NOT NULL,
    Situacion  VARCHAR(12)  NOT NULL
)");
if (!$ok) {
    die("<h3 style='color:red'>No se pudo crear la tabla Alumnos: " . htmlspecialchars(mysqli_error($conexion)) . "</h3>");
}

// ---- Funciones de ayuda ----
function calcular($p1, $p2, $p3) {
    global $minima_aprobatoria;
    $prom = round(($p1 + $p2 + $p3) / 3, 2);
    $sit  = ($prom >= $minima_aprobatoria) ? "Aprobado" : "Reprobado";
    return [$prom, $sit];
}

function opciones($lista, $seleccionado = "") {
    $html = "";
    foreach ($lista as $item) {
        $sel = ($item === $seleccionado) ? " selected" : "";
        $html .= "<option value=\"" . htmlspecialchars($item) . "\"$sel>" . htmlspecialchars($item) . "</option>";
    }
    return $html;
}

function parcial_valido($v) {
    return is_numeric($v) && $v >= 0 && $v <= 10;
}
