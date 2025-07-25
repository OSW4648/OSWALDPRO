<?php require_once "./php/main.php"; ?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered" style="text-align:left;">
        <span class="icon-text">
            <span class="icon"><i class="fas fa-building"></i></span>
            <span>Lista de Áreas</span>
        </span>
    </h1>
</div>

<div class="container" style="max-width: 900px;">
    <div class="level mb-4">
        <div class="level-left">
            <a href="index.php?vista=area_nueva" class="button is-success is-rounded is-small mr-3">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Registrar área</span>
            </a>
            <form action="index.php" method="GET" class="field has-addons ml-3">
                <input type="hidden" name="vista" value="area_lista">
                <div class="control">
                    <input class="input is-small" type="text" name="busqueda" placeholder="Buscar área..." value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
                </div>
                <div class="control">
                    <button type="submit" class="button is-info is-small">
                        <span class="icon"><i class="fas fa-search"></i></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="box">
        <table class="table is-fullwidth is-hoverable is-striped has-text-centered">
            <thead class="has-background-link-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $where = "";
            if(isset($_GET['busqueda']) && $_GET['busqueda'] != ""){
                $busqueda = limpiar_cadena($_GET['busqueda']);
                $where = "WHERE nombre LIKE '%$busqueda%'";
            }
            $areas = conexion()->query("SELECT * FROM area $where");
            foreach($areas as $area){
                echo "<tr>
                    <td>{$area['id_area']}</td>
                    <td>".htmlspecialchars($area['nombre'])."</td>
                    <td>
                        <a href='php/area_eliminar.php?id={$area['id_area']}' class='button is-danger is-small' onclick=\"return confirm('¿Seguro que deseas eliminar esta área?');\">
                            <span class='icon'><i class='fas fa-trash'></i></span>
                            <span>Eliminar</span>
                        </a>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>