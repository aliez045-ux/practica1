<?php
// Archivo simulado como "conexión" a almacenamiento local sin base de datos
$archivo_db = __DIR__ . '/registros.json';

// Función para guardar datos sin consultar base de datos
function guardarRegistro($datos, $rutaArchivo) {
    $registrosActuales = [];

    // Si el archivo ya existe, leer su contenido
    if (file_exists($rutaArchivo)) {
        $contenido = file_get_contents($rutaArchivo);
        $registrosActuales = json_decode($contenido, true) ?? [];
    }

    // Agregar fecha y nuevo registro
    $datos['fecha_registro'] = date('Y-m-d H:i:s');
    $registrosActuales[] = $datos;

    // Guardar en el archivo JSON
    return file_put_contents($rutaArchivo, json_encode($registrosActuales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>