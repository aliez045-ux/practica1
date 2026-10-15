<?php
require_once 'conexion.php';
echo "<h2>Diagnóstico</h2>";
echo "<p> PHP funciona (versión " . PHP_VERSION . ")</p>";
echo "<p> mysqli activo</p>";
echo "<p> Conectado a MySQL y base de datos <b>$base_datos</b> lista</p>";
echo function_exists('mysqli_stmt_get_result') ? "<p> mysqlnd activo</p>" : "<p style='color:red'>x Falta mysqlnd</p>";

$cols = mysqli_query($conexion, "SHOW COLUMNS FROM Alumnos");
$n = [];
while ($f = mysqli_fetch_assoc($cols)) { $n[] = $f['Field']; }
echo "<p>✅ Tabla Alumnos con columnas: " . htmlspecialchars(implode(", ", $n)) . "</p>";

$t = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS t FROM Alumnos"));
echo "<p>Alumnos registrados: <b>" . $t['t'] . "</b></p>";
echo "<p><a href='Base.php'>Ir al formulario</a></p>";
mysqli_close($conexion);
