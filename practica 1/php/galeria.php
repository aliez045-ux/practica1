<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería de Imágenes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <header>
       <header>
    <nav>
        <ul>
            <li><a href="index.php">★ INICIO</a></li>
            <li><a href="uwe.php">★ UWE</a></li>
            <li><a href="fases.php">★ FASES Y MODELOS</a></li>
            <li><a href="hipervinculos.php">★ HIPERVÍNCULOS</a></li>
            <li><a href="galeria.php">★ GALERÍA</a></li>
            <!-- Hipervínculo para ir a la Práctica 2 -->
            <li><a href="../../PRACTICA 2/php/index.php" style="color: #d4a359;">★ PRÁCTICA 2</a></li>
        </ul>
    </nav>
</header>
    </header>

    <div class="container">
        <section class="galeria-imagenes">
            <h2>Galería de Diagramas UWE</h2>
            <div class="grid-imagenes">
                <div class="tarjeta-imagen">
                    <img src="../imagenes/arquitectura-web.jpeg" alt="Arquitectura Web">
                    <p>Figura 1: Arquitectura Web</p>
                </div>
                <div class="tarjeta-imagen">
                    <img src="../imagenes/images.png" alt="Diagrama UWE">
                    <p>Figura 2: Diagrama de Casos de Uso (UWE)</p>
                </div>
                <div class="tarjeta-imagen">
                    <img src="../imagenes/lenguajesdeprogramacion_principal.jpg" alt="Lenguajes de Programación">
                    <p>Figura 3: Lenguajes de Programación</p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>