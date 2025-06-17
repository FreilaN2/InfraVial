<?php
require_once '../../database.php';

$correo = 'admin@vialbarinas.com';
$check = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
$check->bind_param("s", $correo);
$check->execute();
$check->store_result();

if ($check->num_rows === 0) {
    $nombre = 'Admin';
    $apellido = 'Principal';
    $cedula = '00000000';
    $telefono = '0000000000';
    $contrasena = password_hash('admin123', PASSWORD_DEFAULT);
    $rol = 'superadmin';

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, cedula, telefono, correo, contrasena, rol, creado_en)
                            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssssss", $nombre, $apellido, $cedula, $telefono, $correo, $contrasena, $rol);

    if ($stmt->execute()) {
        echo "Superadmin creado con éxito.";
    } else {
        echo "Error al crear el superadmin: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "El superadmin ya existe.";
}

$check->close();
$conn->close();
