<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Desarrollo de App Web - Práctica 2</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <h2>Desarrollo de Aplicaciones Web</h2>
        <p style="text-align:center;">Selecciona un subtema para revisar la información técnica:</p>
        
        <ul class="sub-menu">
            <li><a href="app_web.php?tema=1">1. Arquitecturas (2 y 3 Capas)</a></li>
            <li><a href="app_web.php?tema=2">2. Lenguajes LDC (Cliente) vs LDS (Servidor)</a></li>
            <li><a href="app_web.php?tema=3">3. Entornos IDEs y Seguridad</a></li>
        </ul>

        <div class="resultado">
        <?php
        $tema = $_GET['tema'] ?? 1;

        if ($tema == 1) {
            echo "<h3>Arquitecturas Web</h3>
                  <p><strong>2 Capas:</strong> Nivel Cliente y Servidor. Proceso de envío PostBack.</p>
                  <p><strong>3 Capas:</strong> Capa de Presentación (Navegador), Capa de Negocio (Servidor Web) y Capa de Datos (Base de Datos).</p>
                  <br>
                  <div style='display:flex; gap:15px; justify-content:center; flex-wrap:wrap; margin-top:15px;'>
                      <div>
                          <img src='../imagenes/arquitectura-web.png' alt='Arquitectura 2 capas' style='width:220px; border:2px solid #1a1a1a;'>
                          <p><small>Figura 1: Arquitectura de 2 Capas</small></p>
                      </div>
                      <div>
                          <img src='../imagenes/treecapas.png' alt='Arquitectura 3 capas' style='width:220px; border:2px solid #1a1a1a;'>
                          <p><small>Figura 2: Arquitectura de 3 Capas</small></p>
                      </div>
                  </div>";
        } elseif ($tema == 2) {
            echo "<h3>Lenguajes LDC y LDS</h3>
                  <p><strong>LDC (Lado Cliente):</strong> Se ejecutan en el navegador (HTML, CSS, JavaScript).</p>
                  <p><strong>LDS (Lado Servidor):</strong> Ejecutados en el servidor como PHP, ASP.net, JSP.</p>
                  <br>
                  <div style='text-align:center; margin-top:15px;'>
                      <img src='../imagenes/images.jpg' alt='Lenguajes de programación' style='max-width:280px; height:auto; border:2px solid #1a1a1a;'>
                      <p><small>Figura 3: Lenguajes LDC vs LDS</small></p>
                  </div>";
        } elseif ($tema == 3) {
            echo "<h3>IDEs y Aspectos de Seguridad</h3>
                  <p><strong>IDEs comunes:</strong> Visual Studio, Eclipse, NetBeans.</p>
                  <p><strong>Seguridad:</strong> Protección en PC de usuario, Servidor e Información en tránsito (Cifrado/SSL).</p>
                  <br>
                  <div style='text-align:center; margin-top:15px;'>
                      <img src='../imagenes/ide.jpg' alt='Entornos IDE y Seguridad' style='max-width:280px; height:auto; border:2px solid #1a1a1a;'>
                      <p><small>Figura 4: Entornos IDE y Seguridad</small></p>
                  </div>";
        }
        ?>
        </div>

        <br>
        <a href="index.php" class="btn">← Volver al Menú Principal</a>
    </div>
</body>
</html>