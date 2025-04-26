<?php
session_start(); // Asegura que la sesión esté activa

// Elimina todas las variables de sesión
$_SESSION = array();

// Destruye la sesión
session_destroy();

// Redirige al usuario al login
header('Location: /VialBarinas/index.php');
exit;
?>
