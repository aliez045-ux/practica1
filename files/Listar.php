<?php
require_once 'conexion.php';
$resultado = mysqli_query($conexion, "SELECT Id_persona, Nombre, Direccion, Email, Telefono, Sexo FROM agenda");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Contactos</title>
    <style>
        table { width: 80%; border-collapse: collapse; margin: 20px 0; font-family: Arial, sans-serif; }
        table, th, td { border: 1px solid #aaa; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h2>Registros en la Agenda</h2>
    <a href="Base.php">➕ Agregar nuevo registro</a>
    <br><br>
    <?php
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        echo "<table><thead><tr><th>ID Persona</th><th>Nombre</th><th>Dirección</th><th>Email</th><th>Teléfono</th><th>Sexo</th></tr></thead><tbody>";
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['Id_persona']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Direccion']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Email']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Telefono']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['Sexo']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No hay registros guardados todavía.</p>";
    }
    mysqli_close($conexion);
    ?>
</body>
</html>
