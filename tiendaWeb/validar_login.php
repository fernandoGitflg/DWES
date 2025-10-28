<?php
session_start();

$email = $_POST['usuario'] ?? '';
$clave = $_POST['contraseña'] ?? '';

if (!$email || !$clave) {
    header("Location: login.php?error=3");
    exit;
}

try {
    $conn = new PDO("mysql:host=localhost;dbname=cadena_restaurantes", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT email, clave FROM restaurantes WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($clave, $usuario['clave'])) {
        $_SESSION['usuario'] = $email;

        if (isset($_POST['remember'])) {
            setcookie('remember_email', $email, [
                'expires' => time() + 604800,
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
        }

        header("Location: categorias.php");
        exit;
    } else {
        header("Location: login.php?error=1");
        exit;
    }
} catch (PDOException $e) {
    header("Location: login.php?error=2");
    exit;
}
