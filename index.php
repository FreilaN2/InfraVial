<?php include_once('./Templates/header.php'); ?>

<div class="container mt-5">
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <img src="/VialBarinas/assets/img/REPORTAR.webp" class="img-fluid rounded shadow img-resize" alt="Reporta daños">
            <h5 class="mt-2">Reporta Daños</h5>
        </div>
        <div class="col-md-4">
            <img src="/VialBarinas/assets/img/DIA.webp" class="img-fluid rounded shadow img-resize" alt="Mantente informado">
            <h5 class="mt-2">Mantente Informado</h5>
        </div>
        <div class="col-md-4">
            <img src="/VialBarinas/assets/img/VIAL.webp" class="img-fluid rounded shadow img-resize" alt="Mantenimiento vial">
            <h5 class="mt-2">Apoya el Mantenimiento</h5>
        </div>
    </div>

    <div class="row justify-content-center text-center">
        <div class="col-md-10">
            <h1 class="display-5 mb-3"><i class="bi bi-geo-alt-fill"></i> ¿Qué es InfraVial?</h1>
            <p class="lead">
                Es una plataforma ciudadana para reportar fallas en la infraestructura vial del estado Barinas.
                Tu reporte, junto con una foto y ubicación, ayuda a las autoridades a priorizar reparaciones.
            </p>
            <p class="mt-2">
                Juntos mejoramos la seguridad y movilidad para todos.
            </p>
            <a href="/VialBarinas/PHP/frontend/login_view.php" class="btn btn-primary mt-3">
                <i class="bi bi-person-circle"></i> Iniciar sesión
            </a>
        </div>
    </div>
</div>

<?php include_once('./Templates/footer.php'); ?>
