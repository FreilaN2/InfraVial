<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de SuperAdmin - Vial Barinas</title>

    <!-- Bootstrap CSS local -->
    <link href="/VialBarinas/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons local -->
    <link href="/VialBarinas/Public/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- Tu CSS personalizado -->
    <link href="/VialBarinas/Public/CSS/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Navbar con opciones para usuario autenticado -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a  href="/VialBarinas/PHP/frontend/inicio.php">
            <img src="/VialBarinas/Assets/img/SIMPLE.svg" alt="InfraVial" style="width: 170px; height: 40px; vertical-align: middle;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/admin_panel.php">
                        <i class="bi bi-house"></i> Inicio
                    </a>
                </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/lista_usuarios.php">
                        <i class="bi bi-list-ul"></i> Usuarios Registrados
                    </a>
                </li>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/perfil_admin.php">
                        <i class="bi bi-person"></i> Perfil
                    </a>
                </li>
                <li class="nav-item">
                    <a id="logoutLink" class="nav-link" href="/VialBarinas/PHP/backend/logout.php">
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
