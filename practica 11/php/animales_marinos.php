<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4. Página Web Informativa SQL - Animales Marinos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

    <!-- Botón para regresar al menú principal -->
    <a href="../index.php">← Volver al menú</a>

    <!-- TÍTULO PRINCIPAL -->
    <header>
        <h1>Información y Gestión de Bases de Datos (SQL)</h1>
        <p>Aprende cómo crear y administrar una Base de Datos Relacional enfocada en Especies de Animales Marinos.</p>
    </header>

    <hr>

    <!-- SECCIÓN INFORMATIVA GENERAL -->
    <section class="seccion-intro">
        <h2>¿Qué es SQL?</h2>
        <p>
            <strong>SQL</strong> (Structured Query Language) es el lenguaje estándar utilizado para administrar e interactuar con 
            Bases de Datos Relacionales (BD) como MySQL y MariaDB. Permite almacenar, organizar, consultar y manipular la información de forma rápida y segura.
        </p>

        <h2>Estructura Visual y Concepto</h2>
        <p>
            Para gestionar la vida marina, creamos una base de datos central llamada <code>bd_animales_marinos</code> y dentro de ella 
            organizamos la información en tablas estructuradas por filas y columnas.
        </p>
        
        <!-- IMAGEN INFORMATIVA DE ANIMALES MARINOS -->
        <div class="contenedor-imagen">
            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800" alt="Fauna y Arrecife Marino" width="450">
        </div>
    </section>

    <hr>

    <!-- GUÍA PASO A PASO: CREAR BASE DE DATOS Y TABLA -->
    <section class="seccion-creacion">
        <h2>1. Crear la Base de Datos y la Tabla</h2>
        <p>Antes de almacenar información sobre las especies marinas, debemos estructurar el sistema con las siguientes sentencias SQL:</p>
        
        <ul>
            <li>
                <strong>Crear la Base de Datos:</strong>
                <pre><code>CREATE DATABASE bd_animales_marinos;</code></pre>
            </li>
            <li>
                <strong>Seleccionar la Base de Datos:</strong>
                <pre><code>USE bd_animales_marinos;</code></pre>
            </li>
            <li>
                <strong>Crear la Tabla de Especies:</strong>
                <pre><code>CREATE TABLE animales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    especie VARCHAR(100) NOT NULL,
    habitat VARCHAR(100),
    descripcion TEXT,
    imagen_url VARCHAR(255)
);</code></pre>
            </li>
        </ul>
    </section>

    <hr>

    <!-- GUÍA DE OPERACIONES BÁSICAS CRUD CON EJEMPLOS DE ANIMALES MARINOS -->
    <section class="seccion-crud">
        <h2>2. Operaciones Básicas CRUD en SQL</h2>
        <p>Las operaciones fundamentales para manipular datos de animales marinos en la base de datos se resumen en los siguientes comandos:</p>

        <ul>
            <li>
                <strong>Agregar datos (Insertar / Create):</strong> Inserta un nuevo animal marino en la tabla.
                <pre><code>INSERT INTO animales (nombre, especie, habitat, descripcion, imagen_url) 
VALUES ('Delfín Mular', 'Tursiops truncatus', 'Océanos Templados', 'Mamífero acuático muy inteligente.', 'https://images.unsplash.com/photo-1570481662006-a3a1374699e8?w=500');</code></pre>
            </li>

            <li>
                <strong>Listar datos (Consultar / Read):</strong> Obtiene y muestra todos los registros guardados.
                <pre><code>SELECT * FROM animales;</code></pre>
            </li>

            <li>
                <strong>Buscar datos (Filtrar):</strong> Encuentra registros específicos filtrando por id o por nombre.
                <pre><code>SELECT * FROM animales WHERE nombre = 'Delfín Mular';</code></pre>
            </li>

            <li>
                <strong>Modificar datos (Actualizar / Update):</strong> Cambia o actualiza la información de un animal registrado mediante su ID.
                <pre><code>UPDATE animales SET habitat = 'Océanos Cálidos y Templados' WHERE id = 1;</code></pre>
            </li>

            <li>
                <strong>Eliminar datos (Borrar / Delete):</strong> Remueve un registro específico de la tabla utilizando su ID.
                <pre><code>DELETE FROM animales WHERE id = 1;</code></pre>
            </li>
        </ul>
    </section>

    <hr>

    <!-- DEMOSTRACIÓN VISUAL / EJEMPLO CON IMÁGENES -->
    <section class="seccion-ejemplo">
        <h2>3. Ejemplo Visual: ¿Cómo se ve la Tabla creada en la Web?</h2>
        <p>
            Al ejecutar la sentencia <code>SELECT * FROM animales;</code> y conectar PHP con MySQL, la información procesada se muestra en una tabla HTML incluyendo imágenes de cada especie:
        </p>

        <!-- Formulario visual de ejemplo de búsqueda -->
        <div style="margin-bottom: 15px; text-align: center;">
            <input type="text" placeholder="Buscar especie..." value="Delfín" readonly>
            <button type="button">Buscar en BD</button>
        </div>

        <!-- Tabla interactiva con imágenes corregidas -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre Común</th>
                    <th>Especie (Científico)</th>
                    <th>Hábitat</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <img src="https://images.unsplash.com/photo-1570481662006-a3a1374699e8?w=300" alt="Delfín Mular" width="100" style="border-radius: 8px; border: 1px solid #60a5fa;">
                    </td>
                    <td>Delfín Mular</td>
                    <td><em>Tursiops truncatus</em></td>
                    <td>Océanos Cálidos y Templados</td>
                    <td>Mamífero acuático muy inteligente y social.</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=300" alt="Ballena Azul" width="100" style="border-radius: 8px; border: 1px solid #60a5fa;">
                    </td>
                    <td>Ballena Azul</td>
                    <td><em>Balaenoptera musculus</em></td>
                    <td>Océanos Abiertos</td>
                    <td>El animal más grande que ha existido en la Tierra.</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=300" alt="Tortuga Cahuama" width="100" style="border-radius: 8px; border: 1px solid #60a5fa;">
                    </td>
                    <td>Tortuga Cahuama</td>
                    <td><em>Caretta caretta</em></td>
                    <td>Arrecifes y Aguas Costeras</td>
                    <td>Reptil marino en peligro con caparazón rojizo.</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        <img src="https://images.unsplash.com/photo-1560275619-4662e36fa65c?w=300" alt="Tiburón Ballena" width="100" style="border-radius: 8px; border: 1px solid #60a5fa;">
                    </td>
                    <td>Tiburón Ballena</td>
                    <td><em>Rhincodon typus</em></td>
                    <td>Mares Tropicales</td>
                    <td>Pez de enorme tamaño que se alimenta de plancton.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <hr>

    <!-- ENLACE FINAL -->
    <footer>
        <p><a href="../index.php">Volver al menú</a></p>
    </footer>

</body>
</html>