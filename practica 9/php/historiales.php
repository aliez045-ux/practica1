<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historiales</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container">
        <a href="../index.php" class="btn-back">← Volver al Menú</a>
        <h1>Historial de Alumnos</h1>

        <div class="card">
            <form method="POST">
                <label>¿Cuántos Alumnos?</label>
                <input type="number" name="cant_alumnos" min="1" max="10" required>
                <button type="submit" name="generar">Generar Campos</button>
            </form>
        </div>

        <?php if (isset($_POST['generar'])): 
            $cant = $_POST['cant_alumnos'];
        ?>
        <form method="POST">
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>C1</th>
                            <th>C2</th>
                            <th>C3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=0; $i<$cant; $i++): ?>
                        <tr>
                            <td><input type="text" name="nombre[]" required></td>
                            <td><input type="number" step="0.1" name="c1[]" required></td>
                            <td><input type="number" step="0.1" name="c2[]" required></td>
                            <td><input type="number" step="0.1" name="c3[]" required></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <br>
                <button type="submit" name="procesar">Calcular Promedios</button>
            </div>
        </form>
        <?php endif; ?>

        <?php
        if (isset($_POST['procesar'])) {
            $nombres = $_POST['nombre'];
            $c1 = $_POST['c1'];
            $c2 = $_POST['c2'];
            $c3 = $_POST['c3'];

            echo "<div class='card'><h2>Resultados</h2><ul>";
            for ($i=0; $i < count($nombres); $i++) { 
                $prom = ($c1[$i] + $c2[$i] + $c3[$i]) / 3;
                echo "<li><strong>{$nombres[$i]}:</strong> Promedio = " . number_format($prom, 2) . "</li>";
            }
            echo "</ul></div>";
        }
        ?>
    </div>
</body>
</html>