<?php
	/*== Almacenando datos ==*/
    $category_id_del=limpiar_cadena($_GET['category_id_del']);

    /*== Verificando tipo de equipo ==*/
    $check_tipo=conexion();
    $check_tipo=$check_tipo->query("SELECT id_tipo_equipo FROM tipo_equipo WHERE id_tipo_equipo='$category_id_del'");
    
    if($check_tipo->rowCount()==1){

        $check_descripcion=conexion();
        $check_descripcion=$check_descripcion->query("SELECT id_tipo_equipo FROM descripcion_equipo WHERE id_tipo_equipo='$category_id_del' LIMIT 1");

        if($check_descripcion->rowCount()<=0){

            $eliminar_tipo=conexion();
        	$eliminar_tipo=$eliminar_tipo->prepare("DELETE FROM tipo_equipo WHERE id_tipo_equipo=:id");

        	$eliminar_tipo->execute([":id"=>$category_id_del]);

        	if($eliminar_tipo->rowCount()==1){
                echo '
                    <div class="notification is-info is-light">
                        <strong>¡TIPO DE EQUIPO ELIMINADO!</strong><br>
                        Los datos del tipo de equipo se eliminaron con éxito
                    </div>
                ';
            }else{
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        No se pudo eliminar el tipo de equipo, por favor intente nuevamente
                    </div>
                ';
            }
            $eliminar_tipo=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No podemos eliminar el tipo de equipo ya que tiene equipos asociados
                </div>
            ';
        }
        $check_descripcion=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El tipo de equipo que intenta eliminar no existe
            </div>
        ';
    }
    $check_tipo=null;
?>