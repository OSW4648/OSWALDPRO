<?php
$conexion = conexion();
$query = $conexion->query("SELECT a.*, u.usuario_nombre, e.numero_serie 
    FROM asignacion_equipo a
    JOIN usuario u ON a.id_usuario = u.usuario_id
    JOIN equipo e ON a.id_equipo = e.id_equipo
    ORDER BY a.fecha_asignacion DESC");
echo "<table class='table is-fullwidth'><tr>
        <th>Usuario</th>
        <th>Equipo</th>
        <th>Fecha Asignación</th>
        <th>Fecha Regreso</th>
        <th>Motivo</th>
        <th>Estatus</th>
        <th>Acción</th>
    </tr>";
while($row = $query->fetch()){
    echo "<tr>
        <td>{$row['usuario_nombre']}</td>
        <td>{$row['numero_serie']}</td>
        <td>{$row['fecha_asignacion']}</td>
        <td>{$row['fecha_regreso']}</td>
        <td>{$row['motivo']}</td>
        <td>
            <span class='tag ".($row['estatus']=='Entregado'?'is-success':'is-warning')."'>
                {$row['estatus']}
            </span>
        </td>
        <td>";
    if($row['estatus'] != 'Entregado'){
        echo "<form action='./php/asignacion_equipo_entregar.php' method='POST' style='display:inline;'>
                <input type='hidden' name='id_asignacion' value='{$row['id_asignacion_equipo']}'>

                <button class='button is-success is-small' type='submit' onclick=\"return confirm('¿Marcar como entregado?')\">Entregado</button>
            </form>";
    } else {
        echo "<button class='button is-small' disabled>Entregado</button>";
    }
    echo "</td>
    </tr>";
}
echo "</table>";
?>