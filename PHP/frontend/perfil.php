<!-- perfil.php -->
<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /VialBarinas/PHP/frontend/login_view.php");
    exit;
}
?>

<?php include_once('../../Templates/header_2.php'); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 p-4">
                <h2 class="text-center mb-4">
                    <i class="bi bi-person-circle"></i> Mi Perfil
                </h2>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Nombre:</strong> <?php echo $_SESSION['nombre']; ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Apellido:</strong> <?php echo $_SESSION['apellido']; ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Cédula:</strong> <?php echo $_SESSION['cedula']; ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Teléfono:</strong> <?php echo $_SESSION['telefono']; ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Correo:</strong> <?php echo $_SESSION['correo']; ?>
                    </li>
                </ul>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-outline-primary">
                        <i class="bi bi-pencil-square"></i> Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('../../Templates/footer.php'); ?>
