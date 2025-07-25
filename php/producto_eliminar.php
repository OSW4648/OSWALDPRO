<?php
    /*== Almacenando datos ==*/
    $product_id_del=limpiar_cadena($_GET['product_id_del']);
    /*== Verificando producto ==*/
    $check_producto=conexion();
    $check_producto=$check_producto->query("SELECT * FROM descripcion_equipo WHERE id_descripcion_equipo='$product_id_del'");

    if($check_producto->rowCount()==1){

        // 1. Obtener todos los id_equipo asociados a este producto
        $equipos=conexion();
        $equipos=$equipos->query("SELECT id_equipo FROM equipo WHERE id_descripcion_equipo='$product_id_del'");
        $equipos_ids = $equipos->fetchAll(PDO::FETCH_COLUMN);

        // 2. Eliminar asignaciones de esos equipos
        if(count($equipos_ids) > 0){
            $asignacion=conexion();
            $in  = str_repeat('?,', count($equipos_ids) - 1) . '?';
            $asignacion_stmt = $asignacion->prepare("DELETE FROM asignacion_equipo WHERE id_equipo IN ($in)");
            $asignacion_stmt->execute($equipos_ids);
            $asignacion_stmt=null;
            $asignacion=null;
        }

        // 3. Eliminar los equipos asociados
        $eliminar_equipos=conexion();
        $eliminar_equipos=$eliminar_equipos->prepare("DELETE FROM equipo WHERE id_descripcion_equipo=:id");
        $eliminar_equipos->execute([":id"=>$product_id_del]);
        $eliminar_equipos=null;

        // 4. Ahora sí eliminar el producto
        $eliminar_producto=conexion();
        $eliminar_producto=$eliminar_producto->prepare("DELETE FROM descripcion_equipo WHERE id_descripcion_equipo=:id");
        $eliminar_producto->execute([":id"=>$product_id_del]);

        if($eliminar_producto->rowCount()==1){
            echo '
                <div class="notification is-info is-light">
                    <strong>¡PRODUCTO ELIMINADO!</strong><br>
                    Los datos del producto se eliminaron con éxito
                </div>
            ';
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No se pudo eliminar el producto, por favor intente nuevamente
                </div>
            ';
        }
        $eliminar_producto=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El producto que intenta eliminar no existe
            </div>
        ';
    }
    $check_producto=null;
?>