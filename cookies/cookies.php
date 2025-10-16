<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contador de Visitas</title>
</head>
<body>
    <?php
    // Nombre de la cookie
    $cookie_name = "contador_visitas";

    // Duración de la cookie: 1 año (en segundos)
    $duracion = 365 * 24 * 60 * 60;

    // Comprobamos si la cookie ya existe
    if (isset($_COOKIE[$cookie_name])) {
        // Incrementamos el contador
        $visitas = $_COOKIE[$cookie_name] + 1;
    } 

    // Actualizamos la cookie con el nuevo valor
    setcookie($cookie_name, $visitas, time() + $duracion);

    // Mostramos el número de visitas
    echo "<h2>Has visitado esta página <strong>$visitas</strong> veces.</h2>";
    ?>
</body>
</html>
