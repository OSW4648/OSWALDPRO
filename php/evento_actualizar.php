<?php
require_once "main.php";

$id_evento = limpiar_cadena($_POST['id_evento'] ?? '');
$nombre = limpiar_cadena($_POST['nombre'] ?? '');
$id_lugar = limpiar_cadena($_POST['id_lugar'] ?? '');
$fecha_inicio = limpiar_cadena($_POST['fecha_inicio'] ?? '');
$fecha_fin = limpiar_cadena($_POST['fecha_fin'] ?? '');
$horario = limpiar_cadena($_POST['horario'] ?? '');
$observaciones = limpiar_cadena($_POST['observaciones'] ?? '');

$cantidades = $_POST['cantidades'] ?? [];
$areas = $_POST['areas'] ?? [];

$conexion = conexion();

// Actualiza el evento
$sql = "UPDATE evento SET nombre=?, id_lugar=?, fecha_inicio=?, fecha_fin=?, horario=?, observaciones=? WHERE id_evento=?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$nombre, $id_lugar, $fecha_inicio, $fecha_fin, $horario, $observaciones, $id_evento]);

// Actualiza los materiales del evento
foreach($cantidades as $id_evento_material => $cantidad){
    $id_evento_material = limpiar_cadena($id_evento_material);
    $cantidad = limpiar_cadena($cantidad);
    $id_area = limpiar_cadena($areas[$id_evento_material] ?? '');
    $conexion->prepare("UPDATE evento_material SET cantidad=?, id_area=? WHERE id_evento_material=?")
        ->execute([$cantidad, $id_area, $id_evento_material]);
}

// Redirige al detalle del evento
header("Location: ../index.php?vista=evento_detalle&id=$id_evento");
exit;
?>