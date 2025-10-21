<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>

    <h2>Registrate</h2>
    <form method="post" action="">
        <label for="nombre_usuario">Usuario:</label>
        <input type="text" name="nombre_usuario" required><br><br>

        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required><br><br>

        <button type="submit">Registrarse</button>
        <div><a href="login.php">Atrás</a></div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_usuario'], $_POST['contraseña'])) {
        $nombre_usuario = $_POST['nombre_usuario'];
        $contraseña_segura = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "login_app";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO usuarios (nombre_usuario, contraseña) VALUES (:nombre_usuario, :clave)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario);
            $stmt->bindParam(':clave', $contraseña_segura);
            $stmt->execute();

            // Redirigir al login
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>

</html>
