<?php require_once "./php/main.php"; ?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">Lista de Eventos</h1>
</div>
<div class="container pb-6 pt-6">
    <?php if(isset($_GET['error']) && $_GET['error'] == 'relacion'): ?>
        <div class="notification is-danger is-light">
            <strong>No se puede eliminar el evento.</strong><br>
            Este evento tiene tareas asociadas. Elimina primero las tareas o sus relaciones antes de eliminar el evento.
        </div>
    <?php elseif(isset($_GET['msg']) && $_GET['msg'] == 'eliminado'): ?>
        <div class="notification is-success is-light">
            Evento eliminado correctamente.
        </div>
    <?php endif; ?>
    <form method="GET" class="box mb-4" style="display:flex;gap:1rem;align-items:end;">
        <input type="hidden" name="vista" value="evento_lista">
        <div>
            <label class="label">Fecha inicio (de):</label>
            <input type="date" name="fecha_inicio" class="input" value="<?= htmlspecialchars($_GET['fecha_inicio'] ?? '') ?>">
        </div>
        <div>
            <label class="label">Fecha fin (hasta):</label>
            <input type="date" name="fecha_fin" class="input" value="<?= htmlspecialchars($_GET['fecha_fin'] ?? '') ?>">
        </div>
        <div>
            <button type="submit" class="button is-link">Buscar</button>
            <a href="index.php?vista=evento_lista" class="button is-light">Limpiar</a>
        </div>
    </form>
    <table class="table is-fullwidth">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Lugar</th>
                <th>Recursos</th>
                <th>Costos</th>
                <th>Estatus</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $conexion = conexion();

        $fecha_inicio = $_GET['fecha_inicio'] ?? '';
        $fecha_fin = $_GET['fecha_fin'] ?? '';

        $where = [];
        $params = [];

        if($fecha_inicio != '' && $fecha_fin != ''){
            // Entre dos fechas
            $where[] = "e.fecha_inicio >= ? AND e.fecha_fin <= ?";
            $params[] = $fecha_inicio;
            $params[] = $fecha_fin;
        } elseif($fecha_inicio != '') {
            // Solo esa fecha exacta
            $where[] = "e.fecha_inicio = ?";
            $params[] = $fecha_inicio;
        } elseif($fecha_fin != '') {
            // Solo esa fecha exacta
            $where[] = "e.fecha_fin = ?";
            $params[] = $fecha_fin;
        }

        $sql = "SELECT e.*, l.nombre as lugar FROM evento e JOIN lugar l ON e.id_lugar=l.id_lugar";
        if(count($where) > 0){
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY e.fecha_inicio DESC";

        $query = $conexion->prepare($sql);
        $query->execute($params);

        while($row = $query->fetch()){
            echo "<tr>
                <td><strong>".htmlspecialchars($row['nombre'])."</strong></td>
                <td>".htmlspecialchars($row['fecha_inicio'])."</td>
                <td>".htmlspecialchars($row['fecha_fin'])."</td>
                <td>".htmlspecialchars($row['lugar'])."</td>
                <td><span class='has-text-grey-dark'>".nl2br(htmlspecialchars($row['recursos_estimados'] ?? ''))."</span></td>
                <td class='has-text-right'>".
                    (is_numeric($row['costos_estimados']) ? '$'.number_format($row['costos_estimados'],2,'.',',') : htmlspecialchars($row['costos_estimados'] ?? ''))
                ."</td>
                <td>
                    <span class='tag ".($row['estatus']=='Cerrado'?'is-success':'is-warning')." is-medium'>
                        {$row['estatus']}
                    </span>
                </td>
                <td class='has-text-centered'>
                    <a href='index.php?vista=evento_detalle&id={$row['id_evento']}' class='button is-link is-small' title='Ver Detalle'>
                        <span class='icon'><i class='fas fa-eye'></i></span>
                    </a> ";
            if($row['estatus'] != 'Cerrado'){
                echo "<a href='index.php?vista=evento_cerrar&id={$row['id_evento']}' class='button is-success is-small' title='Cerrar Evento'>
                        <span class='icon'><i class='fas fa-lock'></i></span>
                    </a> ";
            }
            echo "<a href='php/evento_eliminar.php?id={$row['id_evento']}' class='button is-danger is-small'
                    onclick=\"return confirm('¿Seguro que deseas eliminar este evento?');\" title='Eliminar'>
                    <span class='icon'><i class='fas fa-trash'></i></span>
                </a>";
            echo "</td></tr>";
        }
        $tareas = $conexion->query("SELECT * FROM tarea")->fetchAll(PDO::FETCH_ASSOC);
        ?>
        </tbody>
    </table>
</div>