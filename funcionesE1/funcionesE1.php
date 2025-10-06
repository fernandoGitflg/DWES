<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FuncionesE1</title>
</head>

<body>
    <?php

    function procesarTexto($texto, $clave, $accion)
    {
        $resultado = "";

        for ($i = 0; $i < strlen($texto); $i++) {
            $caracter = $texto[$i];
            $codigo = ord($caracter);

            // Solo encriptar letras y números
            if (($codigo >= 32 && $codigo <= 126)) {
                if ($accion === "encriptar") {
                    $codigo += $clave;
                } else {
                    $codigo -= $clave;
                }

                // Asegurar que el código esté dentro del rango visible
                if ($codigo > 126) $codigo = 32 + ($codigo - 127);
                if ($codigo < 32) $codigo = 127 - (32 - $codigo);
            }

            $resultado .= chr($codigo);
        }

        return $resultado;
    }



    // Validación
    $texto = $_POST['texto'] ?? '';
    $clave = $_POST['clave'] ?? '';
    $accion = $_POST['accion'] ?? '';

    if (strlen($texto) <= 10) {
        echo "<p>Error: El texto debe tener más de 10 caracteres.</p>";
        exit;
    }

    if (!is_numeric($clave) || $clave < 1 || $clave > 99) {
        echo "<p>Error: La clave debe ser un número entre 1 y 99.</p>";
        exit;
    }

    // Procesar
    $resultado = procesarTexto($texto, (int)$clave, $accion);
    if ($accion == "encriptar") {
        echo "<h2>Encriptacion:</h2>";
    } else {
        echo "<h2>Desencriptacion:</h2>";
    }
    echo "<p><strong>$resultado</strong></p>";
    ?>

</body>

</html>