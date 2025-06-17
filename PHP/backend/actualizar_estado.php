<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'autoridad') {
    header('Location: /VialBarinas/login.php');
    exit();
}

require_once '../../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reporte_id = $_POST['reporte_id'] ?? null;
    $accion = $_POST['accion'] ?? null;
    $prioridad = $_POST['prioridad'] ?? null;

    if (!$reporte_id || !$accion || !$prioridad) {
        die('Datos incompletos.');
    }

    $estado = '';
    $estatus = 'activo';

    switch ($accion) {
        case 'aprobar':
            $estado = 'aprobado';
            break;
        case 'rechazar':
            $estado = 'rechazado';
            break;
        case 'resolver':
            // Solo cambia estatus a resuelto, estado ya debe ser aprobado
            $stmtCheck = $conn->prepare("SELECT estado FROM reportes WHERE id = ?");
            $stmtCheck->bind_param("i", $reporte_id);
            $stmtCheck->execute();
            $stmtCheck->bind_result($estadoActual);
            $stmtCheck->fetch();
            $stmtCheck->close();

            if ($estadoActual !== 'aprobado') {
                die('Solo se pueden marcar como resueltos los reportes aprobados.');
            }

            $stmt = $conn->prepare("UPDATE reportes SET estatus = 'resuelto', prioridad = ? WHERE id = ?");
            $stmt->bind_param("si", $prioridad, $reporte_id);

            if ($stmt->execute()) {
                header('Location: /VialBarinas/PHP/frontend/autoridad_gestionar.php');
                exit();
            } else {
                echo "Error al actualizar el estatus: " . $stmt->error;
            }
            exit();

        default:
            die('Acción no válida.');
    }

    $stmt = $conn->prepare("UPDATE reportes SET estado = ?, estatus = ?, prioridad = ? WHERE id = ?");
    $stmt->bind_param("sssi", $estado, $estatus, $prioridad, $reporte_id);

    if ($stmt->execute()) {
        header('Location: /VialBarinas/PHP/frontend/autoridad_gestionar.php');
        exit();
    } else {
        echo "Error al actualizar el reporte: " . $stmt->error;
    }
} else {
    header('Location: /VialBarinas/index.php');
    exit();
}
?>
