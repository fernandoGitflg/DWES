<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    echo "<p>No hay productos en el carrito.</p>";
    echo '<a href="categorias.php">Volver al inicio</a>';
    exit;
}

try {
    $conn = new PDO("mysql:host=localhost;dbname=cadena_restaurantes", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Iniciar transacción
    $conn->beginTransaction();

    // Obtener ID del restaurante
    $stmtRest = $conn->prepare("SELECT codigo FROM restaurantes WHERE email = :email");
    $stmtRest->bindParam(':email', $email);
    $stmtRest->execute();
    $restaurante = $stmtRest->fetch(PDO::FETCH_ASSOC);

    if (!$restaurante) {
        throw new Exception("Restaurante no encontrado.");
    }

    $id_restaurante = $restaurante['codigo'];
    $fecha = date('Y-m-d H:i:s');
    $estado = 'no enviado';

    // Calcular precio total
    $precio_total = 0;
    foreach ($carrito as $producto) {
        $precio_total += $producto['precio'] * $producto['unidades'];
    }

    // Insertar pedido
    $stmtPedido = $conn->prepare("INSERT INTO pedidos (id_restaurante, fecha, estado, precio_total) VALUES (:id_restaurante, :fecha, :estado, :precio_total)");
    $stmtPedido->bindParam(':id_restaurante', $id_restaurante);
    $stmtPedido->bindParam(':fecha', $fecha);
    $stmtPedido->bindParam(':estado', $estado);
    $stmtPedido->bindParam(':precio_total', $precio_total);
    $stmtPedido->execute();

    $id_pedido = $conn->lastInsertId();

    // Preparar inserción de líneas
    $stmtLinea = $conn->prepare("INSERT INTO detallespedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES (:id_pedido, :id_producto, :cantidad, :precio_unitario)");

    // Preparar actualización de stock
    $stmtStock = $conn->prepare("UPDATE productos SET stock = stock - :cantidad WHERE codigo = :codigo");

    foreach ($carrito as $codigo => $producto) {
        // Insertar línea
        $stmtLinea->bindParam(':id_pedido', $id_pedido);
        $stmtLinea->bindParam(':id_producto', $codigo);
        $stmtLinea->bindParam(':cantidad', $producto['unidades']);
        $stmtLinea->bindParam(':precio_unitario', $producto['precio']);
        $stmtLinea->execute();

        // Actualizar stock
        $stmtStock->bindParam(':cantidad', $producto['unidades']);
        $stmtStock->bindParam(':codigo', $codigo);
        $stmtStock->execute();
    }

    // Confirmar transacción
    $conn->commit();

    // Vaciar carrito
    unset($_SESSION['carrito']);

    echo "<p>Pedido realizado correctamente</p>";
    echo '<a href="categorias.php">Volver al inicio</a>';
} catch (Exception $e) {
    // Revertir si algo falla
    $conn->rollBack();
    echo "<p>Error al realizar el pedido: " . $e->getMessage() . "</p>";
    echo '<a href="categorias.php">Volver al inicio</a>';
}
?>
