<?php
session_start();

$_SESSION = [];
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sesión cerrada</title>
</head>
<body>
    <p>La sesión se cerró correctamente, hasta la próxima</p>
    <a href="login.php">Ir a la página de login</a>
</body>
</html>
