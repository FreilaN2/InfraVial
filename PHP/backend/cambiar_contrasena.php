<?php
session_start();
require_once '../../database.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: /VialBarinas/PHP/frontend/login_view.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $contrasena_actual = $_POST['contrasena_actual'] ?? '';
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';

    // Verificar campos
    if (empty($contrasena_actual) || empty($nueva_contrasena)) {
        header('Location: /VialBarinas/PHP/frontend/perfil.php?error=campos_vacios');
        exit;
    }

    // Consultar contraseña actual en BD
    $stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($contrasena_hash);
    $stmt->fetch();
    $stmt->close();

    // Validar contraseña actual
    if (!password_verify($contrasena_actual, $contrasena_hash)) {
        header('Location: /VialBarinas/PHP/frontend/perfil.php?error=incorrecta');
        exit;
    }

    // Actualizar nueva contraseña
    $nueva_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
    $stmt->bind_param("si", $nueva_hash, $usuario_id);

    if ($stmt->execute()) {
        header('Location: /VialBarinas/PHP/frontend/perfil.php?exito=contrasena');
    } else {
        header('Location: /VialBarinas/PHP/frontend/perfil.php?error=bd');
    }

    $stmt->close();
    $conn->close();
} else {
    header('Location: /VialBarinas/index.php');
    exit;
}
