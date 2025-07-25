<?php
require_once "main.php";
$conexion = conexion();

if (isset($_FILES['archivo_txt']) && $_FILES['archivo_txt']['error'] == 0) {
    $archivo = fopen($_FILES['archivo_txt']['tmp_name'], "r");
    while (($linea = fgets($archivo)) !== false) {
        // Suponiendo que cada línea es: nombre|area_id
        $datos = explode("|", trim($linea));
        if (count($datos) == 2) {
            $nombre = $datos[0];
            $area_id = $datos[1];
            $stmt = $conexion->prepare("INSERT INTO vendedor (nombre, area_id) VALUES (?, ?)");
            $stmt->execute([$nombre, $area_id]);
        }
    }
    fclose($archivo);
    echo "Importación completada.";
} else {
    echo "Error al subir el archivo.";
}
?>