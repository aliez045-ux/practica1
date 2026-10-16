<?php
require_once 'conexion.php';

// Obtener todos los registros
$stmt = $conexion->query("SELECT * FROM test");
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar el total de usuarios evaluados (los que ya realizaron el test)
$stmt_evaluados = $conexion->query("SELECT COUNT(*) AS total FROM test WHERE puntaje IS NOT NULL AND puntaje != ''");
$resultado_evaluados = $stmt_evaluados->fetch(PDO::FETCH_ASSOC);
$total_evaluados = $resultado_evaluados['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte y Listado de Usuarios</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #37474f; padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 850px;">
        <h1>Reporte: Listado de Registros</h1>
        
        <!-- Cuadro con el Total de Usuarios Evaluados -->
        <div style="background: rgba(81, 207, 102, 0.15); border: 1px solid rgba(81, 207, 102, 0.3); padding: 12px; border-radius: 5px; text-align: center; margin-bottom: 20px;">
            <p style="margin: 0; color: #51cf66; font-size: 22px; font-weight: bold;">
                Total de usuarios evaluados: <?php echo $total_evaluados; ?>
            </p>
        </div>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Profesión</th>
                <th>Puntaje</th>
                <th>Situación</th>
            </tr>
            <?php if (count($registros) > 0): ?>
                <?php foreach ($registros as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['edad']); ?></td>
                        <td><?php echo htmlspecialchars($row['sexo']); ?></td>
                        <td><?php echo htmlspecialchars($row['profesion']); ?></td>
                        <td><?php echo htmlspecialchars($row['puntaje'] ?? '-'); ?></td>
                        <td><?php echo htmlspecialchars($row['situacion'] ?? '-'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" style="text-align: center;">No hay registros guardados.</td></tr>
            <?php endif; ?>
        </table>
        <p style="margin-top: 20px;"><a href="index.php">← Volver al Menú Principal</a></p>
    </div>
</body>
</html>