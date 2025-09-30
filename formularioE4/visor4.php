<?php
// Recoger datos
$dividendo = $_POST['dividendo'] ?? null;
$divisor = $_POST['divisor'] ?? null;
$errores = [];

// Validaciones
if (!is_numeric($dividendo) || $dividendo < 0 || $dividendo >= 1000) {
    $errores[] = "El dividendo debe ser un número positivo menor que 1000.";
}

if (!is_numeric($divisor) || $divisor <= 0 || $divisor >= 1000) {
    $errores[] = "El divisor debe ser mayor que 0 y menor que 1000.";
}

if (empty($errores)) {
    $cociente = $dividendo / $divisor;
    $resto = fmod($dividendo, $divisor);
    $esExacta = ($resto == 0);

    echo "<h1>Resultado de la división</h1>";
    echo "Dividendo: $dividendo<br>";
    echo "Divisor: $divisor<br>";
    echo "Cociente: $cociente<br>";
    echo "Resto: $resto<br>";
    echo $esExacta ? "<strong>La división es exacta.</strong>" : "<strong>La división no es exacta.</strong>";
} else {
    echo "<h2>Errores:</h2><ul>";
    foreach ($errores as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul><a href='formulario4.html'>Volver al formulario</a>";
}
?>
