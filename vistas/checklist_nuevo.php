<?php
require_once "./php/main.php";
$conexion = conexion();
$usuario_id = $_SESSION['id'];
$es_admin = ($_SESSION['rol'] ?? '') === 'admin';
$hoy = date('Y-m-d');

// Obtener boutiques (todas las áreas)
$boutiques = $conexion->query("SELECT id_area, nombre FROM area")->fetchAll(PDO::FETCH_ASSOC);

// Inicializa variables
$area_id = null;
$actividades = [];

// Siempre usa el área asignada al usuario (admin o no)
if (isset($_SESSION['usuario_area_id']) && !empty($_SESSION['usuario_area_id'])) {
    $area_id = $_SESSION['usuario_area_id'];
} else {
    // Si no hay área asignada, muestra advertencia y termina
    echo '<div class="container"><div class="notification is-warning">No tienes una boutique/asignada. Contacta al administrador.</div></div>';
    exit;
}

// Si ya hay área seleccionada, busca o crea el checklist
if ($area_id) {
    // Buscar checklist de hoy para esa boutique
    $stmt = $conexion->prepare("SELECT * FROM checklist WHERE area_id=? AND fecha=? ORDER BY id DESC LIMIT 1");
    $stmt->execute([$area_id, $hoy]);
    $checklist = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($checklist) {
        if ($checklist['estatus'] == 'En Proceso') {
            $checklist_id = $checklist['id'];
        } else {
            header("Location: index.php?vista=checklist_ver&id=".$checklist['id']);
            exit;
        }
    } else {
        // Crear nuevo checklist y actividades predefinidas
        $conexion->prepare("INSERT INTO checklist (usuario_id, area_id, fecha, hora_inicio) VALUES (?, ?, ?, NOW())")->execute([$usuario_id, $area_id, $hoy]);
        $checklist_id = $conexion->lastInsertId();
        $actividades_default = ['Esterilización', 'Acomodo de mercancía', 'Atención al cliente'];
        foreach ($actividades_default as $act) {
            $conexion->prepare("INSERT INTO checklist_actividad (checklist_id, nombre_actividad) VALUES (?, ?)")->execute([$checklist_id, $act]);
        }
    }

    // Obtener actividades
    $stmt = $conexion->prepare("SELECT * FROM checklist_actividad WHERE checklist_id=?");
    $stmt->execute([$checklist_id]);
    $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php if (isset($actividades) && is_array($actividades) && count($actividades) > 0): ?>
<div class="container">
    <h1 class="title">Check List del día <?= date('d/m/Y') ?></h1>
    <form action="php/checklist_guardar.php" method="post" enctype="multipart/form-data" id="form-checklist">
        <input type="hidden" name="checklist_id" value="<?= isset($checklist_id) ? $checklist_id : '' ?>">
        <table class="table is-bordered">
            <thead>
                <tr>
                    <th>Actividad</th>
                    <th>Foto</th>
                    <th>Audio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($actividades as $act): ?>
                <tr>
                    <td><?= htmlspecialchars($act['nombre_actividad']) ?></td>
                    <td>
                        <input type="file" name="foto[<?= $act['id'] ?>]" accept="image/*" required>
                    </td>
                    <td>
                        <input type="file" name="audio[<?= $act['id'] ?>]" accept="audio/*" required>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="button is-success" type="submit">Finalizar Check List</button>
    </form>
</div>
<script>
let checklistCompleto = false;
window.onbeforeunload = function() {
    if (!checklistCompleto && <?= isset($checklist_id) ? 'true' : 'false' ?>) {
        fetch('php/checklist_cerrar.php', {
            method: 'POST',
            body: new URLSearchParams({ checklist_id: <?= isset($checklist_id) ? $checklist_id : '0' ?> })
        });
        return "Debes completar y adjuntar todas las evidencias antes de salir. Si sales, ya no podrás volver a abrir este check list.";
    }
};
document.getElementById('form-checklist').onsubmit = function() {
    checklistCompleto = true;
};
</script>
<?php else: ?>
<div class="container">
    <div class="notification is-warning">
        Debes seleccionar una boutique para continuar con el check list.
    </div>
</div>
<?php endif; ?>
<?php
echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>