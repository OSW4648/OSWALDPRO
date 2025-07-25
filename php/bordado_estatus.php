<?php
require_once "main.php";
$conexion = conexion();

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    die("ID inválido");
}

// Solo cambia si está en Pendiente
$stmt = $conexion->prepare("UPDATE bordado SET estatus = 'Realizado' WHERE id = ? AND estatus = 'Pendiente'");
$stmt->execute([$id]);

header("Location: ../index.php?vista=bordado_ver&id=$id");
exit;