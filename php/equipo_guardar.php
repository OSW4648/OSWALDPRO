<?php
require_once "main.php";

if(isset($_POST['id_descripcion_equipo'], $_POST['numero_serie'], $_POST['fecha_adquisicion'])){
    $id_descripcion_equipo = limpiar_cadena($_POST['id_descripcion_equipo']);
    $numero_serie = limpiar_cadena($_POST['numero_serie']);
    $fecha_adquisicion = limpiar_cadena($_POST['fecha_adquisicion']);
    $sku = limpiar_cadena($_POST['sku']);

    $conexion = conexion();
    $guardar_equipo = $conexion->prepare("INSERT INTO equipo (id_descripcion_equipo, sku, numero_serie, fecha_adquisicion) VALUES (:id_descripcion_equipo, :sku, :numero_serie, :fecha_adquisicion)");

    $marcadores = [
        ":id_descripcion_equipo" => $id_descripcion_equipo,
        ":sku" => $sku,
        ":numero_serie" => $numero_serie,
        ":fecha_adquisicion" => $fecha_adquisicion
    ];

    $guardar_equipo->execute($marcadores);

    header("Location: ../index.php?vista=equipo_lista");
    exit();
}
?>