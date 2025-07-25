<div class="container is-fluid mb-6">
    <h1 class="title has-text-black">
        <span class="icon-text">
            <span class="icon">
                <i class="fas fa-laptop"></i>
            </span>
            <span>Tipos de equipo</span>
        </span>
    </h1>
    <h2 class="subtitle has-text-grey">Actualizar tipo de equipo</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";
        require_once "./php/main.php";

        $id = (isset($_GET['category_id_up'])) ? $_GET['category_id_up'] : 0;
        $id=limpiar_cadena($id);

        /*== Verificando tipo de equipo ==*/
        $check_tipo=conexion();
        $check_tipo=$check_tipo->query("SELECT * FROM tipo_equipo WHERE id_tipo_equipo='$id'");

        if($check_tipo->rowCount()>0){
            $datos=$check_tipo->fetch();
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/categoria_actualizar.php" method="POST" class="FormularioAjax box" autocomplete="off" >
        <input type="hidden" name="categoria_id" value="<?php echo $datos['id_tipo_equipo']; ?>" required >
        <div class="columns is-centered">
            <div class="column is-half">
                <div class="field">
                    <label class="label">Nombre</label>
                    <div class="control has-icons-left">
                        <input class="input is-rounded" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{2,100}" maxlength="100" required value="<?php echo $datos['nombre']; ?>" placeholder="Ejemplo: Laptop, Impresora, etc.">
                        <span class="icon is-small is-left">
                            <i class="fas fa-tag"></i>
                        </span>
                    </div>
                </div>
                <div class="field is-grouped is-grouped-centered mt-5">
                    <div class="control">
                        <button type="submit" class="button is-success is-rounded is-medium">
                            <span class="icon">
                                <i class="fas fa-sync-alt"></i>
                            </span>
                            <span>Actualizar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php 
        }else{
            include "./inc/error_alert.php";
        }
        $check_tipo=null;
    ?>
</div>