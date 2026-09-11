<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PHP: Tabla de Multiplicar</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Tabla de Multiplicar con Límite</h2>
        <form method="POST">
            <input type="number" name="tabla" placeholder="Tabla del (Ej. 5)" required>
            <input type="number" name="limite" placeholder="Límite (Ej. 10)" required>
            <input type="submit" value="Generar Tabla">
        </form>

        <?php
        if ($_POST) {
            $t = $_POST['tabla'];
            $l = $_POST['limite'];
            echo "<div class='resultado'><h3>Tabla del $t hasta el $l</h3>";
            for ($i = 1; $i <= $l; $i++) {
                $res = $t * $i;
                echo "<p>$t x $i = $res</p>";
            }
            echo "</div>";
        }
        ?>
        <br>
        <a href="index.php" class="btn">← Volver al Menú Principal</a>
    </div>
</body>
</html>