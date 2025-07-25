<?php
require_once "main.php";
$conexion = conexion();

$id = intval($_POST['id']);
$x = intval($_POST['logotipo_x']);
$y = intval($_POST['logotipo_y']);
$w = intval($_POST['logotipo_w']);
$h = intval($_POST['logotipo_h']);
$img = $_POST['logotipo_img'];

$stmt = $conexion->prepare("UPDATE bordado SET logotipo_x = ?, logotipo_y = ?, logotipo_w = ?, logotipo_h = ?, logotipo_img = ? WHERE id = ?");
$stmt->execute([$x, $y, $w, $h, $img, $id]);

header("Location: ../index.php?vista=bordado_ver&id=".$id);
exit;