<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$codigo = $_POST['comprar'] ?? null;
$categoria_id = $_POST['categoria_id'] ?? '';
$unidades = $_POST['unidades'][$codigo] ?? 0;

if (!$codigo || $unidades <= 0) {
    header("Location: producto.php?categoria=$categoria_id&error=datos_invalidos&codigo=$codigo");
    exit;
}

try {
    $conn = new PDO("mysql:host=localhost;dbname=cadena_restaurantes", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT nombre, descripcion, precio, stock FROM productos WHERE codigo = :codigo");
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        header("Location: producto.php?categoria=$categoria_id&error=producto_no_encontrado&codigo=$codigo");
        exit;
    }

    $unidades_en_carrito = $_SESSION['carrito'][$codigo]['unidades'] ?? 0;
    $total_solicitado = $unidades_en_carrito + $unidades;

    if ($total_solicitado > $producto['stock']) {
        header("Location: producto.php?categoria=$categoria_id&error=stock_insuficiente&codigo=$codigo");
        exit;
    }

    if (isset($_SESSION['carrito'][$codigo])) {
        $_SESSION['carrito'][$codigo]['unidades'] += $unidades;
    } else {
        $_SESSION['carrito'][$codigo] = [
            'nombre' => $producto['nombre'],
            'descripcion' => $producto['descripcion'],
            'precio' => $producto['precio'],
            'unidades' => $unidades
        ];
    }

    header("Location: producto.php?categoria=$categoria_id&mensaje=producto_añadido&codigo=$codigo");
    exit;
} catch (PDOException $e) {
    echo "Error al añadir producto al carrito: " . $e->getMessage();
}
