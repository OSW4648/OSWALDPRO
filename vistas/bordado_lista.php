<?php require_once "./php/main.php"; ?>
<div class="container is-fluid mb-6">
    <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
    <h1 class="title has-text-centered">Lista de Bordados</h1>
</div>
<div class="container pb-6 pt-6">
    <a href="index.php?vista=bordado_nuevo" class="button is-success is-rounded mb-4">
        <span class="icon"><i class="fas fa-plus"></i></span>
        <span>Registrar bordado</span>
    </a>
    <table class="table is-fullwidth is-hoverable is-striped">
        <thead>
            <tr>
                <th>Folio</th>
                <th>Área</th>
                <th>Vendedor</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Estatus</th> <!-- Nueva columna -->
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $conexion = conexion();
        $query = $conexion->query(
            "SELECT b.id, b.cliente, b.fecha_solicitud, b.estatus,
                    v.nombre AS vendedor_nombre, 
                    a.nombre AS area_nombre
             FROM bordado b
             LEFT JOIN vendedor v ON b.vendedor_id = v.id
             LEFT JOIN area a ON b.area_id = a.id_area
             ORDER BY b.id DESC"
        );
        foreach($query as $row){
            echo "<tr>
                <td>{$row['id']}</td>
                <td>".htmlspecialchars($row['area_nombre'] ?? '')."</td>
                <td>".htmlspecialchars($row['vendedor_nombre'] ?? '')."</td>
                <td>".htmlspecialchars($row['cliente'] ?? '')."</td>
                <td>{$row['fecha_solicitud']}</td>
                <td>";
            if ($row['estatus'] == 'Realizado') {
                echo '<span class="tag is-success">Realizado</span>';
            } else {
                echo '<span class="tag is-warning">Pendiente</span>';
            }
            echo "</td>
                <td>
                    <a href=\"index.php?vista=bordado_ver&id={$row['id']}\" class=\"button is-small is-info\">Ver</a>
                    <a href=\"php/bordado_eliminar.php?id={$row['id']}\" class=\"button is-small is-danger\" onclick=\"return confirm('¿Seguro que deseas eliminar este bordado?');\">Eliminar</a>
                </td>
            </tr>";
        }
        ?>
        </tbody>
    </table>
</div>