<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PHP: Sumar Números</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Suma de dos números</h2>
        <form method="POST">
            <input type="number" name="n1" placeholder="Número 1" required>
            <input type="number" name="n2" placeholder="Número 2" required>
            <input type="submit" value="Calcular Suma">
        </form>

        <?php
        if ($_POST) {
            $n1 = $_POST['n1'];
            $n2 = $_POST['n2'];
            $suma = $n1 + $n2;
            echo "<div class='resultado'><h3>Resultado: $n1 + $n2 = $suma</h3></div>";
        }
        ?>
        <br>
        <a href="index.php" class="btn">← Volver al Menú Principal</a>
    </div>
</body>
</html>