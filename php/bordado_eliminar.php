<?php
require_once "main.php";
$conexion = conexion();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id > 0){
    // Elimina primero las tallas relacionadas (si existen)
    $conexion->prepare("DELETE FROM bordado_tallas WHERE bordado_id = ?")->execute([$id]);
    // Elimina el bordado principal
    $conexion->prepare("DELETE FROM bordado WHERE id = ?")->execute([$id]);
}

header("Location: ../index.php?vista=bordado_lista");
exit;