<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datosFormulario = [
        'nombre' => $_POST['nombre'] ?? '',
        'email' => $_POST['email'] ?? '',
        'telefono' => $_POST['telefono'] ?? '',
        'sitio_web' => $_POST['sitio_web'] ?? '',
        'edad' => $_POST['edad'] ?? '',
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        'hora_contacto' => $_POST['hora_contacto'] ?? '',
        'genero' => $_POST['genero'] ?? '',
        'intereses' => $_POST['intereses'] ?? [],
        'pais' => $_POST['pais'] ?? '',
        'navegador' => $_POST['navegador'] ?? '',
        'nivel_ingles' => $_POST['nivel_ingles'] ?? '',
        'color' => $_POST['color'] ?? '',
        'biografia' => $_POST['biografia'] ?? ''
    ];

    if (guardarRegistro($datosFormulario, $archivo_db)) {
        $mensaje = "✨ Registro guardado exitosamente ✨";
    } else {
        $mensaje = "❌ Ocurrió un error al guardar el registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CROSS CONTRACT - Registro de Datos</title>
    <!-- Enlace al archivo CSS saliendo de la carpeta php -->
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

<div class="container">
    <h1>Cross Contract</h1>
    <p class="subtitle">✦ Registro de Datos Personales ✦</p>

    <?php if (!empty($mensaje)): ?>
        <div class="alert"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        
        <!-- Información de Cuenta -->
        <fieldset>
            <legend>Información de Cuenta e Identidad</legend>
            
            <div class="field-group">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="field-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="juan.perez@example.com" required>
            </div>

            <div class="field-group">
                <label for="password">Contraseña de Acceso:</label>
                <input type="password" id="password" name="password" required>
            </div>
        </fieldset>

        <!-- Datos Personales y Contacto -->
        <fieldset>
            <legend>Datos Personales y Contacto</legend>

            <div class="field-group">
                <label for="telefono">Teléfono Móvil:</label>
                <input type="tel" id="telefono" name="telefono" placeholder="+52 722 000 0000">
            </div>


            <div class="field-group">
                <label for="edad">Edad (en años):</label>
                <input type="number" id="edad" name="edad" min="1" max="120">
            </div>

            <div class="field-group">
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
            </div>

            <div class="field-group">
                <label for="hora_contacto">Hora preferida de contacto:</label>
                <input type="time" id="hora_contacto" name="hora_contacto">
            </div>
        </fieldset>

        <!-- Preferencias y Perfil Avanzado -->
        <fieldset>
            <legend>Preferencias y Perfil Avanzado</legend>

            <div class="field-group">
                <label>Género:</label>
                <div class="inline-group">
                    <label><input type="radio" name="genero" value="Masculino"> Masculino</label>
                    <label><input type="radio" name="genero" value="Femenino"> Femenino</label>
                    <label><input type="radio" name="genero" value="Otro"> Otro</label>
                </div>
            </div>

            <div class="field-group">
                <label>Áreas de Interés:</label>
                <div class="inline-group">
                    <label><input type="checkbox" name="intereses[]" value="Tecnología"> Tecnología</label>
                    <label><input type="checkbox" name="intereses[]" value="Ciencia"> Ciencia</label>
                    <label><input type="checkbox" name="intereses[]" value="Arte"> Arte</label>
                </div>
            </div>

            <div class="field-group">
                <label for="pais">País de Residencia:</label>
                <select id="pais" name="pais">
                    <option value="">Selecciona tu país</option>
                    <option value="México">México</option>
                    <option value="España">España</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Colombia">Colombia</option>
                </select>
            </div>


            <div class="field-group">
                <label for="nivel_ingles">Nivel autoestimado de Inglés (%):</label>
                <input type="range" id="nivel_ingles" name="nivel_ingles" min="0" max="100">
            </div>

            <div class="field-group">
                <label for="color">Color de interfaz preferido:</label>
                <input type="color" id="color" name="color" value="#0d0d11">
            </div>

            <div class="field-group">
                <label for="biografia">Biografía / Comentarios adicionales:</label>
                <textarea id="biografia" name="biografia" rows="4"></textarea>
            </div>
        </fieldset>

        <!-- Botones de Acción -->
        <div class="button-group">
            <input type="submit" value="Enviar">
            <input type="reset" value="Limpiar">
            <input type="button" value="Boton generico" onclick="alert('Acción ejecutada')">
        </div>

    </form>
</div>

</body>
</html>