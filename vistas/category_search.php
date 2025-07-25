<div class="container is-fluid mb-6">
    <h1 class="title has-text-black">
        <span class="icon-text">
            <span class="icon">
                <i class="fas fa-laptop"></i>
            </span>
            <span>Tipos de equipo</span>
        </span>
    </h1>
    <h2 class="subtitle has-text-grey">Buscar tipo de equipo</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        if(isset($_POST['modulo_buscador'])){
            require_once "./php/buscador.php";
        }

        if(!isset($_SESSION['busqueda_categoria']) && empty($_SESSION['busqueda_categoria'])){
    ?>
    <div class="columns is-centered">
        <div class="column is-half">
            <form action="" method="POST" autocomplete="off" class="box">
                <input type="hidden" name="modulo_buscador" value="categoria">
                <div class="field">
                    <label class="label">Buscar</label>
                    <div class="control has-icons-left">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" >
                        <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
                <div class="field is-grouped is-grouped-centered mt-5">
                    <div class="control">
                        <button class="button is-info is-rounded is-medium" type="submit">
                            <span class="icon">
                                <i class="fas fa-search"></i>
                            </span>
                            <span>Buscar</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <div class="columns is-centered">
        <div class="column is-half">
            <form class="has-text-centered mt-6 mb-6 box" action="" method="POST" autocomplete="off" >
                <input type="hidden" name="modulo_buscador" value="categoria"> 
                <input type="hidden" name="eliminar_buscador" value="categoria">
                <p>Estas buscando <strong>“<?php echo $_SESSION['busqueda_categoria']; ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded is-medium">
                    <span class="icon">
                        <i class="fas fa-times"></i>
                    </span>
                    <span>Eliminar búsqueda</span>
                </button>
            </form>
        </div>
    </div>

    <?php
            # Eliminar tipo de equipo #
            if(isset($_GET['category_id_del'])){
                require_once "./php/categoria_eliminar.php";
            }

            if(!isset($_GET['page'])){
                $pagina=1;
            }else{
                $pagina=(int) $_GET['page'];
                if($pagina<=1){
                    $pagina=1;
                }
            }

            $pagina=limpiar_cadena($pagina);
            $url="index.php?vista=category_search&page=";
            $registros=15;
            $busqueda=$_SESSION['busqueda_categoria'];

            # Paginador tipo de equipo #
            require_once "./php/categoria_lista.php";
        } 
    ?>
</div>