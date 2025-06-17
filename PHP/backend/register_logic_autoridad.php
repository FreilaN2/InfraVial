<?php
require_once '../../database.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'superadmin') {
    header("Location: /VialBarinas/index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre     = trim($_POST['nombre']);
    $apellido   = trim($_POST['apellido']);
    $cedula     = trim($_POST['cedula']);
    $telefono   = trim($_POST['telefono']);
    $correo     = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    if (empty($nombre) || empty($apellido) || empty($cedula) || empty($telefono) || empty($correo) || empty($contrasena)) {
        die('Por favor complete todos los campos');
    }

    $check = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? OR cedula = ? LIMIT 1");
    $check->bind_param("ss", $correo, $cedula);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die('El correo o la cédula ya están registrados.');
    }
    $check->close();

    $hashed = password_hash($contrasena, PASSWORD_DEFAULT);
    $rol = 'autoridad';

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, cedula, telefono, correo, contrasena, rol, creado_en) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", $nombre, $apellido, $cedula, $telefono, $correo, $hashed, $rol);

    if ($stmt->execute()) {
        header("Location: /VialBarinas/PHP/frontend/admin_panel.php?registro=exito");
        exit;
    } else {
        die("Error al registrar autoridad: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: /VialBarinas/index.php");
    exit;
}
