<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$email = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'] ?? [];

// Si se ha enviado un nuevo producto desde productos.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $codigo = $_POST['comprar'];
    $unidades = $_POST['unidades'][$codigo] ?? 0; // ← CORREGIDO AQUÍ

    if ($unidades > 0) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=cadena_restaurantes", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Incluimos el precio en la consulta
            $stmt = $conn->prepare("SELECT nombre, descripcion, precio FROM productos WHERE codigo = :codigo");
            $stmt->bindParam(':codigo', $codigo);
            $stmt->execute();
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($producto) {
                if (isset($carrito[$codigo])) {
                    $carrito[$codigo]['unidades'] += $unidades;
                } else {
                    $carrito[$codigo] = [
                        'nombre' => $producto['nombre'],
                        'descripcion' => $producto['descripcion'],
                        'precio' => $producto['precio'],
                        'unidades' => $unidades
                    ];
                }
                $_SESSION['carrito'] = $carrito;
            }
        } catch (PDOException $e) {
            echo "Error al añadir producto al carrito: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
</head>
<body>
    <header>
        <span>Usuario:<?php echo htmlspecialchars($email); ?></span>
        <a href="categorias.php">Home</a>
        <a href="carrito.php">Ver carrito</a>
        <a href="logout.php">Cerrar sesión</a>
    </header>

    <hr><h2>Carrito de la compra</h2>

    <?php if (empty($carrito)) {
        echo "<p>El carrito está vacío.</p>";
    } else {
        echo '<table>';
        echo '<tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Unidades</th>
              </tr>';

        foreach ($carrito as $codigo => $producto) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($producto['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($producto['descripcion']) . '</td>';
            echo '<td>' . number_format($producto['precio'], 2) . ' €</td>';
            echo '<td>' . $producto['unidades'] . '</td>';
            echo '</tr>';
        }

        echo '</table><hr>';
        echo '<br><a href="realizar_pedido.php">Realizar pedido</a>';
    }
    ?>
</body>
</html>
