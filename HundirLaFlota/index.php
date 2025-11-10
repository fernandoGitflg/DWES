<?php
session_start();
require_once 'funciones.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $intentos = isset($_POST['intentos']) ? max(1, intval($_POST['intentos'])) : 40;
    $_SESSION['intentos'] = $intentos;
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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hundir la flota</title>
</head>
<body>
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
</body>
</html>
