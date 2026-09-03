<?php
// Inicializar variables
$nombre = $email = $mensaje = "";
$errores = [];

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar nombre
    if (empty($_POST["nombre"])) {
        $errores[] = "El nombre es obligatorio.";
    } else {
        $nombre = htmlspecialchars(trim($_POST["nombre"]));
    }

    // Validar email
    if (empty($_POST["email"])) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
    }

    // Validar mensaje
    if (empty($_POST["mensaje"])) {
        $errores[] = "El mensaje no puede estar vacío.";
    } else {
        $mensaje = htmlspecialchars(trim($_POST["mensaje"]));
    }

    // Si no hay errores, procesar los datos
    if (empty($errores)) {
        // Aquí podrías guardar en base de datos o enviar por email
        echo "<p style='color:green;'>Formulario enviado correctamente.</p>";
        // Limpiar campos después de enviar
        $nombre = $email = $mensaje = "";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario en PHP</title>
</head>
<body>
    <h2>Formulario de Contacto</h2>

    <!-- Mostrar errores -->
    <?php
    if (!empty($errores)) {
        echo "<ul style='color:red;'>";
        foreach ($errores as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>

    <!-- Formulario -->
    <form method="POST" action="">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>"><br><br>

        <label>Correo electrónico:</label><br>
        <input type="email" name="email" value="<?php echo $email; ?>"><br><br>

        <label>Mensaje:</label><br>
        <textarea name="mensaje"><?php echo $mensaje; ?></textarea><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>