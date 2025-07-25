<?php
require_once "main.php";
$id_evento = limpiar_cadena($_POST['id_evento']);
$observaciones_cierre = limpiar_cadena($_POST['observaciones_cierre']);

$conexion = conexion();
$sql = $conexion->prepare("UPDATE evento SET estatus='Cerrado', observaciones_cierre=? WHERE id_evento=?");
$sql->execute([$observaciones_cierre, $id_evento]);

header("Location: ../index.php?vista=evento_lista");
exit();
?>