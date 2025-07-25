<?php
require_once "main.php";
$conexion = conexion();

// Guardar imagen final generada (muestra)
function guardarImagenFinal($dataUrl) {
    if(!$dataUrl) return "";
    $dir = "../uploads/bordados/";
    if(!is_dir($dir)) mkdir($dir, 0777, true);
    $img = str_replace('data:image/png;base64,', '', $dataUrl);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $nombreArchivo = uniqid()."_muestra.png";
    $ruta = $dir . $nombreArchivo;
    file_put_contents($ruta, $data);
    return "uploads/bordados/".$nombreArchivo;
}

// Validar datos requeridos
$campos_requeridos = [
    'area_id', 'vendedor_id', 'cliente', 'departamento',
    'numero_contratacion', 'fecha_solicitud', 'tipo_tela_color', 'folio_ticket'
];
foreach ($campos_requeridos as $campo) {
    if (empty($_POST[$campo])) {
        die("Falta el campo requerido: $campo");
    }
}

if (empty($_POST['logotipo_img_final'])) {
    die("Error: La imagen final no se generó correctamente.");
}

if (strpos($_POST['logotipo_img_final'], 'data:image/png;base64,') === false) {
    die("Error: El formato de la imagen final no es válido.");
}

// Guardar la imagen final
$muestra_final = guardarImagenFinal($_POST['logotipo_img_final'] ?? "");

// Guarda el bordado principal
$stmt = $conexion->prepare("INSERT INTO bordado 
    (area_id, vendedor_id, cliente, departamento, numero_contratacion, fecha_solicitud, tipo_tela_color, muestra_final, folio_ticket)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$exito = $stmt->execute([
    $_POST['area_id'],
    $_POST['vendedor_id'],
    $_POST['cliente'],
    $_POST['departamento'],
    $_POST['numero_contratacion'],
    $_POST['fecha_solicitud'],
    $_POST['tipo_tela_color'],
    $muestra_final,
    $_POST['folio_ticket']
]);

if (!$exito) {
    die("Error al guardar el bordado.");
}

$bordado_id = $conexion->lastInsertId();

// Guardar detalles por prenda
if (!empty($_POST['detalles_prenda']) && is_array($_POST['detalles_prenda'])) {
    // Cambia la consulta de detalle:
    $stmtDetalle = $conexion->prepare("INSERT INTO bordado_detalle (bordado_id, sku, talla, cantidad, descripcion, tipografia, codigo_hilo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($_POST['detalles_prenda'] as $detalle) {
        $sku = $detalle['sku'] ?? '';
        $talla = $detalle['talla'] ?? '';
        $cantidad = $detalle['cantidad'] ?? 0;
        $descripcion = $detalle['descripcion'] ?? '';
        $tipografia = $detalle['tipografia'] ?? '';
        $codigo_hilo = $detalle['codigo_hilo'] ?? '';
        $stmtDetalle->execute([$bordado_id, $sku, $talla, $cantidad, $descripcion, $tipografia, $codigo_hilo]);
    }
}

header("Location: ../index.php?vista=bordado_lista");
exit;
?>
<select name="area_id" required>
    <!-- Opciones de áreas -->
</select>

<select name="vendedor_id" required>
    <!-- Opciones de vendedores -->
</select>
<?php
$stmt = $conexion->prepare(
    "SELECT b.*, v.nombre AS vendedor_nombre, a.nombre AS area_nombre
     FROM bordado b
     LEFT JOIN vendedor v ON b.vendedor_id = v.id
     LEFT JOIN area a ON b.area_id = a.id_area
     WHERE b.id = ?"
);
$stmt->execute([$id]);
$bordado = $stmt->fetch();
?>
<?php
print_r($_POST['logotipo_img_final']);
die();
?>
<div class="field">
    <label class="label">Estatus</label>
    <div class="select">
        <select name="estatus" required>
            <option value="Pendiente" <?php if($bordado['estatus']=='Pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="Realizado" <?php if($bordado['estatus']=='Realizado') echo 'selected'; ?>>Realizado</option>
        </select>
    </div>
</div>