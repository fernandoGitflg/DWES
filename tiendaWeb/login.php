<?php
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case '1':
            echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
            break;
        case '2':
            echo "<p style='color:red;'>Error interno de conexión. Intenta más tarde.</p>";
            break;
        case '3':
            echo "<p style='color:red;'>Por favor, completa todos los campos.</p>";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicia Sesión</title>
</head>
<body>
    <h2>Acceso al sistema</h2>
    <form method="post" action="validar_login.php">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" required>
        <label for="contraseña">Clave</label>
        <input type="password" name="contraseña" required>
        <label>
            <input type="checkbox" name="remember"> Recordarme
        </label>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
