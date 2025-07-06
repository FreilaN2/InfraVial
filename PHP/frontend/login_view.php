<!-- login_view.php -->
<?php include_once('../../Templates/header.php'); ?>

<!-- SweetAlert2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row min-vh-100">
    <!-- Columna izquierda con imagen o mensaje -->
    <div class="col-md-6 d-none d-md-block p-0">
        <div class="h-100 w-100 login-left-bg">
        </div>
    </div>

    <!-- Columna derecha con el formulario -->
    <div class="col-md-6 d-flex align-items-center justify-content-center bg-light" style="border-top-right-radius: 1rem; border-bottom-right-radius: 1rem;">
        <div class="card shadow-lg rounded-4 p-4" style="max-width: 420px; width: 100%;">
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
                    <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Contraseña" required>
                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggle-icon"></i>
                    </span>
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
</div>

<?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: 'Ya puedes iniciar sesión.',
            timer: 3000,
            showConfirmButton: false,
            timerProgressBar: true
        });

        const url = new URL(window.location);
        url.searchParams.delete('registro');
        window.history.replaceState({}, document.title, url.toString());
    });
</script>
<?php endif; ?>


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

<!-- Script para mostrar/ocultar la contraseña -->
<script>
function togglePassword() {
    const input = document.getElementById("contrasena");
    const icon = document.getElementById("toggle-icon");
    const isHidden = input.type === "password";
    input.type = isHidden ? "text" : "password";
    icon.className = isHidden ? "bi bi-eye-slash" : "bi bi-eye";
}
</script>

<?php include_once('../../Templates/footer.php'); ?>
