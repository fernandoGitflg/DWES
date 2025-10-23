<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Eliminar la sesión del servidor
session_destroy();

// Redirigir al login
header("Location: login.php");
exit;
?>
