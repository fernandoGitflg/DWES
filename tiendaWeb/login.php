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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicia Sesion</title>
</head>

<body>
    <form method="post" action="validar_login.php">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" required>
        <label for="contraseña">Clave</label>
        <input type="password" name="contraseña" required>
        <button type="submit">Enviar consulta</button>
    </form>
</body>

</html>