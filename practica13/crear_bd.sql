CREATE DATABASE IF NOT EXISTS `5BVP` CHARACTER SET utf8mb4;
USE `5BVP`;

DROP TABLE IF EXISTS Alumnos;
CREATE TABLE Alumnos (
    Id_control VARCHAR(10)  NOT NULL PRIMARY KEY,
    Nombre     VARCHAR(40)  NOT NULL,
    Carrera    VARCHAR(30)  NOT NULL,
    Grupo      VARCHAR(10)  NOT NULL,
    Parcial_1  DECIMAL(4,1) NOT NULL,
    Parcial_2  DECIMAL(4,1) NOT NULL,
    Parcial_3  DECIMAL(4,1) NOT NULL,
    Promedio   DECIMAL(4,2) NOT NULL,
    Situacion  VARCHAR(12)  NOT NULL
);

-- Alumnos de ejemplo (puedes borrar este bloque y capturarlos desde Base.php)
INSERT INTO Alumnos (Id_control, Nombre, Carrera, Grupo, Parcial_1, Parcial_2, Parcial_3, Promedio, Situacion) VALUES
('A001', 'Juan Perez',  'Programación', '5BVP', 8.0, 7.5, 9.0, 8.17, 'Aprobado'),
('A002', 'Maria Lopez', 'Contabilidad', '5BVP', 5.0, 4.5, 6.0, 5.17, 'Reprobado');
