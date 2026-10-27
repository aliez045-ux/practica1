-- Ejecuta esto SOLO si ya habías importado la versión anterior de bd_escuela.sql
USE escuela;

CREATE TABLE IF NOT EXISTS config_evaluacion (
  id_grupo INT NOT NULL,
  id_materia INT NOT NULL,
  parcial TINYINT NOT NULL,
  tipo ENUM('tarea','practica','examen') NOT NULL,
  cantidad TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (id_grupo, id_materia, parcial, tipo),
  FOREIGN KEY (id_grupo) REFERENCES grupo_grado(id_grupo),
  FOREIGN KEY (id_materia) REFERENCES materia(id_materia)
);

-- Si ya tenías calificaciones/asistencias de prueba, bórralas primero para evitar duplicados:
DELETE FROM calificacion;
DELETE FROM asistencia;

ALTER TABLE calificacion ADD COLUMN numero TINYINT NOT NULL DEFAULT 1 AFTER tipo;
ALTER TABLE calificacion ADD UNIQUE KEY uq_calificacion (id_alumno, id_materia, parcial, tipo, numero);

ALTER TABLE asistencia ADD COLUMN hora TIME NOT NULL DEFAULT '00:00:00' AFTER fecha;
ALTER TABLE asistencia ADD UNIQUE KEY uq_asistencia (id_alumno, id_materia, parcial, fecha);
