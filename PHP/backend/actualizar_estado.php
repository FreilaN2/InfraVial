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

    if (!$reporte_id || !$accion) {
        die('Datos incompletos.');
    }

    if ($accion === 'aprobar' && empty($prioridad)) {
        header('Location: /VialBarinas/PHP/frontend/autoridad_gestionar.php?error=sin_prioridad');
        exit;
    }

    $estado = '';
    $estatus = 'activo';

    switch ($accion) {
        case 'aprobar':
            $estado = 'aprobado';

            $stmt = $conn->prepare("UPDATE reportes SET estado = ?, estatus = ?, prioridad = ? WHERE id = ?");
            $stmt->bind_param("sssi", $estado, $estatus, $prioridad, $reporte_id);

            if ($stmt->execute()) {
                header('Location: /VialBarinas/PHP/frontend/autoridad_gestionar.php?exito=aprobado');
                exit();
            } else {
                echo "Error al aprobar el reporte: " . $stmt->error;
            }
            exit();

        case 'rechazar':
            $estado = 'rechazado';

            $stmt = $conn->prepare("UPDATE reportes SET estado = ?, estatus = ?, prioridad = NULL WHERE id = ?");
            $stmt->bind_param("ssi", $estado, $estatus, $reporte_id);

            if ($stmt->execute()) {
                header('Location: /VialBarinas/PHP/frontend/autoridad_gestionar.php?exito=rechazado');
                exit();
            } else {
                echo "Error al rechazar el reporte: " . $stmt->error;
            }
            exit();

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
                header('Location: /VialBarinas/PHP/frontend/autoridad_reportes_aprobados.php?exito=resuelto');
                exit();
            } else {
                echo "Error al actualizar el estatus: " . $stmt->error;
            }
            exit();

        default:
            die('Acción no válida.');
    }
} else {
    header('Location: /VialBarinas/index.php');
    exit();
}
?>
