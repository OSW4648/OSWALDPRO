<?php
require_once "main.php";
if(isset($_POST['id_asignacion'])){
    $id = limpiar_cadena($_POST['id_asignacion']);
    $conexion = conexion();
    $fecha = date('Y-m-d');
    $sql = $conexion->prepare("UPDATE asignacion_equipo SET estatus='Entregado', fecha_regreso=? WHERE id_asignacion_equipo=?");
    $sql->execute([$fecha, $id]);
}
header("Location: ../index.php?vista=asignacion_equipo_lista");
exit();
?>