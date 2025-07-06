<?php
session_start();
require_once '../../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $tipo_incidente = $_POST['tipo_incidente'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $fecha_reporte = date('Y-m-d H:i:s');
    $estado = 'Pendiente';

    if (!isset($_SESSION['usuario_id'])) {
        die('Error: sesión no iniciada correctamente.');
    }

    $usuario_id = $_SESSION['usuario_id'];

    // Validar campos obligatorios
    if (empty($titulo) || empty($descripcion) || empty($tipo_incidente) || empty($latitud) || empty($longitud)) {
        die('Todos los campos son obligatorios.');
    }

    // Manejo de archivo de imagen
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $fotoNombre = basename($_FILES['foto']['name']);
        $fotoExt = strtolower(pathinfo($fotoNombre, PATHINFO_EXTENSION));
        $fotoDestino = '../../Public/Uploads/' . uniqid('foto_', true) . '.' . $fotoExt;

        $extPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fotoExt, $extPermitidas)) {
            die('Formato de imagen no permitido.');
        }

        if (!move_uploaded_file($fotoTmp, $fotoDestino)) {
            die('Error al subir la imagen.');
        }
    } else {
        die('Debe subir una imagen del incidente.');
    }

    // Guardar en la base de datos
    $sql = "INSERT INTO reportes (titulo, descripcion, tipo_incidente, latitud, longitud, estado, fecha_reporte, imagen, usuario_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssi', $titulo, $descripcion, $tipo_incidente, $latitud, $longitud, $estado, $fecha_reporte, $fotoDestino, $usuario_id);

    if ($stmt->execute()) {
echo "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
            body {
                font-family: Arial, sans-serif;
            }
        </style>
</head>
<body>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Reporte enviado!',
            text: 'Gracias por tu colaboración.',
            timer: 3000,
            showConfirmButton: false,
            timerProgressBar: true
        });

        setTimeout(() => {
            window.location.href = '/VialBarinas/PHP/frontend/inicio.php';
        }, 3000);
    </script>
</body>
</html>
";
exit;

    } else {
        echo 'Error al guardar el reporte: ' . $stmt->error;
    }
} else {
    header('Location: /VialBarinas/PHP/frontend/inicio.php');
    exit();
}
?>
