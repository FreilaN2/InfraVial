<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /VialBarinas/PHP/frontend/login_view.php");
    exit;
}
?>

<?php include_once('../../Templates/header_4.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 p-4">
                <h2 class="text-center mb-4">
                    <i class="bi bi-person-circle"></i> Mi Perfil
                </h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nombre:</strong> <?= $_SESSION['nombre']; ?></li>
                    <li class="list-group-item"><strong>Apellido:</strong> <?= $_SESSION['apellido']; ?></li>
                    <li class="list-group-item"><strong>Cédula:</strong> <?= $_SESSION['cedula']; ?></li>
                    <li class="list-group-item"><strong>Teléfono:</strong> <?= $_SESSION['telefono']; ?></li>
                    <li class="list-group-item"><strong>Correo:</strong> <?= $_SESSION['correo']; ?></li>
                </ul>
                <div class="text-center mt-4">
                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalContrasena">
                        <i class="bi bi-key"></i> Cambiar Contraseña
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Contraseña -->
<div class="modal fade" id="modalContrasena" tabindex="-1" aria-labelledby="modalContrasenaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/VialBarinas/PHP/backend/cambiar_contrasena.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalContrasenaLabel"><i class="bi bi-key"></i> Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="actual" class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="actual" name="contrasena_actual" required>
                </div>
                <div class="mb-3">
                    <label for="nueva" class="form-label">Nueva contraseña</label>
                    <input type="password" class="form-control" id="nueva" name="nueva_contrasena" required>
                    <small id="error-contrasena" class="text-danger ms-1"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Confirmar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 -->
<?php if (isset($_GET['exito']) && $_GET['exito'] === 'contrasena'): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Contraseña actualizada correctamente',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    const url = new URL(window.location);
    url.searchParams.delete('exito');
    window.history.replaceState({}, document.title, url);
});
</script>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nuevaInput = document.getElementById("nueva");
    const errorSpan = document.getElementById("error-contrasena");

    const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    nuevaInput.addEventListener("input", function () {
        const valor = nuevaInput.value;
        if (!regex.test(valor)) {
            errorSpan.textContent = "Debe tener al menos 8 caracteres, una mayúscula, un número y un símbolo.";
            nuevaInput.classList.add("is-invalid");
        } else {
            errorSpan.textContent = "";
            nuevaInput.classList.remove("is-invalid");
        }
    });
});
</script>

<?php if (isset($_GET['error'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let mensaje = '';
    switch ('<?= $_GET['error'] ?>') {
        case 'incorrecta':
            mensaje = 'La contraseña actual es incorrecta';
            break;
        case 'campos_vacios':
            mensaje = 'Debe completar ambos campos';
            break;
        case 'bd':
            mensaje = 'Error al actualizar la contraseña';
            break;
    }

    if (mensaje) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: mensaje,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        const url = new URL(window.location);
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url);
    }
});
</script>
<?php endif; ?>

<?php include_once('../../Templates/footer.php'); ?>
