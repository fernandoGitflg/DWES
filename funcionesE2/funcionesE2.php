<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificador de Anagramas</title>
</head>
<body>
    <?php
function sonAnagramas($texto1, $texto2) {
    // Eliminar espacios y pasar a minúsculas
    $t1 = strtolower(str_replace(' ', '', $texto1));
    $t2 = strtolower(str_replace(' ', '', $texto2));

    // Convertir a array de caracteres y ordenar
    $array1 = str_split($t1);
    $array2 = str_split($t2);
    sort($array1);
    sort($array2);

    // Comparar arrays
    return $array1 === $array2;
}

// Recoger datos del formulario
$texto1 = $_POST['texto1'] ?? '';
$texto2 = $_POST['texto2'] ?? '';

echo "<h2>Resultado:</h2>";
if (sonAnagramas($texto1, $texto2)) {
    echo "<p><strong>'$texto1' y '$texto2' son anagramas.</strong></p>";
} else {
    echo "<p><strong>'$texto1' y '$texto2' NO son anagramas.</strong></p>";
}
?>

</body>
</html>