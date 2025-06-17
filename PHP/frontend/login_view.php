<!-- login_view.php -->
<?php include_once('../../Templates/header.php'); ?>

<!-- SweetAlert2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="max-width: 400px; width: 100%;">
        <h1 class="text-center mb-4">
            <i class="bi bi-person-circle"></i> Iniciar Sesión
        </h1>
        <form action="/VialBarinas/PHP/backend/login_logic.php" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Entrar
            </button>
        </form>
        <p class="text-center mt-3">
            ¿No tienes cuenta? <a href="/VialBarinas/PHP/frontend/register_view.php">Regístrate</a>
        </p>
    </div>
</div>

<?php if (isset($_GET['error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error de inicio de sesión',
            text: 'Correo o contraseña incorrectos',
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true,
            didClose: () => {
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('error');
                    window.history.replaceState({}, document.title, url.pathname);
                }
            }
        });
    });
</script>
<?php endif; ?>

<?php include_once('../../Templates/footer.php'); ?>

<!-- login_view.php -->
<?php include_once('../../Templates/header.php'); ?>

<!-- SweetAlert2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-4 p-4" style="max-width: 400px; width: 100%;">
        <h1 class="text-center mb-4">
            <i class="bi bi-person-circle"></i> Iniciar Sesión
        </h1>
        <form action="/VialBarinas/PHP/backend/login_logic.php" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Entrar
            </button>
        </form>
        <p class="text-center mt-3">
            ¿No tienes cuenta? <a href="/VialBarinas/PHP/frontend/register_view.php">Regístrate</a>
        </p>
    </div>
</div>

<?php if (isset($_GET['error'])): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error de inicio de sesión',
            text: 'Correo o contraseña incorrectos',
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true,
            didClose: () => {
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.delete('error');
                    window.history.replaceState({}, document.title, url.pathname);
                }
            }
        });
    });
</script>
<?php endif; ?>

<?php include_once('../../Templates/footer.php'); ?>
