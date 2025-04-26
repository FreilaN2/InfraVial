<!-- register_view.php -->
<?php include_once('../../Templates/header.php'); ?>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="max-width: 500px; width: 100%;">
        <h1 class="text-center mb-4">
            <i class="bi bi-person-plus"></i> Registrarse
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
                <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
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
            <button type="submit" class="btn btn-success w-100">
                <i class="bi bi-person-plus-fill"></i> Registrarme
            </button>
        </form>
        <p class="text-center mt-3">
            ¿Ya tienes cuenta? <a href="/VialBarinas/PHP/frontend/login_view.php">Inicia sesión</a>
        </p>
    </div>
</div>

<?php include_once('../../Templates/footer.php'); ?>
