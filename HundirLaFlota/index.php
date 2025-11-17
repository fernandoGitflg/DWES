<?php
session_start();
require_once 'funciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tema'])) {
    $temaSeleccionado = $_POST['tema'] === 'oscuro' ? 'oscuro' : 'claro';

    setcookie(
        "tema_usuario",
        $temaSeleccionado,
        [
            "expires" => time() + 60 * 60 * 24 * 30,
            "path" => "/",
            "secure" => true,
            "httponly" => false,
            "samesite" => "Lax"
        ]
    );

    // Recargar la página para aplicar el nuevo tema
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intentosSolicitados = isset($_POST['intentos']) ? max(1, intval($_POST['intentos'])) : 40;
    $_SESSION['intentos'] = $intentosSolicitados;
    $_SESSION['tiradas'] = [];
    $_SESSION['aciertos'] = 0;

    if (isset($_POST['modo']) && $_POST['modo'] === 'fichero') {
        if (isset($_FILES['archivoBarcos']) && $_FILES['archivoBarcos']['error'] === UPLOAD_ERR_OK) {
            $rutaTemporal = $_FILES['archivoBarcos']['tmp_name'];
            $_SESSION['board'] = cargarBarcosDesdeFichero($rutaTemporal);
        } else {
            $_SESSION['board'] = generarBarcosAleatorios();
        }
    } else {
        $_SESSION['board'] = generarBarcosAleatorios();
    }

    header('Location: juego.php');
    exit;
}

// Establecer cookie si no existe
if (!isset($_COOKIE['tema_usuario'])) {
    setcookie(
        "tema_usuario",
        "claro",
        [
            "expires" => time() + 60 * 60 * 24 * 30,
            "path" => "/",
            "secure" => true,
            "httponly" => false,
            "samesite" => "Lax"
        ]
    );
}

$temaVisual = $_COOKIE['tema_usuario'] ?? 'claro';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hundir la flota</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body class="<?= htmlspecialchars($temaVisual) ?>">
    <h1>Hundir la flota</h1>

    <form method="post" enctype="multipart/form-data">
        <label>¿Cuántos intentos quieres? (mínimo 1):</label>
        <input type="number" name="intentos" min="1" value="40"><br><br>

        <label>Modo de generación:</label><br>
        <input type="radio" name="modo" value="aleatorio" checked> Aleatorio<br>
        <input type="radio" name="modo" value="fichero"> Cargar desde fichero<br>
        <input type="file" name="archivoBarcos" accept=".txt"><br><br>

        <button type="submit">Empezar partida</button>
    </form>

    <form method="post">
        <label>Selecciona tema visual:</label>
        <select name="tema">
            <option value="claro" <?= $temaVisual === 'claro' ? 'selected' : '' ?>>Claro</option>
            <option value="oscuro" <?= $temaVisual === 'oscuro' ? 'selected' : '' ?>>Oscuro</option>
        </select>
        <button type="submit">Guardar preferencias</button>
    </form>
</body>
</html>
