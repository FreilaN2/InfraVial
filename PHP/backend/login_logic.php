<?php
require_once '../../database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    $stmt = $conn->prepare("SELECT id, nombre, apellido, cedula, telefono, correo, contrasena, rol FROM usuarios WHERE correo = ? LIMIT 1");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellido'] = $row['apellido'];
            $_SESSION['cedula'] = $row['cedula'];
            $_SESSION['telefono'] = $row['telefono'];
            $_SESSION['correo'] = $row['correo'];
            $_SESSION['rol'] = $row['rol'];

            // Redirigir según el rol
            switch ($row['rol']) {
                case 'superadmin':
                    header('Location: /VialBarinas/PHP/frontend/admin_panel.php');
                    break;
                case 'autoridad':
                    header('Location: /VialBarinas/PHP/frontend/autoridad_panel.php');
                    break;
                case 'ciudadano':
                default:
                    header('Location: /VialBarinas/PHP/frontend/inicio.php');
                    break;
            }
            exit;
        } else {
            // Contraseña incorrecta
            header('Location: /VialBarinas/PHP/frontend/login_view.php?error=1');
            exit;
        }
    } else {
        // Usuario no encontrado
        header('Location: /VialBarinas/PHP/frontend/login_view.php?error=1');
        exit;
    }
} else {
    // Método no permitido
    header('Location: /VialBarinas/index.php');
    exit;
}
