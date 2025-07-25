<?php
require_once "main.php";
$id_evento = limpiar_cadena($_GET['id'] ?? '');

$conexion = conexion();

try {
    // Intenta eliminar el evento
    $stmt = $conexion->prepare("DELETE FROM evento WHERE id_evento = ?");
    $stmt->execute([$id_evento]);
    header("Location: ../index.php?vista=evento_lista&msg=eliminado");
    exit;
} catch (PDOException $e) {
    // Si hay error de integridad, muestra mensaje profesional
    if ($e->getCode() == 23000) {
        header("Location: ../index.php?vista=evento_lista&error=relacion");
        exit;
    } else {
        // Otro error
        header("Location: ../index.php?vista=evento_lista&error=desconocido");
        exit;
    }
}
?>