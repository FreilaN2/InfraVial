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
        <a class="navbar-brand" href="/VialBarinas/PHP/frontend/autoridad_panel.php">
            <i class="bi bi-geo-alt-fill"></i> InfraVial
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
                        <span class="badge bg-danger"><?php echo $pendientes; ?></span>
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

<main class="container mt-4">
