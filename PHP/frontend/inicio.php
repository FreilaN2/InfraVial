<?php
include_once('../../Templates/header_2.php');
require_once '../../database.php';

// Consultar reportes aprobados y activos
$queryMap = "SELECT id, titulo, descripcion, tipo_incidente, latitud, estatus, prioridad, longitud, fecha_reporte, imagen 
             FROM reportes 
             WHERE estado = 'aprobado' AND estatus = 'activo'";
$resultMap = $conn->query($queryMap);
$reportes = [];
while ($row = $resultMap->fetch_assoc()) {
    $reportes[] = $row;
}
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<div class="container-fluid mt-4">
    <h2 class="text-center mb-4">Reportes Recientes</h2>

    <!-- Mapa de incidentes -->
    <div class="mb-5">
        <h5>Mapa de incidentes en Barinas</h5>
        <div id="map" style="height: 450px; border: 1px solid #ccc;"></div>
    </div>

<!-- Lista de reportes -->
<div class="d-flex flex-wrap gap-3 justify-content-start px-3">
    <?php foreach ($reportes as $rep): ?>
        <?php
            // Ruta de imagen
            $imgRel = str_replace(['../../Public', '../Public', '..'], '/VialBarinas/Public', $rep['imagen']);
            $imgFile = $_SERVER['DOCUMENT_ROOT'] . $imgRel;
            $imgFinal = is_file($imgFile) ? $imgRel : '/VialBarinas/Assets/img/BACHE.webp';

            // Badge color para estatus
            $estatus = strtolower($rep['estatus']);
            $estatusColor = match ($estatus) {
                'resuelto' => 'success',
                'activo'   => 'warning',
                default    => 'secondary'
            };

            // Badge color para prioridad
            $prioridad = strtolower($rep['prioridad']);
            $prioridadColor = match ($prioridad) {
                'alta'   => 'danger',
                'media'  => 'primary',
                'baja'   => 'secondary',
                default  => 'dark'
            };
        ?>
        <a href="/VialBarinas/PHP/frontend/detalle_reporte.php?id=<?= $rep['id'] ?>" class="text-decoration-none text-dark">
            <div class="card shadow-sm" style="width: 18rem; height: 100%; min-height: 450px; display: flex; flex-direction: column;">
                <img src="<?= $imgFinal ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Reporte">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($rep['titulo']) ?></h5>
                    <p class="card-text flex-grow-1 overflow-hidden" style="max-height: 80px;">
                        <?= htmlspecialchars($rep['descripcion']) ?>
                    </p>
                    <p class="card-text small text-muted mt-auto">
                        Reportado el: <?= date('d/m/Y', strtotime($rep['fecha_reporte'])) ?>
                    </p>
                    <div class="d-flex gap-2 mt-2">
                        <span class="badge bg-<?= $estatusColor ?>"><?= ucfirst($estatus) ?></span>
                        <small class="text-muted">Prioridad:</small>
                        <span class="badge bg-<?= $prioridadColor ?>"><?= ucfirst($prioridad) ?></span>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>


</div>

<script>
const iconMap = {
    'Bache': L.icon({ iconUrl: '/VialBarinas/Assets/icons/bache.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Señal': L.icon({ iconUrl: '/VialBarinas/Assets/icons/senal.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Puente': L.icon({ iconUrl: '/VialBarinas/Assets/icons/puente.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Semáforo': L.icon({ iconUrl: '/VialBarinas/Assets/icons/semaforo.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Otro': L.icon({ iconUrl: '/VialBarinas/Assets/icons/otro.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
};

const map = L.map('map').setView([8.6226, -70.2075], 14);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

const reportes = <?= json_encode($reportes) ?>;
reportes.forEach(rep => {
    const icon = iconMap[rep.tipo_incidente] || iconMap['Otro'];
    L.marker([rep.latitud, rep.longitud], { icon }).addTo(map)
     .bindPopup(`<strong>${rep.titulo}</strong><br>${rep.descripcion}<br><small>${rep.fecha_reporte}</small>`);
});
</script>

<?php include_once('../../Templates/footer.php'); ?>
