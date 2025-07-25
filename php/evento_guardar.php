<?php
require_once "main.php";

// Recibe los datos del formulario
$nombre = limpiar_cadena($_POST['nombre']);
$id_lugar = limpiar_cadena($_POST['id_lugar']);
$fecha_inicio = limpiar_cadena($_POST['fecha_inicio']);
$fecha_fin = limpiar_cadena($_POST['fecha_fin']);
$horario = limpiar_cadena($_POST['horario']);
$observaciones = limpiar_cadena($_POST['observaciones']);
$prioridad = limpiar_cadena($_POST['prioridad']);
$recursos_estimados = limpiar_cadena($_POST['recursos_estimados']);
$costos_estimados = limpiar_cadena($_POST['costos_estimados']);

// Procesar archivos adjuntos
$archivos_guardados = [];
if (!empty($_FILES['archivos_adjuntos']['name'][0])) {
    $ruta_destino = "../uploads/";
    if (!file_exists($ruta_destino)) {
        mkdir($ruta_destino, 0777, true);
    }
    foreach ($_FILES['archivos_adjuntos']['tmp_name'] as $key => $tmp_name) {
        $nombre_archivo = basename($_FILES['archivos_adjuntos']['name'][$key]);
        $ruta_archivo = $ruta_destino . uniqid() . "_" . $nombre_archivo;
        if (move_uploaded_file($tmp_name, $ruta_archivo)) {
            $archivos_guardados[] = $ruta_archivo;
        }
    }
}
$archivos_adjuntos = json_encode($archivos_guardados);

// Conexión y guardado
$conexion = conexion();
$sql = $conexion->prepare("INSERT INTO evento 
    (nombre, id_lugar, fecha_inicio, fecha_fin, horario, observaciones, prioridad, recursos_estimados, costos_estimados, archivos_adjuntos) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sql->execute([
    $nombre, $id_lugar, $fecha_inicio, $fecha_fin, $horario, $observaciones,
    $prioridad, $recursos_estimados, $costos_estimados, $archivos_adjuntos
]);

// Obtener el ID del evento recién insertado
$id_evento = $conexion->lastInsertId(); // ID del evento recién creado

// Guardar tareas asignadas
if (isset($_POST['tareas']) && is_array($_POST['tareas'])) {
    $sql_tarea = $conexion->prepare("INSERT INTO evento_tarea (evento_id, tarea_id) VALUES (?, ?)");
    foreach ($_POST['tareas'] as $tarea_id) {
        if (is_numeric($tarea_id)) {
            $sql_tarea->execute([$id_evento, $tarea_id]);
        }
    }
}

// Guardar nuevas tareas creadas desde el formulario
if (isset($_POST['nuevas_tareas']) && is_array($_POST['nuevas_tareas'])) {
    $sql_nueva_tarea = $conexion->prepare("INSERT INTO tarea (titulo) VALUES (?)");
    $sql_evento_tarea = $conexion->prepare("INSERT INTO evento_tarea (evento_id, tarea_id) VALUES (?, ?)");
    foreach ($_POST['nuevas_tareas'] as $titulo_nueva_tarea) {
        if (trim($titulo_nueva_tarea) != "") {
            $sql_nueva_tarea->execute([$titulo_nueva_tarea]);
            $nuevo_id_tarea = $conexion->lastInsertId();
            $sql_evento_tarea->execute([$id_evento, $nuevo_id_tarea]);
        }
    }
}

// Procesar tareas nuevas agregadas desde el formulario
if (!empty($_POST['tareas_completas_json'])) {
    $tareas = json_decode($_POST['tareas_completas_json'], true);
    if (is_array($tareas)) {
        foreach ($tareas as $tarea) {
            $sql = $conexion->prepare("INSERT INTO tarea 
                (titulo, descripcion, fecha_vencimiento, id_usuario_asignado, estatus, prioridad, fecha_creacion, creado_por, comentarios) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)");
            $sql->execute([
                $tarea['titulo'],
                $tarea['descripcion'],
                $tarea['fecha_vencimiento'],
                $tarea['usuario_asignado'],
                'Pendiente',
                'Media',
                $_SESSION['usuario_id'] ?? null,
                $tarea['comentarios'] ?? ''
            ]);
            $id_tarea = $conexion->lastInsertId();

            // Relacionar tarea con evento
            $conexion->prepare("INSERT INTO evento_tarea (evento_id, tarea_id) VALUES (?, ?)")->execute([$id_evento, $id_tarea]);
        }
    }
}

header("Location: ../index.php?vista=evento_lista");
exit;
?>