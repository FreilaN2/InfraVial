<?php
require_once '../../database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $cedula = trim($_POST['cedula']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    // Determinar el rol
    $rol = 'ciudadano';
    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'superadmin' && isset($_POST['rol'])) {
        $rol = $_POST['rol'];
    }

    if (empty($nombre) || empty($apellido) || empty($cedula) || empty($telefono) || empty($correo) || empty($contrasena)) {
        die('Por favor complete todos los campos');
    }

    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? OR cedula = ? LIMIT 1");
    $stmt->bind_param("ss", $correo, $cedula);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        die('El correo o cédula ya están registrados.');
    }
    $stmt->close();

    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, cedula, telefono, correo, contrasena, rol, creado_en) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", $nombre, $apellido, $cedula, $telefono, $correo, $hashed_password, $rol);

    if ($stmt->execute()) {
        header("Location: /VialBarinas/PHP/frontend/login_view.php?registro=exitoso");
        exit;
    } else {
        die("Error al registrar: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: /VialBarinas/index.php");
    exit;
}
