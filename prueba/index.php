<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo</title>
</head>
<body>
    <?PHP
    $numero = 1; 
    $frase = "Este es mi numero:";
    $color="azul";
    $$color="es azul";
    $mensaje="Hola, munndo!";
    echo $color;
    echo $$color;
    echo $azul;
    ?>
    <p>Esto es contenido estático en HTML</p>
    <p><?php echo $frase.' '.$numero?></p>
    <?php 
    echo "<h1>Esto es contenido estático en HTML</h1>";

    function mostrarMensajeConGlobals(){
        echo $GLOBALS['mensaje'];
    }
    mostrarMensajeConGlobals();
    $biblioteca= array("Jeronimo","Kika","Pokemon");
    print_r($biblioteca);
    ?>
    
</body>
</html>