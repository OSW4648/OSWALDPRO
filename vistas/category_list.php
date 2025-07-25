<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">
        <span class="icon-text">
            <span class="icon">
                <i class="fas fa-laptop"></i>
            </span>
            <span>Tipos de equipo</span>
        </span>
    </h1>
</div>

<div class="container pb-6 pt-6">
    <div class="box">

        <!-- Botón para nueva categoría y buscador -->
        <div class="level mb-4">
            <div class="level-left">
                <a href="index.php?vista=category_new" class="button is-success is-rounded">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Nueva categoría</span>
                </a>
            </div>
            <div class="level-right">
                <form action="index.php?vista=category_list" method="GET" class="field has-addons">
                    <input type="hidden" name="vista" value="category_list">
                    <div class="control">
                        <input class="input" type="text" name="busqueda" placeholder="Buscar categoría..." value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
                    </div>
                    <div class="control">
                        <button type="submit" class="button is-info">
                            <span class="icon"><i class="fas fa-search"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Fin de botones y buscador -->

        <?php
            require_once "./php/main.php";

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
            $url="index.php?vista=category_list&page=";
            $registros=15;
            $busqueda=isset($_GET['busqueda']) ? limpiar_cadena($_GET['busqueda']) : "";

            # Paginador tipo de equipo #
            require_once "./php/categoria_lista.php";
        ?>
    </div>
</div>