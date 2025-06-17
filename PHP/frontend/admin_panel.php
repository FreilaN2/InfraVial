<!-- admin_panel.php -->
<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'superadmin') {
    header("Location: /VialBarinas/index.php");
    exit;
}
?>

<?php include_once('../../Templates/header_3.php'); ?>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1><i class="bi bi-shield-lock"></i> Panel de Superadmin</h1>
        <p class="lead">Administración de usuarios autoridades</p>
    </div>

    <div class="card shadow-sm p-4 mb-5">
        <h4><i class="bi bi-person-gear"></i> Crear Usuario Autoridad</h4>
        <form action="/VialBarinas/PHP/backend/register_logic_autoridad.php" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="cedula" class="form-control" placeholder="Cédula" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required>
                </div>
                <div class="col-md-6">
                    <input type="email" name="correo" class="form-control" placeholder="Correo" required>
                </div>
                <div class="col-md-6">
                    <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
                </div>
                <input type="hidden" name="rol" value="autoridad">
            </div>
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-person-plus"></i> Registrar Autoridad</button>
            </div>
        </form>
    </div>

    <!-- Aquí podrías agregar una tabla para listar usuarios tipo autoridad con opción de editar/eliminar -->
</div>

<?php include_once('../../Templates/footer.php'); ?>
