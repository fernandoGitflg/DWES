<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $Frutas = array(
        "Manzana" => "roja",
        "Plátano" => "amarillo",
        "Naranja" => "naranja"
    );

    
    echo "Forma ascendenteV:<br>";
    asort($Frutas);
    print_r($Frutas);
    echo "<br>Forma ascendenteC:<br>";
    aRsort($Frutas);
    print_r($Frutas);
    echo "<br>Forma descendenteV:<br>";
    Ksort($Frutas);
    print_r($Frutas);
    echo "<br>Forma descendenteC:<br>";
    krsort($Frutas);
    print_r($Frutas);
    ?>
</body>

</html>