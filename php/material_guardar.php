<?php
require_once "main.php";
$nombre = limpiar_cadena($_POST['nombre']);
$conexion = conexion();
$sql = $conexion->prepare("INSERT INTO material (nombre) VALUES (?)");
$sql->execute([$nombre]);
header("Location: ../index.php?vista=material_lista");
exit();
?>