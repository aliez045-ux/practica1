<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>1. Examen en Línea de Programación</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <a href="../index.php">← Regresar al Menú</a>
    <h2>Examen en Línea de Programación</h2>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = htmlspecialchars($_POST['nombre']);
        $grupo = htmlspecialchars($_POST['grupo']);
        
        $respuestas_correctas = [
            'p1' => 'b', 'p2' => 'a', 'p3' => 'c', 'p4' => 'b', 'p5' => 'a',
            'p6' => 'c', 'p7' => 'b', 'p8' => 'a', 'p9' => 'c', 'p10' => 'b'
        ];

        $aciertos = 0;
        foreach ($respuestas_correctas as $p => $correcta) {
            if (isset($_POST[$p]) && $_POST[$p] == $correcta) {
                $aciertos++;
            }
        }

        echo "<h3>Resultados para $nombre ($grupo):</h3>";
        echo "<p>Aciertos: $aciertos / 10</p>";
        echo "<p>Calificación final: " . ($aciertos * 10) . " / 100</p>";
        echo "<hr><a href='examen.php'>Realizar otro examen</a>";
    } else {
    ?>

    <form method="POST" action="examen.php">
        <label>Nombre completo:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Grupo:</label><br>
        <input type="text" name="grupo" required><br><br>

        <hr>

        <p>1. ¿Qué significa HTML?</p>
        <input type="radio" name="p1" value="a"> High Text Markup Language<br>
        <input type="radio" name="p1" value="b" required> HyperText Markup Language<br>
        <input type="radio" name="p1" value="c"> Hyper Tech Main Language<br><br>

        <p>2. ¿Para qué se utiliza el lenguaje CSS?</p>
        <input type="radio" name="p2" value="a" required> Dar estilo y diseño a páginas web<br>
        <input type="radio" name="p2" value="b"> Crear bases de datos<br>
        <input type="radio" name="p2" value="c"> Realizar respaldos del servidor<br><br>

        <p>3. ¿Qué símbolo se usa para definir una variable en PHP?</p>
        <input type="radio" name="p3" value="a"> #<br>
        <input type="radio" name="p3" value="b"> &<br>
        <input type="radio" name="p3" value="c" required>$<br><br>

        <p>4. ¿Cuál comando SQL se utiliza para insertar registros?</p>
        <input type="radio" name="p4" value="a"> UPDATE<br>
        <input type="radio" name="p4" value="b" required> INSERT INTO<br>
        <input type="radio" name="p4" value="c"> ADD ROW<br><br>

        <p>5. En Javascript, ¿cuál palabra clave declara una constante?</p>
        <input type="radio" name="p5" value="a" required> const<br>
        <input type="radio" name="p5" value="b"> var<br>
        <input type="radio" name="p5" value="c"> fixed<br><br>

        <p>6. ¿Qué puerto utiliza habitualmente el servidor MySQL en XAMPP?</p>
        <input type="radio" name="p6" value="a"> 80<br>
        <input type="radio" name="p6" value="b"> 8080<br>
        <input type="radio" name="p6" value="c" required> 3306<br><br>

        <p>7. ¿Cuál es el operador de igualdad estricta (tipo y valor) en JS?</p>
        <input type="radio" name="p7" value="a"> ==<br>
        <input type="radio" name="p7" value="b" required> ===<br>
        <input type="radio" name="p7" value="c"> =<br><br>

        <p>8. ¿Qué etiqueta HTML se utiliza para incluir código JavaScript interno?</p>
        <input type="radio" name="p8" value="a" required> &lt;script&gt;<br>
        <input type="radio" name="p8" value="b"> &lt;js&gt;<br>
        <input type="radio" name="p8" value="c"> &lt;code&gt;<br><br>

        <p>9. ¿Cuál de los siguientes es un gestor de bases de datos relacional?</p>
        <input type="radio" name="p9" value="a"> HTML5<br>
        <input type="radio" name="p9" value="b"> CSS3<br>
        <input type="radio" name="p9" value="c" required> MariaDB / MySQL<br><br>

        <p>10. ¿Cuál propiedad CSS cambia el color de fondo?</p>
        <input type="radio" name="p10" value="a"> color<br>
        <input type="radio" name="p10" value="b" required> background-color<br>
        <input type="radio" name="p10" value="c"> font-style<br><br>

        <button type="submit">Calificar Examen</button>
    </form>
    <?php } ?>
</body>
</html>