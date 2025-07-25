<?php require_once "./php/main.php"; ?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered" style="text-align:left;">
        <span class="icon-text">
            <span class="icon"><i class="fas fa-box"></i></span>
            <span>Lista de Materiales</span>
        </span>
    </h1>
</div>

<div class="container" style="max-width: 900px;">
    <div class="level mb-4">
        <div class="level-left">
            <a href="index.php?vista=material_nuevo" class="button is-success is-rounded is-small mr-3">
                <span class="icon"><i class="fas fa-plus"></i></span>
                <span>Registrar material</span>
            </a>
            <form action="index.php" method="GET" class="field has-addons ml-3">
                <input type="hidden" name="vista" value="material_lista">
                <div class="control">
                    <input class="input is-small" type="text" name="busqueda" placeholder="Buscar material..." value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
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
                </tr>
            </thead>
            <tbody>
            <?php
            $where = "";
            if(isset($_GET['busqueda']) && $_GET['busqueda'] != ""){
                $busqueda = limpiar_cadena($_GET['busqueda']);
                $where = "WHERE nombre LIKE '%$busqueda%'";
            }
            $materiales = conexion()->query("SELECT * FROM material $where");
            foreach($materiales as $mat){
                echo "<tr>
                    <td>{$mat['id_material']}</td>
                    <td>".htmlspecialchars($mat['nombre'])."</td>
                    <td>
                        <a href='php/material_eliminar.php?id={$mat['id_material']}' class='button is-danger is-small'
                           onclick=\"return confirm('¿Seguro que deseas eliminar este material?');\">
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