<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'autoridad') {
    http_response_code(403);
    exit;
}

require_once '../../database.php';

// Última ID que ya mostró el frontend (viene por GET)
$ultima_id = isset($_GET['ultima_id']) ? intval($_GET['ultima_id']) : 0;

$sql = "SELECT id FROM reportes WHERE estado = 'pendiente' AND id > ? ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ultima_id);
$stmt->execute();
$stmt->bind_result($nuevo_id);
if ($stmt->fetch()) {
    echo json_encode(['nuevo' => true, 'id' => $nuevo_id]);
} else {
    echo json_encode(['nuevo' => false]);
}
$stmt->close();
