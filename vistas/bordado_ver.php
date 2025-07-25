<?php
require_once "./php/main.php";
$conexion = conexion();
$id = intval($_GET['id']);

// Traer el bordado junto con el nombre del vendedor y el área
$stmt = $conexion->prepare(
    "SELECT b.*, v.nombre AS vendedor_nombre, a.nombre AS area_nombre
     FROM bordado b
     LEFT JOIN vendedor v ON b.vendedor_id = v.id
     LEFT JOIN area a ON b.area_id = a.id_area
     WHERE b.id = ?"
);
$stmt->execute([$id]);
$bordado = $stmt->fetch();
if(!$bordado){
    echo "<p>No encontrado</p>";
    exit;
}

// Detalles por prenda
$stmtDetalle = $conexion->prepare("SELECT * FROM bordado_detalle WHERE bordado_id = ?");
$stmtDetalle->execute([$bordado['id']]);
$detalles = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="columns is-vcentered mb-4">
        <div class="column">
            <button class="button is-link mt-4" onclick="window.history.back();">Regresar</button>
        </div>
        <div class="column is-narrow has-text-right">
            <!-- Cambiar estatus a Realizado -->
            <?php if ($bordado['estatus'] == 'Pendiente'): ?>
                <form method="post" action="php/bordado_estatus.php" style="display:inline-block;">
                    <input type="hidden" name="id" value="<?php echo $bordado['id']; ?>">
                    <button class="button is-success is-small" type="submit" onclick="return confirm('¿Marcar este bordado como Realizado? Esta acción no se puede deshacer.');">
                        <span class="icon"><i class="fas fa-check"></i></span>
                        <span>Marcar como Realizado</span>
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="box" style="max-width:900px; margin:0 auto 2rem auto;">
        <h1 class="title has-text-centered">Bordado #<?php echo $bordado['id']; ?></h1>
        <h2 class="subtitle has-text-centered">Datos del Bordado</h2>
        <table class="table is-bordered is-striped is-narrow is-fullwidth" style="margin:0 auto;">
            <tbody>
                <tr><th>Sucursal</th><td><?php echo htmlspecialchars($bordado['area_nombre'] ?? ''); ?></td></tr>
                <tr><th>Vendedor</th><td><?php echo htmlspecialchars($bordado['vendedor_nombre']); ?></td></tr>
                <tr><th>Cliente</th><td><?php echo htmlspecialchars($bordado['cliente']); ?></td></tr>
                <tr><th>Empresa</th><td><?php echo htmlspecialchars($bordado['departamento']); ?></td></tr>
                <tr><th>Numero de contacto</th><td><?php echo htmlspecialchars($bordado['numero_contratacion']); ?></td></tr>
                <tr><th>Fecha de solicitud</th><td><?php echo htmlspecialchars($bordado['fecha_solicitud']); ?></td></tr>
                <tr><th>Tipo/tela y color</th><td><?php echo htmlspecialchars($bordado['tipo_tela_color']); ?></td></tr>
                <tr><th>Folio de ticket</th><td><?php echo htmlspecialchars($bordado['folio_ticket']); ?></td></tr>
                <tr><th>Estatus</th><td>
                    <?php
                        if ($bordado['estatus'] == 'Realizado') {
                            echo '<span class="tag is-success">Realizado</span>';
                        } else {
                            echo '<span class="tag is-warning">Pendiente</span>';
                        }
                    ?>
                </td></tr>
            </tbody>
        </table>
    </div>

    <?php if($detalles): ?>
        <div class="box" style="max-width:900px; margin:0 auto 2rem auto;">
            <h2 class="subtitle has-text-centered">Detalles por prenda</h2>
            <table class="table is-bordered is-narrow is-fullwidth" style="margin:0 auto;">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Talla</th>
                        <th>Cantidad</th>
                        <th>Nombre/Descripción</th>
                        <th>Tipografía</th>
                        <th>Código de hilo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($detalles as $fila): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['sku']); ?></td>
                            <td><?php echo htmlspecialchars($fila['talla']); ?></td>
                            <td><?php echo htmlspecialchars($fila['cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($fila['tipografia']); ?></td>
                            <td><?php echo htmlspecialchars($fila['codigo_hilo']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="box has-text-centered" style="max-width:900px; margin:0 auto 2rem auto;">
        <h2 class="subtitle">Vista final del bordado</h2>
        <?php if(!empty($bordado['muestra_final'])): ?>
            <div style="display:flex; justify-content:center; align-items:center; min-height:400px;">
                <img src="<?php echo htmlspecialchars($bordado['muestra_final']); ?>"
                     style="max-width: 400px; max-height: 400px; width: auto; height: auto; border:2px solid #3273dc; border-radius:16px; box-shadow:0 2px 16px rgba(50,115,220,0.15); background: #fff;">
            </div>
            <div class="has-text-centered" style="margin-top: 15px;">
                <a href="<?php echo htmlspecialchars($bordado['muestra_final']); ?>" download="muestra_bordado_<?php echo $bordado['id']; ?>.png" class="button is-primary is-small">
                    <span class="icon"><i class="fas fa-download"></i></span>
                    <span>Descargar muestra final</span>
                </a>
            </div>
        <?php else: ?>
            <div class="notification is-warning has-text-centered">
                No se ha generado la imagen final del bordado.
            </div>
        <?php endif; ?>
    </div>
</div>