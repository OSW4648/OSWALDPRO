<?php
?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">
        <span class="icon-text">
            <span class="icon">
                <i class="fas fa-desktop"></i>
            </span>
            <span>Equipos</span>
        </span>
    </h1>
</div>

<div class="container pb-6 pt-6">
    <div class="box">

        <!-- Botón para nuevo equipo y buscador -->
        <div class="level mb-4">
            <div class="level-left">
                <a href="index.php?vista=equipo_nuevo" class="button is-success is-rounded">
                    <span class="icon"><i class="fas fa-plus"></i></span>
                    <span>Nuevo equipo</span>
                </a>
            </div>
            <div class="level-right">
                <form action="index.php?vista=equipo_lista" method="GET" class="field has-addons">
                    <input type="hidden" name="vista" value="equipo_lista">
                    <div class="control">
                        <input class="input" type="text" name="busqueda" placeholder="Buscar equipo..." value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
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

        <?php require_once "./php/equipo_lista.php"; ?>
    </div>
</div>