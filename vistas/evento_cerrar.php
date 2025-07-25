<?php
require_once "./php/main.php";
$id = limpiar_cadena($_GET['id']);
$conexion = conexion();
$evento = $conexion->query("SELECT * FROM evento WHERE id_evento='$id'")->fetch();
?>
<div class="container is-fluid mb-6">
    <h1 class="title">Cerrar Evento: <?= $evento['nombre'] ?></h1>
</div>
<div class="container pb-6 pt-6">
    <form action="./php/evento_cerrar.php" method="POST" class="box">
        <input type="hidden" name="id_evento" value="<?= $evento['id_evento'] ?>">
        <div class="field">
            <label class="label">Observaciones de cierre</label>
            <textarea class="textarea" name="observaciones_cierre" required></textarea>
        </div>
        <div class="field">
            <button type="submit" class="button is-success">Cerrar Evento</button>
        </div>
    </form>
</div>