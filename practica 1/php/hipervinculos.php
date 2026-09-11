<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hipervínculos - Práctica 1</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">★ INICIO</a></li>
                <li><a href="uwe.php">★ UWE</a></li>
                <li><a href="fases.php">★ FASES Y MODELOS</a></li>
                <li><a href="hipervinculos.php">★ HIPERVÍNCULOS</a></li>
                <li><a href="galeria.php">★ GALERÍA</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <section class="seccion-texto">
            <h2>Enlaces de Interés (2 Hipervínculos)</h2>
            <p>A continuación se presentan enlaces externos de consulta sobre estándares web:</p>
            
           <ul class="enlaces-list">
    <!-- Al quitar target="_blank", abre en la misma pestaña -->
    <li><a href="https://www.w3.org/">Consorcio W3C (World Wide Web Consortium)</a></li>
    <li><a href="https://www.uml.org/">Sitio Oficial de UML (Unified Modeling Language)</a></li>
</ul>
        </section>

        <!-- Botón para volver al Inicio / Menú Principal -->
        <div style="margin-top: 30px; text-align: center;">
            <a href="index.php" class="btn-volver">← VOLVER AL MENÚ PRINCIPAL</a>
        </div>
    </div>
</body>
</html>