<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['producto_id']);


    /*== Verificando producto ==*/
	$check_producto=conexion();
	$check_producto=$check_producto->query("SELECT * FROM descripcion_equipo WHERE id_descripcion_equipo='$id'");

    if($check_producto->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El producto no existe en el sistema
            </div>
        ';
        exit();
    }
    $check_producto=null;


    $nombre=limpiar_cadena($_POST['producto_nombre']);
	$marca=limpiar_cadena($_POST['producto_marca']);
	$modelo=limpiar_cadena($_POST['producto_modelo']);
	$caracteristicas=limpiar_cadena($_POST['producto_caracteristicas']);
	$tipo=limpiar_cadena($_POST['producto_tipo']);


    /*== Verificando campos obligatorios ==*/
    if($nombre=="" || $marca=="" || $modelo=="" || $caracteristicas=="" || $tipo==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$marca)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La MARCA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$modelo)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El MODELO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$caracteristicas)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Las CARACTERISTICAS no coinciden con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando nombre ==*/
    if($nombre!=$datos['nombre']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT nombre FROM descripcion_equipo WHERE nombre='$nombre'");
	    if($check_nombre->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_nombre=null;
    }


    /*== Verificando marca ==*/
    if($marca!=$datos['marca']){
	    $check_marca=conexion();
	    $check_marca=$check_marca->query("SELECT marca FROM descripcion_equipo WHERE marca='$marca'");
	    if($check_marca->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                La MARCA ingresada ya se encuentra registrada, por favor elija otra
	            </div>
	        ';
	        exit();
	    }
	    $check_marca=null;
    }


    /*== Verificando modelo ==*/
    if($modelo!=$datos['modelo']){
	    $check_modelo=conexion();
	    $check_modelo=$check_modelo->query("SELECT modelo FROM descripcion_equipo WHERE modelo='$modelo'");
	    if($check_modelo->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El MODELO ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_modelo=null;
    }


    /*== Verificando tipo ==*/
    if($tipo!=$datos['id_tipo_equipo']){
	    $check_tipo=conexion();
	    $check_tipo=$check_tipo->query("SELECT id_tipo_equipo FROM tipo_equipo WHERE id_tipo_equipo='$tipo'");
	    if($check_tipo->rowCount()<=0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El tipo de equipo seleccionado no existe
	            </div>
	        ';
	        exit();
	    }
	    $check_tipo=null;
    }


    /*== Actualizando datos ==*/
    $actualizar_producto=conexion();
    $actualizar_producto=$actualizar_producto->prepare("UPDATE descripcion_equipo SET nombre=:nombre, marca=:marca, modelo=:modelo, caracteristicas=:caracteristicas, id_tipo_equipo=:tipo WHERE id_descripcion_equipo=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":marca"=>$marca,
        ":modelo"=>$modelo,
        ":caracteristicas"=>$caracteristicas,
        ":tipo"=>$tipo,
        ":id"=>$id
    ];


    if($actualizar_producto->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡PRODUCTO ACTUALIZADO!</strong><br>
                El producto se actualizó con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_producto=null;
?>