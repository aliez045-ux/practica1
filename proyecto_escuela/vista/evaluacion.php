<?php
// ===========================================================
//  Reglas de evaluación — se cambian AQUÍ y aplican a todo el sistema
// ===========================================================

// Porcentaje que vale cada concepto en el parcial (debe sumar 100)
function pesos() {
    return [
        "examen"     => 40,
        "practica"   => 40,   // 30% + 10%
        "tarea"      => 10,
        "asistencia" => 10,
    ];
}

// Nombres para mostrar: [singular, plural]
function tipos() {
    return [
        "tarea"    => ["Tarea", "Tareas"],
        "practica" => ["Práctica", "Prácticas"],
        "examen"   => ["Examen", "Exámenes"],
    ];
}

// Cuántas actividades de ese tipo tiene el parcial (por defecto 1)
function cantidadActividades($pdo, $grupo, $materia, $parcial, $tipo) {
    $q = $pdo->prepare("SELECT cantidad FROM config_evaluacion
                        WHERE id_grupo=? AND id_materia=? AND parcial=? AND tipo=?");
    $q->execute([$grupo, $materia, $parcial, $tipo]);
    $c = $q->fetchColumn();
    return $c === false ? 1 : max(1, (int) $c);
}

// Promedio (0-10) de un tipo. Si hay 2 tareas, cada una vale la mitad;
// la que no tiene calificación cuenta como 0.
function puntosTipo($pdo, $alumno, $grupo, $materia, $parcial, $tipo) {
    $n = cantidadActividades($pdo, $grupo, $materia, $parcial, $tipo);
    $q = $pdo->prepare("SELECT COALESCE(SUM(calificacion),0) FROM calificacion
                        WHERE id_alumno=? AND id_materia=? AND parcial=? AND tipo=? AND numero<=?");
    $q->execute([$alumno, $materia, $parcial, $tipo, $n]);
    return ((float) $q->fetchColumn()) / $n;
}

// Cuántas asistencias (clases) tiene cada parcial
function totalAsistencias() {
    return 20;
}

// Asistencia: [asistió, total de clases del parcial, calificación 0-10]
// 20 de 20 asistencias = 10; 10 de 20 = 5; etc.
function puntosAsistencia($pdo, $alumno, $materia, $parcial) {
    $q = $pdo->prepare("SELECT COALESCE(SUM(presente),0) FROM asistencia
                        WHERE id_alumno=? AND id_materia=? AND parcial=?");
    $q->execute([$alumno, $materia, $parcial]);
    $total = totalAsistencias();
    $asistio = min((int) $q->fetchColumn(), $total);
    return [$asistio, $total, ($asistio / $total) * 10];
}

// Resultado completo de un parcial (0-10) con el detalle de cada concepto
function resultadoParcial($pdo, $alumno, $grupo, $materia, $parcial) {
    $w = pesos();
    $r = ["detalle" => [], "total" => 0];

    foreach (array_keys(tipos()) as $t) {
        $pts = puntosTipo($pdo, $alumno, $grupo, $materia, $parcial, $t);
        $r["detalle"][$t] = ["puntos" => $pts, "peso" => $w[$t], "aporta" => $pts * $w[$t] / 100];
        $r["total"] += $pts * $w[$t] / 100;
    }

    list($asistio, $total, $pts) = puntosAsistencia($pdo, $alumno, $materia, $parcial);
    $r["detalle"]["asistencia"] = [
        "puntos" => $pts, "peso" => $w["asistencia"], "aporta" => $pts * $w["asistencia"] / 100,
        "asistio" => $asistio, "clases" => $total,
    ];
    $r["total"] += $pts * $w["asistencia"] / 100;
    return $r;
}
