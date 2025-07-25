<?php
require_once "main.php";
$conexion = conexion();
$query = $conexion->query("
    SELECT equipo.id_equipo, equipo.sku, equipo.numero_serie, descripcion_equipo.nombre, descripcion_equipo.marca, descripcion_equipo.modelo, descripcion_equipo.caracteristicas
    FROM equipo
    INNER JOIN descripcion_equipo ON equipo.id_descripcion_equipo = descripcion_equipo.id_descripcion_equipo
    ORDER BY equipo.id_equipo ASC
");

echo '<table class="table is-fullwidth is-striped is-hoverable">';
echo '<thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>SKU</th>
            <th>Número de Serie</th>
            <th>Ver descripción</th>
        </tr>
    </thead>
    <tbody>';

$contador = 1;
foreach($query as $row){
    // Prepara la descripción para el modal
    $desc = "<strong>Marca:</strong> ".htmlspecialchars($row['marca'])."<br>"
          . "<strong>Modelo:</strong> ".htmlspecialchars($row['modelo'])."<br>"
          . "<strong>Características:</strong> ".htmlspecialchars($row['caracteristicas']);
    $desc = str_replace(["\r", "\n"], ["", "<br>"], $desc); // Soporte para saltos de línea

    echo '<tr>
            <td>'.$contador++.'</td>
            <td>'.htmlspecialchars($row['nombre']).'</td>
            <td>'.htmlspecialchars($row['sku']).'</td>
            <td>'.htmlspecialchars($row['numero_serie']).'</td>
            <td>
                <button class="button is-info is-small is-rounded" onclick="mostrarDescripcion(`'.$desc.'`)">
                    <span class="icon is-small"><i class="fas fa-eye"></i></span>
                    <span>Ver descripción</span>
                </button>
            </td>
        </tr>';
}

echo '</tbody></table>';
$conexion = null;
?>

<!-- Modal Bulma -->
<div class="modal" id="modalDescripcion">
  <div class="modal-background" onclick="cerrarModal()"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Descripción del equipo</p>
      <button class="delete" aria-label="close" onclick="cerrarModal()"></button>
    </header>
    <section class="modal-card-body" id="contenidoDescripcion">
    </section>
    <footer class="modal-card-foot">
      <button class="button" onclick="cerrarModal()">Cerrar</button>
    </footer>
  </div>
</div>

<script>
function mostrarDescripcion(descripcion) {
    document.getElementById('contenidoDescripcion').innerHTML = descripcion;
    document.getElementById('modalDescripcion').classList.add('is-active');
}
function cerrarModal() {
    document.getElementById('modalDescripcion').classList.remove('is-active');
}
</script>