<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['categoria_id']);

    /*== Verificando tipo de equipo ==*/
    $check_tipo=conexion();
    $check_tipo=$check_tipo->query("SELECT * FROM tipo_equipo WHERE id_tipo_equipo='$id'");

    if($check_tipo->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El tipo de equipo no existe en el sistema
            </div>
        ';
        exit();
    }else{
        $datos=$check_tipo->fetch();
    }
    $check_tipo=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['categoria_nombre']);

    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado el campo nombre
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,100}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El nombre no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando nombre ==*/
    if($nombre!=$datos['nombre']){
        $check_nombre=conexion();
        $check_nombre=$check_nombre->query("SELECT nombre FROM tipo_equipo WHERE nombre='$nombre'");
        if($check_nombre->rowCount()>0){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    El nombre ingresado ya se encuentra registrado, por favor elija otro
                </div>
            ';
            exit();
        }
        $check_nombre=null;
    }

    /*== Actualizar datos ==*/
    $actualizar_tipo=conexion();
    $actualizar_tipo=$actualizar_tipo->prepare("UPDATE tipo_equipo SET nombre=:nombre WHERE id_tipo_equipo=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":id"=>$id
    ];

    if($actualizar_tipo->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡TIPO DE EQUIPO ACTUALIZADO!</strong><br>
                El tipo de equipo se actualizó con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar el tipo de equipo, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_tipo=null;
?>