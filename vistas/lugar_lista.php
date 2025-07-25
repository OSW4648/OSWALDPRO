<?php require_once "./php/main.php"; ?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">
        <span class="icon-text">
            <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
            <span>Lugares</span>
        </span>
    </h1>
    <h2 class="subtitle has-text-grey">Lista de lugares</h2>
</div>

<!-- Botones y buscador centrados y compactos -->
<div class="columns is-vcentered mb-4">
    <div class="column is-4 has-text-centered">
        <a href="index.php?vista=lugar_nuevo" class="button is-success is-rounded is-small mb-1">
            <span class="icon"><i class="fas fa-plus"></i></span>
            <span>Registrar lugar</span>
        </a>
    </div>
    <div class="column is-4"></div>
    <div class="column is-4 has-text-centered">
        <form action="index.php" method="GET" class="field has-addons is-justify-content-center" style="display:inline-flex;">
            <input type="hidden" name="vista" value="lugar_lista">
            <div class="control">
                <input class="input is-small" type="text" name="busqueda" placeholder="Buscar lugar..." value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
            </div>
            <div class="control">
                <button type="submit" class="button is-info is-small">
                    <span class="icon"><i class="fas fa-search"></i></span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="container pb-6 pt-6">
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
            $lugares = conexion()->query("SELECT * FROM lugar $where");
            foreach($lugares as $lugar){
                echo "<tr>
                    <td>{$lugar['id_lugar']}</td>
                    <td>".htmlspecialchars($lugar['nombre'])."</td>
                    <td>
                        <a href='index.php?vista=lugar_update&lugar_id_up={$lugar['id_lugar']}' class='button is-small is-info is-light' title='Editar'>
                            <span class='icon'><i class='fas fa-edit'></i></span>
                        </a>
                        <a href='index.php?vista=lugar_lista&lugar_id_del={$lugar['id_lugar']}' class='button is-small is-danger is-light' title='Eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar este lugar?\")'>
                            <span class='icon'><i class='fas fa-trash'></i></span>
                        </a>
                    </td>
                </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>