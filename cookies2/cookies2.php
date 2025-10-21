<?php
// Verificar si ya existe la cookie
$idiomaSeleccionado = isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : null;

// Si el formulario fue enviado y no hay cookie, guardar el idioma
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idioma'])) {
    $idioma = $_POST['idioma'];
    setcookie('idioma', $idioma, time() + (7 * 24 * 60 * 60)); // 7 días
    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir para evitar reenvío del formulario
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Idioma Preferido</title>
</head>
<body>
    <?php if ($idiomaSeleccionado): ?>
        <?php if ($idiomaSeleccionado === 'Español'): ?>
            <h1>¡Bienvenido!</h1>
            <p>Has seleccionado Español como tu idioma preferido.</p>
        <?php elseif ($idiomaSeleccionado === 'Inglés'): ?>
            <h1>Welcome!</h1>
            <p>You have selected English as your preferred language.</p>
        <?php endif; ?>
    <?php else: ?>
        <h1>Selecciona tu idioma preferido</h1>
        <form method="post" action="">
            <label>
                <input type="radio" name="idioma" value="Español" required>
                Español
            </label><br>
            <label>
                <input type="radio" name="idioma" value="Inglés">
                Inglés
            </label><br><br>
            <button type="submit">Guardar idioma</button>
        </form>
    <?php endif; ?>
</body>
</html>
