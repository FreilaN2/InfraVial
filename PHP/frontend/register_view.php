<?php
session_start();
include_once('../../Templates/header.php');
?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="max-width: 500px; width: 100%;">
        <h1 class="text-center mb-4">
            <i class="bi bi-person-plus"></i> Registro de Usuario
        </h1>
        <form id="registroForm" action="/VialBarinas/PHP/backend/register_logic.php" method="POST" novalidate>
            <!-- Nombre -->
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
                <small class="text-danger" id="error-nombre"></small>
            </div>

            <!-- Apellido -->
            <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control" required>
                <small class="text-danger" id="error-apellido"></small>
            </div>

            <!-- Cédula -->
            <div class="mb-3">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula" id="cedula" class="form-control" required>
                <small class="text-danger" id="error-cedula"></small>
            </div>

            <!-- Teléfono -->
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" required>
                <small class="text-danger" id="error-telefono"></small>
            </div>

            <!-- Correo -->
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
                <small class="text-danger" id="error-correo"></small>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                <small class="text-danger" id="error-contrasena"></small>
            </div>

            <!-- Confirmar contraseña -->
            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" id="confirmar" class="form-control" required>
                <small class="text-danger" id="error-confirmar"></small>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-check-circle"></i> Registrarse
            </button>
        </form>

        <p class="text-center mt-3">
            ¿Ya tienes cuenta? <a href="login_view.php">Inicia sesión</a>
        </p>
    </div>
</div>

<!-- Scripts JS -->
<script src="/VialBarinas/Public/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/VialBarinas/Public/JS/validar_register.js"></script>

<?php include_once('../../Templates/footer.php'); ?>