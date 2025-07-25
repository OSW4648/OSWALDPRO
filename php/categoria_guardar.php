<?php
	require_once "main.php";

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

    /*== Guardando datos ==*/
    $guardar_tipo=conexion();
    $guardar_tipo=$guardar_tipo->prepare("INSERT INTO tipo_equipo(nombre) VALUES(:nombre)");

    $marcadores=[
        ":nombre"=>$nombre
    ];

    $guardar_tipo->execute($marcadores);

    if($guardar_tipo->rowCount()==1){
        header("Location: ../index.php?vista=category_list");
        exit();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar el tipo de equipo, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_tipo=null;
?>