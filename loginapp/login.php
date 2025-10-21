<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <?php
    session_start(); // Iniciar la sesión

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "login_app";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Si ya está logueado, mostrar mensaje
        if (isset($_SESSION['usuario'])) {
            echo "<h2>Bienvenido, <strong>{$_SESSION['usuario']}</strong>. Ya estás logueado.</h2>";
            echo '<form method="post"><button type="submit" name="logout">Cerrar sesión</button></form>';
        } else {
            // Si se envió el formulario
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_usuario'], $_POST['contraseña'])) {
                $nombre_usuario = $_POST['nombre_usuario'];
                $contraseña = $_POST['contraseña'];

                $sql = "SELECT contraseña FROM usuarios WHERE nombre_usuario = :nombre_usuario";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nombre_usuario', $nombre_usuario);
                $stmt->execute();

                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && $contraseña === $usuario['contraseña']) {
                    $_SESSION['usuario'] = $nombre_usuario;
                    echo "<h2>Bienvenido, <strong>$nombre_usuario</strong>.</h2>";
                    echo '<form method="post"><button type="submit" name="logout">Cerrar sesión</button></form>';
                } else {
                    echo "<p>Usuario o contraseña incorrectos.</p>";
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
            </form>';
            }
        }

        // Cerrar sesión
        if (isset($_POST['logout'])) {
            session_destroy();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
    ?>
</body>

</html>