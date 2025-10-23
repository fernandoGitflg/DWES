<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "cadena_restaurantes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = $_POST['usuario'] ?? '';
        $contraseña = $_POST['contraseña'] ?? '';

        if (empty($usuario) || empty($contraseña)) {
            header("Location: login.php?error=3");
            exit;
        }

        $sql = "SELECT clave FROM Restaurantes WHERE email = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datos && password_verify($contraseña, $datos['clave'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: categorias.php");
            exit;
        } else {
            header("Location: login.php?error=1");
            exit;
        }
    }
} catch (PDOException $e) {
    header("Location: login.php?error=2");
    exit;
}
?>
