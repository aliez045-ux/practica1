-- Base de datos del proyecto_escuela
CREATE DATABASE IF NOT EXISTS escuela CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE escuela;

-- ===== TABLAS PRIMARIAS =====
CREATE TABLE turno (
  id_turno INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL
);

CREATE TABLE especialidad (
  id_especialidad INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL
);

CREATE TABLE ciclo_escolar (
  id_ciclo INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL        -- Ej: 2026-2027
);

CREATE TABLE grupo_grado (
  id_grupo INT AUTO_INCREMENT PRIMARY KEY,
  grado TINYINT NOT NULL,            -- 1, 2, 3...
  grupo VARCHAR(5) NOT NULL,         -- A, B, C...
  id_especialidad INT NULL,
  id_turno INT NULL,
  id_ciclo INT NULL,
  FOREIGN KEY (id_especialidad) REFERENCES especialidad(id_especialidad),
  FOREIGN KEY (id_turno) REFERENCES turno(id_turno),
  FOREIGN KEY (id_ciclo) REFERENCES ciclo_escolar(id_ciclo)
);

CREATE TABLE alumno (
  id_alumno INT AUTO_INCREMENT PRIMARY KEY,
  matricula VARCHAR(20) NOT NULL UNIQUE,
  nombre VARCHAR(60) NOT NULL,
  apellidos VARCHAR(80) NOT NULL,
  id_grupo INT NULL,
  FOREIGN KEY (id_grupo) REFERENCES grupo_grado(id_grupo)
);

CREATE TABLE profesor (
  id_profesor INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(60) NOT NULL,
  apellidos VARCHAR(80) NOT NULL
);

CREATE TABLE materia (
  id_materia INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(80) NOT NULL
);

-- ===== TABLAS DE REGISTRO =====
-- Cuántas tareas / prácticas / exámenes tiene cada parcial
CREATE TABLE config_evaluacion (
  id_grupo INT NOT NULL,
  id_materia INT NOT NULL,
  parcial TINYINT NOT NULL,
  tipo ENUM('tarea','practica','examen') NOT NULL,
  cantidad TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id_grupo, id_materia, parcial, tipo),
  FOREIGN KEY (id_grupo) REFERENCES grupo_grado(id_grupo),
  FOREIGN KEY (id_materia) REFERENCES materia(id_materia)
);

-- Una fila por actividad: Tarea 1, Tarea 2, Práctica 1, Examen 1...
CREATE TABLE calificacion (
  id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
  id_alumno INT NOT NULL,
  id_materia INT NOT NULL,
  id_profesor INT NOT NULL,
  parcial TINYINT NOT NULL,                              -- 1 o 2
  tipo ENUM('tarea','practica','examen') NOT NULL,
  numero TINYINT NOT NULL DEFAULT 1,                     -- Tarea 1, Tarea 2...
  calificacion DECIMAL(4,1) NOT NULL,                    -- 0 a 10
  fecha DATE NOT NULL,
  UNIQUE KEY uq_calificacion (id_alumno, id_materia, parcial, tipo, numero),
  FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
  FOREIGN KEY (id_materia) REFERENCES materia(id_materia),
  FOREIGN KEY (id_profesor) REFERENCES profesor(id_profesor)
);

-- Una fila por alumno y por clase (fecha + hora); presente = 1 es la palomita
CREATE TABLE asistencia (
  id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
  id_alumno INT NOT NULL,
  id_materia INT NOT NULL,
  parcial TINYINT NOT NULL,
  fecha DATE NOT NULL,
  hora TIME NOT NULL,
  presente TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY uq_asistencia (id_alumno, id_materia, parcial, fecha),
  FOREIGN KEY (id_alumno) REFERENCES alumno(id_alumno),
  FOREIGN KEY (id_materia) REFERENCES materia(id_materia)
);
