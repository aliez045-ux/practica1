<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fases y Modelos</title>
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
        <section class="tabla-contenedor">
            <h2>Tabla 1: Clasificación de Aplicaciones Web según su Intencionalidad</h2>
            <table>
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Informacionales</td>
                        <td>Orientadas a la difusión de información con o sin acceso a bases de datos.</td>
                    </tr>
                    <tr>
                        <td>Interactivas / Transaccionales</td>
                        <td>Orientadas a la interacción activa del usuario (compras o banca electrónica).</td>
                    </tr>
                    <tr>
                        <td>Orientadas al Servicio</td>
                        <td>Sistemas de ayuda financiera, simuladores e interacción técnica.</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="tabla-contenedor">
            <h2>Tabla 2: Fases del Desarrollo en UWE</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fase</th>
                        <th>Objetivo Principal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. Requisitos</td>
                        <td>Captura de características funcionales y modelado de casos de uso.</td>
                    </tr>
                    <tr>
                        <td>2. Diseño del Sistema</td>
                        <td>Definición del modelo conceptual, navegacional y de presentación.</td>
                    </tr>
                    <tr>
                        <td>3. Codificación</td>
                        <td>Traducción de los modelos a código fuente mediante lenguajes de programación.</td>
                    </tr>
                    <tr>
                        <td>4. Pruebas e Instalación</td>
                        <td>Asegurar el correcto funcionamiento y despliegue final de la aplicación.</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>