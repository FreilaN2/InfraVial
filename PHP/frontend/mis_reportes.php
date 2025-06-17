<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_view.php");
    exit();
}

require_once '../../database.php';

$usuario_id = $_SESSION['usuario_id'];

$query = $conn->prepare("
    SELECT id, titulo, descripcion, tipo_incidente, imagen, estado, estatus, fecha_reporte
    FROM reportes
    WHERE usuario_id = ?
    ORDER BY fecha_reporte DESC
");
$query->bind_param("i", $usuario_id);
$query->execute();
$resultado = $query->get_result();
?>

<?php include_once('../../Templates/header_2.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4"><i class="bi bi-folder"></i> Mis Reportes</h2>

    <?php if ($resultado->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Estatus</th>
                        <th>Fecha</th>
                        <th>Imagen</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($reporte = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $reporte['id']; ?></td>
                            <td><?php echo htmlspecialchars($reporte['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($reporte['tipo_incidente']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $reporte['estado'] === 'pendiente' ? 'warning' : ($reporte['estado'] === 'aprobado' ? 'success' : 'danger'); ?>">
                                    <?php echo $reporte['estado']; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-<?php echo $reporte['estatus'] === 'activo' ? 'primary' : 'secondary'; ?>">
                                    <?php echo $reporte['estatus']; ?>
                                </span>
                            </td>
                            <td><?php echo date("d/m/Y H:i", strtotime($reporte['fecha_reporte'])); ?></td>
                            <td>
                                <?php if (!empty($reporte['imagen'])): ?>
                                    <img src="/VialBarinas/Public/Uploads/<?php echo htmlspecialchars($reporte['imagen']); ?>" alt="Imagen" width="60" height="60">
                                <?php else: ?>
                                    <span class="text-muted">Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-start"><?php echo nl2br(htmlspecialchars($reporte['descripcion'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No has enviado ningún reporte aún.</div>
    <?php endif; ?>
</div>


<?php include_once('../../Templates/footer.php'); ?>
