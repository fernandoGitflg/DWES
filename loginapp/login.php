<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "login_app";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cerrar sesión
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Si ya está logueado
    if (isset($_SESSION['usuario'])) {
        echo "<h2>Bienvenido, <strong>{$_SESSION['usuario']}</strong>. Ya estás logueado.</h2>";
        echo '<form method="post"><button type="submit" name="logout">Cerrar sesión</button></form>';
    } else {
        // Procesar login
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_usuario'], $_POST['contraseña'])) {
            $nombre_usuario = $_POST['nombre_usuario'];
            $contraseña = $_POST['contraseña'];

            $sql = "SELECT contraseña FROM usuarios WHERE nombre_usuario = :nombre_usuario";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
                $_SESSION['usuario'] = $nombre_usuario;
                echo "<h2>Bienvenido, <strong>$nombre_usuario</strong>.</h2>";
                echo '<form method="post"><button type="submit" name="logout">Cerrar sesión</button></form>';
            } else {
                echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
            }
        }

        // Mostrar formulario si no está logueado
        if (!isset($_SESSION['usuario'])) {
            echo '
            <h2>Iniciar sesión</h2>
            <form method="post" action="">
                <label for="nombre_usuario">Usuario:</label>
                <input type="text" name="nombre_usuario" required><br><br>

                <label for="contraseña">Contraseña:</label>
                <input type="password" name="contraseña" required><br><br>

                <button type="submit">Entrar</button>
                <div><p>¿No tienes cuenta?</p><a href="singin.php">Regístrate</a></div>
            </form>';
        }
    }
} catch (PDOException $e) {
    echo "<p>Error de conexión: " . $e->getMessage() . "</p>";
}
?>
</body>
</html>
