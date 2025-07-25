<?php require_once "./php/main.php"; ?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered" style="text-align:left;">
        <span class="icon-text">
            <span class="icon"><i class="fas fa-building"></i></span>
            <span>Nueva Area</span>
        </span>
    </h1>
</div>
<div class="container pb-6 pt-6">

    <a href="index.php?vista=area_lista" class="button is-light is-rounded mb-4">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Regresar a la lista</span>
    </a>

    <form action="./php/area_guardar.php" method="POST" class="box" autocomplete="off">
        <div class="field">
            <label class="label">Nombre del Área</label>
            <input class="input" type="text" name="nombre" required>
        </div>
        <div class="field">
            <button type="submit" class="button is-success">Guardar Área</button>
        </div>
    </form>
</div>