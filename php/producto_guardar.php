<?php
require_once "../inc/session_start.php";
require_once "main.php";

/*== Almacenando datos ==*/
$nombre = limpiar_cadena($_POST['nombre']);
$marca = limpiar_cadena($_POST['marca']);
$modelo = limpiar_cadena($_POST['modelo']);
$caracteristicas = limpiar_cadena($_POST['caracteristicas']);
$id_tipo_equipo = limpiar_cadena($_POST['id_tipo_equipo']);

/*== Verificando campos obligatorios ==*/
if($nombre=="" || $id_tipo_equipo==""){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}

/*== Verificando integridad de los datos ==*/
if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,100}",$nombre)){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El NOMBRE no coincide con el formato solicitado
        </div>
    ';
    exit();
}

/*== Verificando nombre ==*/
$check_nombre = conexion();
$check_nombre = $check_nombre->query("SELECT nombre FROM descripcion_equipo WHERE nombre='$nombre'");
if($check_nombre->rowCount()>0){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
        </div>
    ';
    exit();
}
$check_nombre = null;

/*== Verificando tipo de equipo ==*/
$check_tipo = conexion();
$check_tipo = $check_tipo->query("SELECT id_tipo_equipo FROM tipo_equipo WHERE id_tipo_equipo='$id_tipo_equipo'");
if($check_tipo->rowCount()<=0){
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            El tipo de equipo seleccionado no existe
        </div>
    ';
    exit();
}
$check_tipo = null;

/*== Guardando datos ==*/
$guardar_producto = conexion();
$guardar_producto = $guardar_producto->prepare("INSERT INTO descripcion_equipo(nombre, marca, modelo, caracteristicas, id_tipo_equipo) VALUES(:nombre, :marca, :modelo, :caracteristicas, :id_tipo_equipo)");

$marcadores = [
    ":nombre" => $nombre,
    ":marca" => $marca,
    ":modelo" => $modelo,
    ":caracteristicas" => $caracteristicas,
    ":id_tipo_equipo" => $id_tipo_equipo
];

$guardar_producto->execute($marcadores);

if($guardar_producto->rowCount()==1){
    // Redirigir a la lista de productos
    header("Location: ../index.php?vista=product_list");
    exit();
}else{
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrió un error inesperado!</strong><br>
            No se pudo registrar el equipo, por favor intente nuevamente
        </div>
    ';
}
$guardar_producto = null;
?>
