<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'autoridad') {
    http_response_code(403);
    exit;
}

require_once '../../database.php';

$result = $conn->query("SELECT COUNT(*) AS total FROM reportes WHERE estado = 'pendiente'");
$data = $result->fetch_assoc();

echo json_encode(['total' => intval($data['total'])]);
