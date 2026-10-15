<?php
require_once 'conexion.php';
$resultado = mysqli_query($conexion, "SELECT Id_control, Nombre, Carrera, Grupo, Parcial_1, Parcial_2, Parcial_3, Promedio, Situacion FROM Alumnos ORDER BY Id_control");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Alumnos</title>
    <style>
        table { width: 95%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; }
        table, th, td { border: 1px solid #aaa; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .Aprobado { color: green; font-weight: bold; }
        .Reprobado { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Lista de Alumnos</h2>
    <a href="Base.php"> Agregar alumno</a>
    <br><br>
    <?php
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo "<table><thead><tr><th>Id Control</th><th>Nombre</th><th>Carrera</th><th>Grupo</th><th>Parcial 1</th><th>Parcial 2</th><th>Parcial 3</th><th>Promedio</th><th>Situación</th></tr></thead><tbody>";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['Id_control']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Carrera']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Grupo']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Parcial_1']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Parcial_2']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Parcial_3']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Promedio']) . "</td>";
            echo "<td class='" . htmlspecialchars($fila['Situacion']) . "'>" . htmlspecialchars($fila['Situacion']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No hay alumnos registrados todavía.</p>";
    }
    mysqli_close($conexion);
    ?>
</body>
</html>
