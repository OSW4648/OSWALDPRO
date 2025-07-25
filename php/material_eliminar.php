<?php
require_once "main.php";

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);
    try {
        $pdo = conexion();
        // Eliminar registros relacionados en evento_material (si existen)
        $stmt = $pdo->prepare("DELETE FROM evento_material WHERE id_material = ?");
        $stmt->execute([$id]);
        // Eliminar el material
        $stmt = $pdo->prepare("DELETE FROM material WHERE id_material = ?");
        $stmt->execute([$id]);
        header("Location: ../index.php?vista=material_lista&msg=eliminado");
        exit;
    } catch (Exception $e) {
        echo "Error al eliminar: " . $e->getMessage();
    }
} else {
    echo "ID inválido.";
}
?>