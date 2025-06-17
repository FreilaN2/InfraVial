<?php include_once('../../Templates/header_2.php'); ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Nuevo Reporte Ciudadano</h2>

    <form action="/VialBarinas/PHP/backend/guardar_reporte.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título del Reporte</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción del incidente</label>
            <textarea name="descripcion" id="descripcion" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="tipo_incidente" class="form-label">Tipo de Incidente</label>
            <select name="tipo_incidente" id="tipo_incidente" class="form-select" required>
                <option value="Bache">Bache</option>
                <option value="Señal">Señal</option>
                <option value="Semáforo">Semáforo</option>
                <option value="Otro">Otro</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ubicación en el mapa</label>
            <div id="map" style="height: 400px;"></div>
            <input type="hidden" name="latitud" id="latitud" required>
            <input type="hidden" name="longitud" id="longitud" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Fotografía del incidente</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-send"></i> Enviar Reporte
            </button>
        </div>
    </form>
</div>

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    const iconMap = {
        'Bache': L.icon({
            iconUrl: '/VialBarinas/Assets/icons/bache.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        }),
        'Señal': L.icon({
            iconUrl: '/VialBarinas/Assets/icons/senal.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        }),
        'Semáforo': L.icon({
            iconUrl: '/VialBarinas/Assets/icons/semaforo.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        }),
        'Otro': L.icon({
            iconUrl: '/VialBarinas/Assets/icons/otro.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        })
    };

    const defaultCoords = [8.6226, -70.2075];
    const map = L.map('map').setView(defaultCoords, 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    let marker;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLatLng = [position.coords.latitude, position.coords.longitude];
                map.setView(userLatLng, 15);

                const tipo = document.getElementById('tipo_incidente').value;
                marker = L.marker(userLatLng, { icon: iconMap[tipo] }).addTo(map);

                document.getElementById('latitud').value = userLatLng[0];
                document.getElementById('longitud').value = userLatLng[1];
            },
            () => {
                console.warn('No se pudo obtener la ubicación, se usará Barinas por defecto.');
            }
        );
    }

    map.on('click', function (e) {
        const tipo = document.getElementById('tipo_incidente').value;
        if (marker) map.removeLayer(marker);

        marker = L.marker(e.latlng, { icon: iconMap[tipo] }).addTo(map);
        document.getElementById('latitud').value = e.latlng.lat;
        document.getElementById('longitud').value = e.latlng.lng;
    });

    document.getElementById('tipo_incidente').addEventListener('change', function () {
        if (marker) {
            const tipo = this.value;
            const lat = marker.getLatLng().lat;
            const lng = marker.getLatLng().lng;

            map.removeLayer(marker);
            marker = L.marker([lat, lng], { icon: iconMap[tipo] }).addTo(map);
        }
    });
</script>

<?php include_once('../../Templates/footer.php'); ?>
