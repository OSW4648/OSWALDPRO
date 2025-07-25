<div class="container is-fluid mb-6">
    <h1 class="title has-text-black">
        <span class="icon-text">
            <span class="icon">
                <i class="fas fa-box"></i>
            </span>
            <span>Equipos</span>
        </span>
    </h1>
    <h2 class="subtitle has-text-grey">Lista de equipos por tipo</h2>
</div>

<div class="container pb-6 pt-6">
    <?php require_once "./php/main.php"; ?>
    <div class="columns">
        <div class="column is-one-third">
            <h2 class="title has-text-centered">Tipos de equipo</h2>
            <?php
                $categorias=conexion();
                $categorias=$categorias->query("SELECT * FROM tipo_equipo");
                if($categorias->rowCount()>0){
                    $categorias=$categorias->fetchAll();
                    foreach($categorias as $row){
                        echo '<a href="index.php?vista=product_category&category_id='.$row['id_tipo_equipo'].'" class="button is-link is-inverted is-fullwidth mb-2">'.$row['nombre'].'</a>';
                    }
                }else{
                    echo '<p class="has-text-centered" >No hay tipos de equipo registrados</p>';
                }
                $categorias=null;
            ?>
        </div>
        <div class="column">
            <?php
                $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

                /*== Verificando tipo de equipo ==*/
                $check_categoria=conexion();
                $check_categoria=$check_categoria->query("SELECT * FROM tipo_equipo WHERE id_tipo_equipo='$categoria_id'");

                if($check_categoria->rowCount()>0){

                    $check_categoria=$check_categoria->fetch();

                    echo '
                        <h2 class="title has-text-centered">'.$check_categoria['nombre'].'</h2>
                    ';

                    require_once "./php/main.php";

                    # Eliminar producto #
                    if(isset($_GET['product_id_del'])){
                        require_once "./php/producto_eliminar.php";
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
                    $url="index.php?vista=product_category&category_id=$categoria_id&page=";
                    $registros=15;
                    $busqueda="";

                    # Paginador producto #
                    require_once "./php/producto_lista.php";

                }else{
                    echo '<h2 class="has-text-centered title" >Seleccione un tipo de equipo para empezar</h2>';
                }
                $check_categoria=null;
            ?>
        </div>
    </div>
</div>
<div class="level mb-4">
    <div class="level-left">
        <a href="index.php?vista=product_list" class="button is-light is-rounded">
            <span class="icon"><i class="fas fa-arrow-left"></i></span>
            <span>Regresar a lista de equipos</span>
        </a>
    </div>
</div>