<?php
if (isset($_GET['opcion']) && !empty($_GET['opcion'])) {
    $opcion = $_GET['opcion'];
    switch ($opcion) {
        case '1':
            echo "Tu fruta favorita es la fresa";
            break;
        case '2':
            echo "Tu fruta favorita es el mango";
            break;
        case '3':
            echo "Tu fruta favorita es el plátano";
            break;
        case '4':
            echo "Tu fruta favorita es la naranja";
            break;
        default:
            echo "Opción no válida.";
    }
} else {
    include("formularioR.html");
}
