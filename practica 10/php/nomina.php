<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: login.php"); exit(); }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>1. Nómina</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="container">
    <h2>1. Cálculo de Nómina</h2>

    <?php if (!isset($_POST['cant_emp']) && !isset($_POST['calcular'])): ?>
        <form method="POST">
            <label>¿Cuántos empleados son?</label>
            <input type="number" name="cant_emp" min="1" required>
            <input type="submit" value="Continuar">
        </form>
    <?php endif; ?>

    <?php if (isset($_POST['cant_emp'])): 
        $cant = $_POST['cant_emp'];
    ?>
        <form method="POST">
            <input type="hidden" name="total_empleados" value="<?php echo $cant; ?>">
            <?php for ($i = 1; $i <= $cant; $i++): ?>
                <h3>Empleado <?php echo $i; ?></h3>
                <label>Nombre:</label> <input type="text" name="nombre[]" required>
                <label>Días trabajados:</label> <input type="number" name="dias[]" required>
                <label>Sueldo diario:</label> <input type="number" step="0.01" name="sueldo[]" required>
                <hr style="border: 0; border-top: 1px dashed #732228; margin: 15px 0;">
            <?php endfor; ?>
            <input type="submit" name="calcular" value="Calcular Total">
        </form>
    <?php endif; ?>

    <?php if (isset($_POST['calcular'])): 
        $nombres = $_POST['nombre'];
        $dias = $_POST['dias'];
        $sueldos = $_POST['sueldo'];
        $total_general = 0;
    ?>
        <table>
            <tr>
                <th>Empleado</th>
                <th>Salario Base</th>
                <th>ISR (30%) (-)</th>
                <th>Puntualidad (20%) (+)</th>
                <th>Total</th>
            </tr>
            <?php for ($i = 0; $i < count($nombres); $i++): 
                $salario = $dias[$i] * $sueldos[$i];
                $isr = $salario * 0.30;
                $puntualidad = $salario * 0.20;
                $total = $salario - $isr + $puntualidad;
                $total_general += $total;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($nombres[$i]); ?></td>
                <td>$<?php echo number_format($salario, 2); ?></td>
                <td>$<?php echo number_format($isr, 2); ?></td>
                <td>$<?php echo number_format($puntualidad, 2); ?></td>
                <td>$<?php echo number_format($total, 2); ?></td>
            </tr>
            <?php endfor; ?>
        </table>
        <h3>Total General: $<?php echo number_format($total_general, 2); ?></h3>
        <br>
        <a href="nomina.php">Nuevo Cálculo</a>
    <?php endif; ?>

    <br><br>
    <a href="menu.php">← Volver al Menú</a>
</div>

</body>
</html>