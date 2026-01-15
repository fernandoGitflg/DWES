<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$database = "tareas_personales";

try {
    // Crear conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}