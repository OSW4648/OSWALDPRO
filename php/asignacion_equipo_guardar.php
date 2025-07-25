<?php
require_once "main.php";

if(isset($_POST['id_usuario'], $_POST['id_equipo'], $_POST['fecha_asignacion'])){
    $id_usuario = limpiar_cadena($_POST['id_usuario']);
    $id_equipo = limpiar_cadena($_POST['id_equipo']);
    $fecha_asignacion = limpiar_cadena($_POST['fecha_asignacion']);
    $fecha_regreso = limpiar_cadena($_POST['fecha_regreso']);
    $motivo = limpiar_cadena($_POST['motivo']);

    $conexion = conexion();
    $sql = $conexion->prepare("INSERT INTO asignacion_equipo (id_equipo, id_usuario, fecha_asignacion, fecha_regreso, motivo) VALUES (?, ?, ?, ?, ?)");
    $sql->execute([$id_equipo, $id_usuario, $fecha_asignacion, $fecha_regreso, $motivo]);

    header("Location: ../index.php?vista=asignacion_equipo_lista");
    exit();
}
?>