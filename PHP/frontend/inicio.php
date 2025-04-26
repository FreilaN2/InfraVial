<?php include_once('../../Templates/header_2.php'); ?>

<div class="container-fluid mt-4">
    <h2 class="text-center mb-4">Reportes Recientes</h2>

    <div class="d-flex flex-wrap gap-3 justify-content-start px-3">
        <!-- Reporte ejemplo -->
        <a href="/VialBarinas/PHP/frontend/detalle_reporte.php?id=1" class="text-decoration-none text-dark">
            <div class="card shadow-sm" style="width: 18rem;">
                <img src="/VialBarinas/Assets/img/BACHE.webp" class="card-img-top" alt="Reporte">
                <div class="card-body">
                    <h5 class="card-title">Bache en Av. Libertador</h5>
                    <p class="card-text">Un gran bache que dificulta el tránsito. Zona escolar cercana.</p>
                    <p class="card-text small text-muted">Reportado el: 20/04/2025</p>
                    <span class="badge bg-warning text-dark">En proceso</span>
                </div>
            </div>
        </a>
        <!-- Puedes duplicar este bloque <a> para más reportes -->
    </div>
</div>

<script>
// Scroll infinito
window.addEventListener("scroll", () => {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200) {
        cargarReportes();
    }
});
</script>

<?php include_once('../../Templates/footer.php'); ?>