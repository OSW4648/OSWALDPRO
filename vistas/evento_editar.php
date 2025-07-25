<?php
require_once "./php/main.php";
$id = limpiar_cadena($_GET['id'] ?? '');
$conexion = conexion();
$evento = $conexion->query("SELECT * FROM evento WHERE id_evento='$id'")->fetch();

if(!$evento){
    echo '<div class="notification is-danger">Evento no encontrado.</div>';
    exit;
}

// NUEVO BLOQUE: Si el evento está cerrado, muestra mensaje y detén el script
if($evento['estatus'] == 'Cerrado'){
    echo '<div class="notification is-warning is-light">
        <strong>Este evento está cerrado y no puede ser modificado.</strong>
        <br>
        <a href="index.php?vista=evento_detalle&id='.htmlspecialchars($evento['id_evento']).'" class="button is-link is-light mt-3">Volver al detalle</a>
    </div>';
    exit;
}

// Obtener lugares para el select
$lugares = $conexion->query("SELECT * FROM lugar")->fetchAll(PDO::FETCH_ASSOC);

// Obtener materiales del evento
$materiales = $conexion->query(
    "SELECT em.id_evento_material, em.cantidad, m.nombre as material, a.nombre as area
     FROM evento_material em
     JOIN material m ON em.id_material = m.id_material
     JOIN area a ON em.id_area = a.id_area
     WHERE em.id_evento = '$id'"
)->fetchAll(PDO::FETCH_ASSOC);

$areas = $conexion->query("SELECT id_area, nombre FROM area")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container is-fluid mb-6">
    <h1 class="title has-text-black">
        <span class="icon-text">
            <span class="icon"><i class="fas fa-calendar-alt"></i></span>
            <span>Editar Evento</span>
        </span>
    </h1>
</div>
<div class="container pb-6 pt-6">
    <a href="index.php?vista=evento_detalle&id=<?= htmlspecialchars($evento['id_evento']) ?>" class="button is-light is-rounded mb-4">
        <span class="icon"><i class="fas fa-arrow-left"></i></span>
        <span>Regresar al detalle</span>
    </a>
    <form action="./php/evento_actualizar.php" method="POST" class="box" autocomplete="off">
        <input type="hidden" name="id_evento" value="<?= htmlspecialchars($evento['id_evento']) ?>">
        <div class="columns">
            <div class="column">
                <label class="label">Nombre del Evento</label>
                <input class="input" type="text" name="nombre" required value="<?= htmlspecialchars($evento['nombre']) ?>">
            </div>
            <div class="column">
                <label class="label">Lugar</label>
                <div class="select is-fullwidth">
                    <select name="id_lugar" required>
                        <option value="">Seleccione un lugar</option>
                        <?php foreach($lugares as $lugar): ?>
                            <option value="<?= $lugar['id_lugar'] ?>" <?= $lugar['id_lugar']==$evento['id_lugar'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($lugar['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <label class="label">Fecha de Inicio</label>
                <input class="input" type="date" name="fecha_inicio" required value="<?= htmlspecialchars($evento['fecha_inicio']) ?>">
            </div>
            <div class="column">
                <label class="label">Fecha de Fin</label>
                <input class="input" type="date" name="fecha_fin" required value="<?= htmlspecialchars($evento['fecha_fin']) ?>">
            </div>
            <div class="column">
                <label class="label">Horario</label>
                <input class="input" type="text" name="horario" value="<?= htmlspecialchars($evento['horario']) ?>">
            </div>
        </div>
        <div class="field">
            <label class="label">Observaciones</label>
            <textarea class="textarea" name="observaciones"><?= htmlspecialchars($evento['observaciones']) ?></textarea>
        </div>

        <div class="box mt-5">
            <h2 class="subtitle has-text-black">Materiales para traslado</h2>
            <table class="table is-fullwidth is-striped is-hoverable">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Área Responsable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($materiales as $mat): ?>
                    <tr>
                        <td><?= htmlspecialchars($mat['material']) ?></td>
                        <td>
                            <input class="input is-small" type="number" min="1" name="cantidades[<?= $mat['id_evento_material'] ?>]" value="<?= htmlspecialchars($mat['cantidad']) ?>" required>
                        </td>
                        <td>
                            <div class="select is-small is-fullwidth">
                                <select name="areas[<?= $mat['id_evento_material'] ?>]" required>
                                    <?php foreach($areas as $area): ?>
                                        <option value="<?= $area['id_area'] ?>" <?= $area['nombre'] == $mat['area'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($area['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="field">
            <label class="label">Recursos Estimados</label>
            <textarea class="textarea" name="recursos_estimados"><?= htmlspecialchars($evento['recursos_estimados'] ?? '') ?></textarea>
        </div>
        <div class="field">
            <label class="label">Costos Estimados</label>
            <input class="input" type="text" name="costos_estimados" value="<?= htmlspecialchars($evento['costos_estimados'] ?? '') ?>">
        </div>
        <div class="field">
            <label class="label">Archivos Adjuntos</label>
            <input class="input" type="file" name="archivos_adjuntos[]" multiple>
            <?php
            if (!empty($evento['archivos_adjuntos'])) {
                $archivos = json_decode($evento['archivos_adjuntos'], true);
                if (is_array($archivos)) {
                    foreach ($archivos as $archivo) {
                        $nombre = basename($archivo);
                        echo "<br><a href='" . htmlspecialchars($archivo) . "' target='_blank'>$nombre</a>";
                    }
                }
            }
            ?>
        </div>

        <div class="field is-grouped is-grouped-centered mt-5">
            <div class="control">
                <button type="submit" class="button is-success is-medium is-rounded">
                    <span class="icon"><i class="fas fa-save"></i></span>
                    <span>Guardar cambios</span>
                </button>
            </div>
        </div>
    </form>
</div>