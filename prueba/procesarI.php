<?php
if (isset($_GET['opcion']) && !empty($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    switch ($opcion) {
        case '1':
            echo "<img src=./imagenes/fresa.png width=100>";
            break;
        case '2':
            echo "<img src=./imagenes/mango.png width=100>";
            break;
        case '3':
            echo "<img src=./imagenes/platano.png width=150>";
            break;
        case '4':
            echo "<img src=./imagenes/naranja.png width=100>";
            break;
        default:
            echo "Opción no válida.";
    }
} else {
    header("Location:./formularioI.html");
}
