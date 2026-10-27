<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="../controlador/estilos.css">
<title>Proyecto Escuela</title>
</head>
<body>
<h1>Proyecto Escuela</h1>

<!-- Fecha y hora en vivo -->
<div class="reloj">
  <div id="hora">--:--:--</div>
  <div id="fecha"></div>
</div>
<script>
function actualizarReloj() {
  var ahora = new Date();
  document.getElementById("hora").textContent =
    ahora.toLocaleTimeString("es-MX", { hour: "2-digit", minute: "2-digit", second: "2-digit", hour12: false });
  var f = ahora.toLocaleDateString("es-MX", { weekday: "long", day: "numeric", month: "long", year: "numeric" });
  document.getElementById("fecha").textContent = f.charAt(0).toUpperCase() + f.slice(1);
}
actualizarReloj();
setInterval(actualizarReloj, 1000);
</script>

<h2>Catálogos</h2>
<ul>
  <li><a href="alumnos.php">Alumnos</a></li>
  <li><a href="profesores.php">Profesores</a></li>
  <li><a href="materias.php">Materias</a></li>
  <li><a href="grupos.php">Grupo y grado</a></li>
  <li><a href="especialidades.php">Especialidades</a></li>
  <li><a href="turnos.php">Turnos</a></li>
  <li><a href="ciclos.php">Ciclo escolar</a></li>
</ul>

<h2>Operaciones</h2>
<ul>
  <li><a href="calificaciones.php">Registrar calificaciones</a></li>
  <li><a href="asistencia.php">Registrar asistencia</a></li>
  <li><a href="resultados.php">Ver resultados</a></li>
</ul>
</body>
</html>
