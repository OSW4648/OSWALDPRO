<?php
require_once "./php/main.php";
$id = limpiar_cadena($_GET['id']);
$conexion = conexion();
$evento = $conexion->query("SELECT e.*, l.nombre as lugar FROM evento e JOIN lugar l ON e.id_lugar=l.id_lugar WHERE e.id_evento='$id'")->fetch();

// Empleados asignados al evento con su área
$empleados = $conexion->query("
    SELECT u.usuario_id, u.usuario_nombre, u.usuario_apellido, a.nombre as area
    FROM evento_usuario eu
    JOIN usuario u ON eu.id_usuario=u.usuario_id
    JOIN area a ON u.usuario_area_id = a.id_area
    WHERE eu.id_evento='$id'
")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container is-fluid mb-6">
    <h1 class="title has-text-black">
        <span class="icon-text">
            <span class="icon"><i class="fas fa-calendar-alt"></i></span>
            <span>Detalle del Evento: <?= htmlspecialchars($evento['nombre']) ?></span>
        </span>
    </h1>
</div>

<div class="container pb-6 pt-6">
    <div class="columns">
        <div class="column is-half">
            <div class="box">
                <h2 class="subtitle mb-2 has-text-black">
                    <span class="icon"><i class="fas fa-info-circle"></i></span> Información General
                </h2>
                <div class="content">
                    <p><strong>Fecha Inicio:</strong> <?= htmlspecialchars($evento['fecha_inicio']) ?></p>
                    <p><strong>Fecha Fin:</strong> <?= htmlspecialchars($evento['fecha_fin']) ?></p>
                    <p><strong>Lugar:</strong> <?= htmlspecialchars($evento['lugar']) ?></p>
                    <p><strong>Horario:</strong> <?= htmlspecialchars($evento['horario']) ?></p>
                    <p><strong>Observaciones:</strong><br>
                        <span class="has-text-grey"><?= nl2br(htmlspecialchars($evento['observaciones'])) ?></span>
                    </p>
                    <p class="mt-3">
                        <strong>Estatus:</strong>
                        <span class="tag <?= $evento['estatus']=='Cerrado' ? 'is-success' : 'is-warning' ?>">
                            <?= $evento['estatus'] ?>
                        </span>
                    </p>
                    <?php if($evento['estatus']=='Cerrado'): ?>
                        <div class="notification is-success is-light mt-3">
                            <strong>Observaciones de cierre:</strong><br>
                            <?= nl2br(htmlspecialchars($evento['observaciones_cierre'])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="column is-half">
            <div class="box">
                <h2 class="subtitle mb-2 has-text-black">
                    <span class="icon"><i class="fas fa-paperclip"></i></span> Archivos adjuntos
                </h2>
                <?php
                if (!empty($evento['archivos_adjuntos'])) {
                    $archivos = json_decode($evento['archivos_adjuntos'], true);
                    if (is_array($archivos)) {
                        foreach ($archivos as $archivo) {
                            $nombre = basename($archivo);
                            $ruta = realpath(__DIR__ . '/../' . ltrim($archivo, '/'));
                            if ($ruta && file_exists($ruta)) {
                                echo "<a href='" . htmlspecialchars($archivo) . "' target='_blank'>Ver archivo</a> | ";
                                echo "<a href='" . htmlspecialchars($archivo) . "' download='$nombre'>Descargar</a><br>";
                            } else {
                                echo "<span class='has-text-danger'>Archivo no encontrado: $nombre</span><br>";
                            }
                        }
                    }
                } else {
                    echo "<span class='has-text-grey'>Sin archivos adjuntos</span>";
                }
                ?>
                <hr>
                <strong>Recursos estimados:</strong>
                <div class="has-text-grey"><?= nl2br(htmlspecialchars($evento['recursos_estimados'] ?? '')) ?></div>
                <strong>Costos estimados:</strong>
                <div class="has-text-grey"><?= htmlspecialchars($evento['costos_estimados'] ?? '') ?></div>
            </div>
        </div>
    </div>

    <div class="box mt-5">
        <h2 class="subtitle mb-2 has-text-black">
            <span class="icon"><i class="fas fa-tasks"></i></span> Tareas asignadas al evento
        </h2>
        <div class="table-container">
            <table class="table is-fullwidth is-striped is-hoverable">
                <thead>
                    <tr>
                        <th class="has-background-link has-text-white">Título</th>
                        <th class="has-background-link has-text-white">Descripción</th>
                        <th class="has-background-link has-text-white">Fecha vencimiento</th>
                        <th class="has-background-link has-text-white">Asignado a</th>
                        <th class="has-background-link has-text-white">Estatus</th>
                        <th class="has-background-link has-text-white">Prioridad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $tareas = $conexion->query("
                        SELECT t.titulo, t.descripcion, t.fecha_vencimiento, t.estatus, t.prioridad,
                            u.usuario_nombre, u.usuario_apellido
                        FROM evento_tarea et
                        JOIN tarea t ON et.tarea_id = t.id_tarea
                        LEFT JOIN usuario u ON t.id_usuario_asignado = u.usuario_id
                        WHERE et.evento_id = '$id'
                    ")->fetchAll(PDO::FETCH_ASSOC);

                    if ($tareas && count($tareas) > 0) {
                        foreach($tareas as $tarea) {
                            // Etiqueta de prioridad
                            $prioridadTag = 'is-light';
                            if ($tarea['prioridad'] == 'Alta') $prioridadTag = 'is-danger';
                            elseif ($tarea['prioridad'] == 'Media') $prioridadTag = 'is-warning';
                            elseif ($tarea['prioridad'] == 'Baja') $prioridadTag = 'is-success';

                            // Etiqueta de estatus
                            $estatusTag = 'is-warning';
                            if ($tarea['estatus'] == 'Completada') $estatusTag = 'is-success';
                            elseif ($tarea['estatus'] == 'En progreso') $estatusTag = 'is-info';

                            echo "<tr>";
                            echo "<td><strong>" . htmlspecialchars($tarea['titulo']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($tarea['descripcion']) . "</td>";
                            echo "<td><span class='tag is-light'>" . htmlspecialchars($tarea['fecha_vencimiento']) . "</span></td>";
                            echo "<td><span class='has-text-link'>" . htmlspecialchars(trim($tarea['usuario_nombre'] . ' ' . $tarea['usuario_apellido'])) . "</span></td>";
                            echo "<td><span class='tag $estatusTag'>" . htmlspecialchars($tarea['estatus']) . "</span></td>";
                            echo "<td><span class='tag $prioridadTag'>" . htmlspecialchars($tarea['prioridad']) . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='has-text-grey'>Sin tareas registradas para este evento</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="buttons is-centered mt-5">
        <a href="index.php?vista=evento_editar&id=<?= htmlspecialchars($evento['id_evento']) ?>" class="button is-link is-medium is-rounded">
            <span class="icon"><i class="fas fa-pen"></i></span>
            <span>Editar evento</span>
        </a>
        <a href="index.php?vista=evento_lista" class="button is-warning is-medium is-rounded">
            <span class="icon"><i class="fas fa-list"></i></span>
            <span>Regresar a lista</span>
        </a>
    </div>
</div>