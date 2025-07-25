<?php
require_once "./php/main.php";
$conexion = conexion();
$usuario_id = $_SESSION['id'];
$es_admin = ($_SESSION['rol'] ?? '') === 'admin';

if ($es_admin) {
    $stmt = $conexion->query("SELECT c.*, u.nombre AS usuario_nombre FROM checklist c LEFT JOIN usuario u ON c.usuario_id=u.id ORDER BY fecha DESC");
} else {
    $stmt = $conexion->prepare("SELECT * FROM checklist WHERE usuario_id=? ORDER BY fecha DESC");
    $stmt->execute([$usuario_id]);
}
?>
<div class="container">
    <h1 class="title">Lista de Check List</h1>
    <table class="table is-fullwidth is-hoverable is-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <?php if($es_admin): ?><th>Usuario</th><?php endif; ?>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($row['fecha']) ?></td>
                <?php if($es_admin): ?><td><?= htmlspecialchars($row['usuario_nombre'] ?? '') ?></td><?php endif; ?>
                <td>
                    <?php
                        if ($row['estatus'] == 'Completado') echo '<span class="tag is-success">Completado</span>';
                        elseif ($row['estatus'] == 'Cerrado por salir') echo '<span class="tag is-danger">Cerrado por salir</span>';
                        else echo '<span class="tag is-warning">En Proceso</span>';
                    ?>
                </td>
                <td>
                    <a href="index.php?vista=checklist_ver&id=<?= $row['id'] ?>" class="button is-small is-info">Ver</a>
                    <?php if($es_admin && $row['estatus']=='Cerrado por salir'): ?>
                        <a href="php/checklist_reabrir.php?id=<?= $row['id'] ?>" class="button is-small is-warning" onclick="return confirm('¿Reabrir este checklist?');">Reabrir</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>