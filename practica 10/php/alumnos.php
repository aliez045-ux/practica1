<?php
session_start();
if (!isset($_SESSION['usuario'])) { 
    header("Location: login.php"); 
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>2. Alumnos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="container">
    <h2>2. Control de Alumnos</h2>

    <?php if (!isset($_POST['cant_alum']) && !isset($_POST['calcular'])): ?>
        <form method="POST">
            <label>¿Cuántos alumnos son?</label>
            <input type="number" name="cant_alum" min="1" required>
            <input type="submit" value="Continuar">
        </form>
    <?php endif; ?>

    <?php if (isset($_POST['cant_alum'])): 
        $cant = $_POST['cant_alum'];
    ?>
        <form method="POST">
            <?php for ($i = 1; $i <= $cant; $i++): ?>
                <h3>Alumno <?php echo $i; ?></h3>
                <label>Nombre:</label> <input type="text" name="nombre[]" required>
                <label>Parcial 1:</label> <input type="number" step="0.1" name="p1[]" min="0" max="10" required>
                <label>Parcial 2:</label> <input type="number" step="0.1" name="p2[]" min="0" max="10" required>
                <hr style="border: 0; border-top: 1px dashed #732228; margin: 15px 0;">
            <?php endfor; ?>
            <input type="submit" name="calcular" value="Calcular Promedios">
        </form>
    <?php endif; ?>

    <?php if (isset($_POST['calcular'])): 
        $nombres = $_POST['nombre'];
        $p1 = $_POST['p1'];
        $p2 = $_POST['p2'];
        $suma_promedios = 0;
        $total_alumnos = count($nombres);
    ?>
        <h3>Resultados</h3>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Parcial 1</th>
                <th>Parcial 2</th>
                <th>Promedio</th>
                <th>Situación</th>
            </tr>
            <?php for ($i = 0; $i < $total_alumnos; $i++): 
                $promedio = ($p1[$i] + $p2[$i]) / 2;
                $suma_promedios += $promedio;
                $situacion = ($promedio >= 6) ? "Aprobado" : "Reprobado";
            ?>
            <tr>
                <td><?php echo htmlspecialchars($nombres[$i]); ?></td>
                <td><?php echo $p1[$i]; ?></td>
                <td><?php echo $p2[$i]; ?></td>
                <td><?php echo number_format($promedio, 2); ?></td>
                <td><?php echo $situacion; ?></td>
            </tr>
            <?php endfor; ?>
        </table>

        <h3>Promedio General: <?php echo number_format($suma_promedios / $total_alumnos, 2); ?></h3>
        <br>
        <a href="alumnos.php">Nuevo Cálculo</a>
    <?php endif; ?>

    <br><br>
    <a href="menu.php">← Volver al Menú</a>
</div>

</body>
</html>