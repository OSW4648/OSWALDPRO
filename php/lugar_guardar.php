<?php
require_once "main.php";
$nombre = limpiar_cadena($_POST['nombre']);
$conexion = conexion();
$sql = $conexion->prepare("INSERT INTO lugar (nombre) VALUES (?)");
$sql->execute([$nombre]);
header("Location: ../index.php?vista=lugar_lista");
exit();
?>