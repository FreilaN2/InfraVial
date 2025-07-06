<?php
require_once __DIR__ . '/../database.php'; // ajusta ruta si es necesario

$queryPendientes = "SELECT COUNT(*) as total FROM reportes WHERE estado = 'pendiente'";
$resultPendientes = $conn->query($queryPendientes);
$pendientes = $resultPendientes->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Autoridad - Vial Barinas</title>

    <!-- Bootstrap CSS local -->
    <link href="/VialBarinas/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons local -->
    <link href="/VialBarinas/Public/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- Tu CSS personalizado -->
    <link href="/VialBarinas/Public/CSS/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Navbar para autoridad -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a  href="/VialBarinas/PHP/frontend/autoridad_panel.php">
            <img src="/VialBarinas/Assets/img/SIMPLE.svg" alt="InfraVial" style="width: 170px; height: 40px; vertical-align: middle;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/autoridad_panel.php">
                        <i class="bi bi-house"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/autoridad_gestionar.php">
                        <i class="bi bi-wrench-adjustable"></i> Reportes Pendientes 
                        <span id="badge-pendientes" class="badge bg-danger"><?php echo $pendientes; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/autoridad_reportes_aprobados.php">
                        <i class="bi bi-check-circle"></i> Reportes Aprobados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/autoridad_reportes_rechazados.php">
                        <i class="bi bi-x-circle"></i> Reportes Rechazados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/perfil_autoridad.php">
                        <i class="bi bi-person"></i> Perfil
                    </a>
                </li>
                <li class="nav-item">
                    <a id="logoutLink" class="nav-link" href="#">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.getElementById('logoutLink').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Cerrar sesión',
            text: "¿Estás seguro de querer salir?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/VialBarinas/PHP/backend/logout.php';
            }
        });
    });
</script>

<audio id="alerta-audio" src="/VialBarinas/Assets/alerta.mp3" preload="auto"></audio>

<script>
let ultimaID = localStorage.getItem('ultimaID') ? parseInt(localStorage.getItem('ultimaID')) : 17;

// Permitir sonido luego de interacción
document.addEventListener('click', () => {
    const audio = document.getElementById('alerta-audio');
    if (audio) {
        audio.play().then(() => {
            audio.pause();
            audio.currentTime = 0;
        }).catch(() => {});
    }
}, { once: true });

// Verificar si hay un nuevo reporte
function verificarNuevosReportes() {
    fetch(`/VialBarinas/PHP/backend/verificar_nuevos_reportes.php?ultima_id=${ultimaID}`)
        .then(res => res.json())
        .then(data => {
            if (data.nuevo && data.id > ultimaID) {
                ultimaID = data.id;
                localStorage.setItem('ultimaID', ultimaID);

                // Mostrar alerta visual (toast)
                const toast = document.createElement('div');
                toast.className = 'toast align-items-center text-bg-danger border-0 show position-fixed bottom-0 end-0 m-4';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            📢 ¡Nuevo reporte pendiente recibido!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>`;
                document.body.appendChild(toast);

                // Reproducir sonido
                const audio = document.getElementById('alerta-audio');
                audio.play().catch(() => console.warn('Autoplay bloqueado'));
            }

            // Actualizar el contador visual
            actualizarContador();
        }).catch(err => console.error("Error al verificar reportes:", err));
}

// Actualizar el número de reportes pendientes (badge)
function actualizarContador() {
    fetch(`/VialBarinas/PHP/backend/contador_pendientes.php`)
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('badge-pendientes');
            if (badge) {
                badge.textContent = data.total;
            }
        }).catch(err => console.error("Error al actualizar contador:", err));
}

// Llamadas periódicas
actualizarContador();
setInterval(verificarNuevosReportes, 10000); // cada 10 segundos
</script>

<main class="container mt-4">
