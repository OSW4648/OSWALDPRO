<?php
require_once "main.php";
$id_evento = limpiar_cadena($_POST['id_evento']);
$listos = $_POST['listos'] ?? [];

$conexion = conexion();

// Obtén todos los usuarios asignados al evento
$usuarios = $conexion->query("SELECT id_usuario FROM evento_usuario WHERE id_evento='$id_evento'")->fetchAll(PDO::FETCH_COLUMN);

foreach($usuarios as $id_usuario){
    $listo = isset($listos[$id_usuario]) ? 1 : 0;
    $conexion->query("UPDATE evento_usuario SET listo='$listo' WHERE id_evento='$id_evento' AND id_usuario='$id_usuario'");
}

// Redirige a la lista de eventos
header("Location: ../index.php?vista=evento_lista");
exit;