<?php
require_once '../../database.php';
include_once('../../Templates/header_2.php');

if (!isset($_GET['id'])) {
    echo "<div class='container mt-5 alert alert-danger'>ID de reporte no especificado.</div>";
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT r.*, u.nombre AS ciudadano FROM reportes r 
          JOIN usuarios u ON r.usuario_id = u.id 
          WHERE r.id = $id LIMIT 1";

$result = $conn->query($query);
if ($result->num_rows === 0) {
    echo "<div class='container mt-5 alert alert-warning'>Reporte no encontrado.</div>";
    exit();
}

$reporte = $result->fetch_assoc();

// Imagen
$imgRel = str_replace(['../../Public', '../Public', '..'], '/VialBarinas/Public', $reporte['imagen']);
$imgFile = $_SERVER['DOCUMENT_ROOT'] . $imgRel;
$imgFinal = is_file($imgFile) ? $imgRel : '/VialBarinas/Assets/img/BACHE.webp';

// Map link
$mapaUrl = "https://maps.google.com/maps?q={$reporte['latitud']},{$reporte['longitud']}&hl=es&z=16&output=embed";

// Colores
$estatusColor = $reporte['estatus'] === 'resuelto' ? 'success' : 'warning';
$prioridadColor = match ($reporte['prioridad']) {
    'alta' => 'danger',
    'media' => 'primary',
    'baja' => 'secondary',
    default => 'dark'
};
?>

<div class="container mt-5">
    <h2 class="mb-4"><?= htmlspecialchars($reporte['titulo']) ?></h2>

    <div class="card shadow">
        <img src="<?= $imgFinal ?>" class="card-img-top" alt="Imagen del reporte" style="max-height: 400px; object-fit: cover;">
        <div class="card-body">
            <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($reporte['descripcion'])) ?></p>
            <p><strong>Tipo de incidente:</strong> <?= htmlspecialchars($reporte['tipo_incidente']) ?></p>
            <p><strong>Reportado por:</strong> <?= htmlspecialchars($reporte['ciudadano']) ?></p>
            <p><strong>Fecha del reporte:</strong> <?= date("d/m/Y H:i", strtotime($reporte['fecha_reporte'])) ?></p>
            <p><strong>Estado:</strong> <?= ucfirst($reporte['estado']) ?></p>
            <p><strong>Estatus:</strong> <span class="badge bg-<?= $estatusColor ?>"><?= ucfirst($reporte['estatus']) ?></span></p>
            <p><strong>Prioridad:</strong> <span class="badge bg-<?= $prioridadColor ?>"><?= ucfirst($reporte['prioridad']) ?></span></p>
        </div>
    </div>

    <div class="mt-4">
        <h5>Ubicación del incidente</h5>
        <div class="ratio ratio-16x9">
            <iframe src="<?= $mapaUrl ?>" width="100%" height="400" style="border:0;" allowfullscreen></iframe>
        </div>
    </div>
</div>

<?php include_once('../../Templates/footer.php'); ?>
