<?php
require_once "main.php";

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = intval($_GET['id']);
    try {
        $pdo = conexion();

        // 1. Obtener los usuarios relacionados a esta área
        $stmt = $pdo->prepare("SELECT usuario_id FROM usuario WHERE usuario_area_id = ?");
        $stmt->execute([$id]);
        $usuarios = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if($usuarios){
            // 2. Eliminar registros de evento_usuario relacionados con estos usuarios
            $in = str_repeat('?,', count($usuarios) - 1) . '?';
            $stmt = $pdo->prepare("DELETE FROM evento_usuario WHERE id_usuario IN ($in)");
            $stmt->execute($usuarios);

            // 3. Eliminar los usuarios relacionados
            $stmt = $pdo->prepare("DELETE FROM usuario WHERE usuario_id IN ($in)");
            $stmt->execute($usuarios);
        }

        // 4. Eliminar registros relacionados en evento_material
        $stmt = $pdo->prepare("DELETE FROM evento_material WHERE id_area = ?");
        $stmt->execute([$id]);

        // 5. Finalmente, eliminar el área
        $stmt = $pdo->prepare("DELETE FROM area WHERE id_area = ?");
        $stmt->execute([$id]);

        header("Location: ../index.php?vista=area_lista&msg=eliminado");
        exit;
    } catch (Exception $e) {
        echo "Error al eliminar: " . $e->getMessage();
    }
} else {
    echo "ID inválido.";
}
?>