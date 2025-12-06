<?php
declare(strict_types=1);

include_once 'Dwes/ProyectoVideoclub/Videoclub.php';

use Dwes\ProyectoVideoclub\Videoclub;

// Creamos el videoclub
$vc = new Videoclub("VideoClub Medina");

// Añadimos productos
$vc->incluirCintaVideo("Titanic", 2.5, 195);
$vc->incluirDvd("Matrix", 3.0, "Español, Inglés", "Widescreen");
$vc->incluirDvd("Los Serrano", 10.0, "Español, Inglés", "Widescreen");
$vc->incluirJuego("FIFA 25", 5.0, "PS5", 1, 4);
$vc->incluirJuego("GTA VI", 55.0, "PS5", 1, 4);

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

echo "<div class='bloque'><h2>ALQUILER MÚLTIPLE (CORRECTO)</h2>";
$vc->alquilarSocioProductos(2, [1, 2]);
echo "</div><hr>";

echo "<div class='bloque'><h2>SOPORTES ALQUILADOS POR ANA</h2>";
$vc->getSocios()[1]->listaAlquileres();
echo "</div><hr>";

echo "<div class='bloque'><h2>DEVOLUCIÓN SIMPLE</h2>";
$vc->devolverSocioProducto(2, 1); 
echo "</div><hr>";

echo "<div class='bloque'><h2>DEVOLUCIÓN MÚLTIPLE</h2>";
$vc->devolverSocioProductos(2, [2]); 
echo "</div><hr>";

echo "<div class='bloque'><h2>ESTADÍSTICAS DEL VIDEOCLUB</h2>";
echo "Productos actualmente alquilados: " . $vc->getNumProductosAlquilados() . "<br>";
echo "Total de alquileres realizados: " . $vc->getNumTotalAlquileres() . "<br>";
echo "</div><hr>";

/* ============================
   PRUEBAS DE EXCEPCIONES
   ============================ */

echo "<div class='bloque'><h2>PRUEBA DE EXCEPCIONES</h2>";

// 1. Cliente no encontrado
$vc->alquilarSocioProductos(99, [1]); // socio inexistente

// 2. Soporte no encontrado
$vc->alquilarSocioProductos(1, [99]); // soporte inexistente

// 3. Soporte ya alquilado
$vc->alquilarSocioProductos(1, [3]); // Fernando alquila Los Serrano
$vc->alquilarSocioProductos(2, [3]); // Ana intenta alquilar Los Serrano ya alquilado

// 4. Cupo superado
$vc->alquilarSocioProductos(2, [4, 5]); // Ana tiene cupo de 2, alquila 2
$vc->alquilarSocioProductos(2, [1]);    // intenta alquilar uno más, supera cupo
echo "</div><hr>";

echo "</body></html>";
