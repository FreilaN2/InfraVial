<!-- register_view.php -->
<?php
session_start();
include_once('../../Templates/header.php');
?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="max-width: 500px; width: 100%;">
        <h1 class="text-center mb-4">
            <i class="bi bi-person-plus"></i> Registro de Usuario
        </h1>
        <form action="/VialBarinas/PHP/backend/register_logic.php" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                <input type="text" name="cedula" class="form-control" placeholder="Cédula" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
            </div>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'superadmin'): ?>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol del Usuario</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="ciudadano" selected>Ciudadano</option>
                        <option value="autoridad">Autoridad</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-check-circle"></i> Registrarse
            </button>
        </form>
        <p class="text-center mt-3">
            ¿Ya tienes una cuenta? <a href="/VialBarinas/PHP/frontend/login_view.php">Inicia sesión</a>
        </p>
    </div>
</div>

<?php include_once('../../Templates/footer.php'); ?>
