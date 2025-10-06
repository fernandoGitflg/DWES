<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicios PHP</title>
</head>
<body>
    <?php
    // Procedimiento
    function tablaMultiplicar($numero) {
        echo "<h2>Tabla de multiplicar del $numero</h2>";
        echo "<ul>";
        for ($i = 1; $i <= 10; $i++) {
            $resultado = $numero * $i;
            echo "<li>$numero x $i = $resultado</li>";
        }
        echo "</ul>";
    }
    tablaMultiplicar(7);

    // Función
    function sumarCincoNumeros($a, $b, $c, $d, $e) {
        $suma = $a + $b + $c + $d + $e;
        return $suma;
    }
    $resultado = sumarCincoNumeros(3, 7, 2, 9, 4);
    echo "<h2>Resultado de la suma</h2>";
    echo "<p>La suma de los cinco números es: <strong>$resultado</strong></p>";
    ?>
</body>
</html>
