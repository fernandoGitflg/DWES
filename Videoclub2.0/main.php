<?php
declare(strict_types=1);

include_once 'app/Dwes/ProyectoVideoclub/Videoclub.php';

use Dwes\ProyectoVideoclub\Videoclub;

// Creamos el videoclub
$vc = new Videoclub("VideoClub Medina");

// Añadimos productos
$vc->incluirCintaVideo("Titanic", 2.5, 195);
$vc->incluirDvd("Matrix", 3.0, "Español, Inglés", "Widescreen");
$vc->incluirJuego("FIFA 25", 5.0, "PS5", 1, 4);

// Añadimos socios
$vc->incluirSocio("Fernando", 3);
$vc->incluirSocio("Ana", 2);

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Videoclub Fernando</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { color: #2c3e50; }
        hr { margin: 20px 0; }
        .bloque { margin-bottom: 20px; }
    </style>
</head>
<body>";

echo "<h1>Gestión del Videoclub</h1>";

echo "<div class='bloque'><h2>LISTA DE PRODUCTOS</h2>";
$vc->listarProductos();
echo "</div><hr>";

echo "<div class='bloque'><h2>LISTA DE SOCIOS</h2>";
$vc->listarSocios();
echo "</div><hr>";

echo "<div class='bloque'><h2>ALQUILER SIMPLE</h2>";
$vc->alquilarSocioProducto(1, 2); // Fernando alquila Matrix
$vc->alquilarSocioProducto(1, 3); // Fernando alquila FIFA 25
echo "</div><hr>";

echo "<div class='bloque'><h2>ALQUILER MÚLTIPLE</h2>";
$vc->alquilarSocioProductos(2, [1, 2]); // Ana intenta alquilar Titanic y Matrix
echo "</div><hr>";

echo "<div class='bloque'><h2>SOPORTES ALQUILADOS POR FERNANDO</h2>";
$vc->getSocios()[0]->listaAlquileres();
echo "</div><hr>";

echo "<div class='bloque'><h2>DEVOLUCIÓN SIMPLE</h2>";
$vc->devolverSocioProducto(1, 2); // Fernando devuelve Matrix
echo "</div><hr>";

echo "<div class='bloque'><h2>DEVOLUCIÓN MÚLTIPLE</h2>";
$vc->devolverSocioProductos(1, [3]); // Fernando devuelve FIFA 25
echo "</div><hr>";

echo "<div class='bloque'><h2>SOPORTES ALQUILADOS POR FERNANDO (DESPUÉS DE DEVOLVER)</h2>";
$vc->getSocios()[0]->listaAlquileres();
echo "</div><hr>";

echo "<div class='bloque'><h2>ESTADÍSTICAS DEL VIDEOCLUB</h2>";
echo "Productos actualmente alquilados: " . $vc->getNumProductosAlquilados() . "<br>";
echo "Total de alquileres realizados: " . $vc->getNumTotalAlquileres() . "<br>";
echo "</div>";

echo "</body></html>";
