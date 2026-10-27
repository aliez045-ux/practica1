<?php
/* ==========================================================
   Base de datos de alumnos (SQLite + PHP)
   - No necesita instalar nada más: el archivo datos/alumnos.db
     se crea solo la primera vez que abres esta página.
   - Funciona con XAMPP, AppServ o "php -S localhost:8000".
   ========================================================== */

$carpeta = __DIR__ . '/datos';
if (!is_dir($carpeta)) { mkdir($carpeta, 0755, true); }

$db = new PDO('sqlite:' . $carpeta . '/alumnos.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS alumnos (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre       TEXT NOT NULL,
    grupo        TEXT NOT NULL,
    correo       TEXT NOT NULL,
    calificacion REAL
)");

/* Primera vez: se guardan los integrantes del equipo */
if ((int)$db->query("SELECT COUNT(*) FROM alumnos")->fetchColumn() === 0) {
    $ins = $db->prepare("INSERT INTO alumnos (nombre, grupo, correo, calificacion) VALUES (?,?,?,?)");
    $ins->execute(['Allison Salinas Gonzales',   '5BVP', 'allison.salinas5bvp@gmail.com',   10]);
    $ins->execute(['Fernando De la Cruz Pascual','5BVP', 'fernando.delacruz5bvp@gmail.com', 9.5]);
    $ins->execute(['Diego Aaron Desales Sanches','5BVP', 'diego.desales5bvp@gmail.com',     9]);
}

$mensaje = '';
$error   = '';

/* ---------- Acciones: agregar / eliminar ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'agregar') {
        $nombre = trim($_POST['nombre'] ?? '');
        $grupo  = trim($_POST['grupo'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $cal    = ($_POST['calificacion'] ?? '') === '' ? null : (float)$_POST['calificacion'];

        if ($nombre === '' || $grupo === '' || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = 'Revisa los datos: nombre, grupo y un correo válido son obligatorios.';
        } elseif ($cal !== null && ($cal < 0 || $cal > 10)) {
            $error = 'La calificación debe estar entre 0 y 10.';
        } else {
            $st = $db->prepare("INSERT INTO alumnos (nombre, grupo, correo, calificacion) VALUES (?,?,?,?)");
            $st->execute([$nombre, $grupo, $correo, $cal]);
            $mensaje = 'Alumno guardado en la base de datos.';
        }
    }

    if ($accion === 'eliminar') {
        $st = $db->prepare("DELETE FROM alumnos WHERE id = ?");
        $st->execute([(int)($_POST['id'] ?? 0)]);
        $mensaje = 'Registro eliminado.';
    }
}

/* ---------- Consulta (con buscador) ---------- */
$buscar = trim($_GET['q'] ?? '');
if ($buscar !== '') {
    $st = $db->prepare("SELECT * FROM alumnos WHERE nombre LIKE ? OR grupo LIKE ? OR correo LIKE ? ORDER BY id");
    $like = '%' . $buscar . '%';
    $st->execute([$like, $like, $like]);
} else {
    $st = $db->query("SELECT * FROM alumnos ORDER BY id");
}
$alumnos = $st->fetchAll(PDO::FETCH_ASSOC);

$total = (int)$db->query("SELECT COUNT(*) FROM alumnos")->fetchColumn();
$prom  = $db->query("SELECT AVG(calificacion) FROM alumnos WHERE calificacion IS NOT NULL")->fetchColumn();

function h($t) { return htmlspecialchars((string)$t, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Base de datos · Pensamiento Matemático</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

  <header class="encabezado">
    <a class="btn-inicio" href="index.html" title="Inicio">Inicio</a>
    <h1>YSLS · Pensamiento Matemático</h1>
    <p class="lema">Base de datos</p>
  </header>

  <main>
    <section class="hoja">

      <div class="cuaderno-cab">
        <div>Nombre: ______________________</div>
        <div class="fecha"><span>Día</span><span>Mes</span><span>Año</span></div>
        <div>Tema: Base de datos de alumnos</div>
      </div>

      <h2>Base de datos</h2>
      <p class="subrayado">registro de alumnos · grupo 5BVP</p>

      <?php if ($mensaje): ?><p class="aviso"><?= h($mensaje) ?></p><?php endif; ?>
      <?php if ($error): ?><p class="aviso error"><?= h($error) ?></p><?php endif; ?>

      <!-- Buscador -->
      <form class="buscador" method="get" action="basedatos.php">
        <input type="text" name="q" value="<?= h($buscar) ?>" placeholder="buscar por nombre, grupo o correo...">
        <button class="boton" type="submit">Buscar</button>
        <?php if ($buscar !== ''): ?><a class="boton secundario" href="basedatos.php">Ver todos</a><?php endif; ?>
      </form>

      <!-- Tabla -->
      <div class="tabla-wrap">
        <table class="temario datos">
          <caption>
            <?= $total ?> alumno<?= $total === 1 ? '' : 's' ?> registrado<?= $total === 1 ? '' : 's' ?>
            <?php if ($prom !== null && $prom !== false): ?> · promedio general: <?= number_format((float)$prom, 2) ?><?php endif; ?>
          </caption>
          <thead>
            <tr><th>#</th><th>Nombre</th><th>Grupo</th><th>Correo</th><th>Calif.</th><th></th></tr>
          </thead>
          <tbody>
          <?php if (!$alumnos): ?>
            <tr><td colspan="6">No hay registros todavía.</td></tr>
          <?php endif; ?>
          <?php foreach ($alumnos as $a): ?>
            <tr>
              <td><?= (int)$a['id'] ?></td>
              <td><?= h($a['nombre']) ?></td>
              <td><?= h($a['grupo']) ?></td>
              <td><?= h($a['correo']) ?></td>
              <td><?= $a['calificacion'] === null ? '—' : h(rtrim(rtrim(number_format((float)$a['calificacion'], 1), '0'), '.')) ?></td>
              <td>
                <form method="post" action="basedatos.php" onsubmit="return confirm('¿Eliminar este registro?');">
                  <input type="hidden" name="accion" value="eliminar">
                  <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                  <button class="boton-mini" type="submit" title="Eliminar">✕</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Agregar -->
      <p class="subrayado">agregar un alumno</p>
      <form class="formulario" method="post" action="basedatos.php">
        <input type="hidden" name="accion" value="agregar">

        <label for="n">Nombre completo:</label>
        <input type="text" id="n" name="nombre" required>

        <label for="g">Grupo:</label>
        <input type="text" id="g" name="grupo" value="5BVP" required>

        <label for="c">Correo electrónico:</label>
        <input type="email" id="c" name="correo" required>

        <label for="k">Calificación (0 a 10, opcional):</label>
        <input type="text" id="k" name="calificacion" inputmode="decimal">

        <div class="botones">
          <button class="boton" type="submit">Guardar en la base</button>
          <button class="boton secundario" type="reset">Limpiar</button>
        </div>
      </form>

    </section>

    <nav class="navegacion">
      <a href="index.html">Menú</a>
      <a href="temario.html">Temario</a>
      <a href="introduccion.html">Introducción</a>
      <a href="contacto.html">Contactos</a>
    </nav>
  </main>

  <footer class="pie">YSLS · Pensamiento Matemático · 5BVP · 2026</footer>

</body>
</html>
