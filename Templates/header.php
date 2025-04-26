<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infraestructura Vial - Barinas</title>

    <!-- Bootstrap CSS local -->
    <link href="/VialBarinas/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons local -->
    <link href="/VialBarinas/Public/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- Tu CSS personalizado -->
    <link href="/VialBarinas/Public/CSS/styles.css" rel="stylesheet">
</head>
<body>

<!-- Navbar principal -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/VialBarinas/index.php">
            <i class="bi bi-geo-alt-fill"></i> Vial Barinas
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/VialBarinas/frontend/dashboard.php">
                            <i class="bi bi-speedometer2"></i> Panel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/VialBarinas/backend/logout.php">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/login_view.php">
                        <i class="bi bi-person-circle"></i> Iniciar sesión
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="/VialBarinas/PHP/frontend/register_view.php">
                        <i class="bi bi-person-plus"></i> Registrarse
                    </a>
                </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">