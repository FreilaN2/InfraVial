<?php
include_once('../../Templates/header_4.php');
require_once '../../database.php';

// Consultar reportes aprobados y activos
$queryMap = "SELECT id, titulo, descripcion, tipo_incidente, latitud, longitud, fecha_reporte, imagen 
             FROM reportes 
             WHERE estado = 'aprobado' AND estatus = 'activo'";
$resultMap = $conn->query($queryMap);
$reportes = [];
while ($row = $resultMap->fetch_assoc()) {
    $reportes[] = $row;
}
?>

<!-- Leaflet CSS y JS -->
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<div class="container-fluid mt-4">
    <div class="text-center mb-4">
        <h1><i class="bi bi-shield-lock"></i> Panel de Autoridad</h1>
    </div>

    <!-- Mapa de incidentes -->
    <div class="mb-5">
        <h5>Mapa de incidentes en Barinas</h5>
        <div id="map" style="height: 450px; border: 1px solid #ccc;"></div>
    </div>

<script>
// Definir iconos por tipo de incidente
const iconMap = {
    'Bache': L.icon({ iconUrl: '/VialBarinas/Assets/icons/bache.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Señal': L.icon({ iconUrl: '/VialBarinas/Assets/icons/senal.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Puente': L.icon({ iconUrl: '/VialBarinas/Assets/icons/puente.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Semáforo': L.icon({ iconUrl: '/VialBarinas/Assets/icons/semaforo.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Alcantarilla': L.icon({ iconUrl: '/VialBarinas/Assets/icons/alcantarilla.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Acera': L.icon({ iconUrl: '/VialBarinas/Assets/icons/acera.png', iconSize: [32, 32], iconAnchor: [16, 32] }),
    'Otro':   L.icon({ iconUrl: '/VialBarinas/Assets/icons/otro.png',   iconSize: [32, 32], iconAnchor: [16, 32] }),
};

// Inicializar mapa centrado en Barinas
const map = L.map('map').setView([8.6226, -70.2075], 14);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

// Añadir marcadores
const reportes = <?= json_encode($reportes, JSON_NUMERIC_CHECK) ?>;
reportes.forEach(rep => {
    const icon = iconMap[rep.tipo_incidente] || iconMap['Otro'];
    L.marker([rep.latitud, rep.longitud], { icon })
     .addTo(map)
     .bindPopup(`
        <strong>${rep.titulo}</strong><br>
        ${rep.descripcion}<br>
        <small>${new Date(rep.fecha_reporte).toLocaleDateString()}</small>
     `);
});
</script>

<?php include_once('../../Templates/footer.php'); ?>
