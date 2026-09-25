<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>1. Alumnos - P7</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-gotico">
        <nav class="nav-menu">
            <a href="index.php">Inicio</a>
            <a href="alumnos.php" class="activo">1. Alumnos</a>
            <a href="productos.php">2. Productos</a>
            <a href="series.php">3. Series</a>
        </nav>

        <h2>Control de Alumnos</h2>

        <?php if (!isset($_POST['paso2']) && !isset($_POST['paso3'])): ?>
            <form action="alumnos.php" method="POST">
                <label>Número de alumnos:</label>
                <input type="number" name="num_alumnos" min="1" required placeholder="Ej. 2">
                <button type="submit" name="paso2">Continuar</button>
            </form>
        <?php endif; ?>

        <?php if (isset($_POST['paso2'])): 
            $num = (int)$_POST['num_alumnos'];
        ?>
            <form action="alumnos.php" method="POST">
                <input type="hidden" name="num_alumnos" value="<?php echo $num; ?>">
                <?php for ($i = 1; $i <= $num; $i++): ?>
                    <div class="bloque-alumno">
                        <h3>Alumno <?php echo $i; ?></h3>
                        <label>Nombre:</label>
                        <input type="text" name="nombre[]" required placeholder="Ej. Juan">
                        <label>Calificación 1:</label>
                        <input type="number" name="cal1[]" step="0.1" min="0" max="10" required placeholder="Ej. 6">
                        <label>Calificación 2:</label>
                        <input type="number" name="cal2[]" step="0.1" min="0" max="10" required placeholder="Ej. 8">
                        <label>Calificación 3:</label>
                        <input type="number" name="cal3[]" step="0.1" min="0" max="10" required placeholder="Ej. 9">
                    </div>
                <?php endfor; ?>
                <button type="submit" name="paso3">Calcular Promedios</button>
            </form>
        <?php endif; ?>

        <?php if (isset($_POST['paso3'])): 
            $nombres = $_POST['nombre'];
            $cal1 = $_POST['cal1'];
            $cal2 = $_POST['cal2'];
            $cal3 = $_POST['cal3'];
        ?>
            <h3>Resultados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Promedio</th>
                        <th>Situación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($nombres); $i++): 
                        $promedio = ($cal1[$i] + $cal2[$i] + $cal3[$i]) / 3;
                        $situacion = ($promedio >= 6) ? "Ap" : "NAp";
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($nombres[$i]); ?></td>
                            <td><?php echo number_format($promedio, 1); ?></td>
                            <td><strong><?php echo $situacion; ?></strong></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <br>
            <a href="alumnos.php"><button type="button">Realizar otro cálculo</button></a>
        <?php endif; ?>
    </div>
</body>
</html>