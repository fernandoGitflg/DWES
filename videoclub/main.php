<?php
declare(strict_types=1);

// Incluimos todas las clases necesarias
require_once 'Soporte.php';
require_once 'CintaVideo.php';
require_once 'Dvd.php';
require_once 'Juego.php';
require_once 'Cliente.php';
require_once 'Videoclub.php';

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

echo "<div class='bloque'><h2>ALQUILERES</h2>";
$vc->alquilarSocioProducto(1, 2); 
$vc->alquilarSocioProducto(1, 3);
echo "</div><hr>";

echo "<div class='bloque'><h2>SOPORTES ALQUILADOS POR FERNANDO</h2>";
$vc->getSocios()[0]->listaAlquileres();
echo "</div><hr>";

echo "<div class='bloque'><h2>DEVOLUCIÓN</h2>";
$vc->getSocios()[0]->devolver(2);
echo "</div><hr>";

echo "<div class='bloque'><h2>SOPORTES ALQUILADOS POR FERNANDO (DESPUÉS DE DEVOLVER)</h2>";
$vc->getSocios()[0]->listaAlquileres();
echo "</div>";

echo "</body></html>";
