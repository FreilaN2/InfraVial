<?php
require_once '../../database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    $stmt = $conn->prepare("SELECT id, nombre, apellido, cedula, telefono, correo, contrasena FROM usuarios WHERE correo = ? LIMIT 1");
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

            header('Location: /VialBarinas/PHP/frontend/inicio.php');
            exit;
        }
    }

    header('Location: /VialBarinas/PHP/frontend/login_view.php?error=1');
    exit;
} else {
    header('Location: /VialBarinas/index.php');
    exit;
}
