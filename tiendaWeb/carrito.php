<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['usuario'];
$carrito = $_SESSION['carrito'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['vaciar'])) {
        unset($_SESSION['carrito']);
        header("Location: carrito.php");
        exit;
    }

    if (isset($_POST['eliminar'])) {
        $codigo = $_POST['eliminar'];
        unset($_SESSION['carrito'][$codigo]);
        header("Location: carrito.php");
        exit;
    }

    if (isset($_POST['actualizar'])) {
        foreach ($_POST['nuevas_unidades'] as $codigo => $cantidad) {
            if ($cantidad > 0) {
                $_SESSION['carrito'][$codigo]['unidades'] = $cantidad;
            } else {
                unset($_SESSION['carrito'][$codigo]);
            }
        }
        header("Location: carrito.php");
        exit;
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
        <span>Usuario: <?php echo htmlspecialchars($email); ?></span>
        <a href="categorias.php">Home</a>
        <a href="carrito.php">Ver carrito</a>
        <a href="logout.php">Cerrar sesión</a>
    </header>

    <h2>Carrito de la compra</h2>

    <?php
    if (empty($carrito)) {
        echo "<p>El carrito está vacío.</p>";
    } else {
        echo '<form method="post">';
        echo '<table>';
        echo '<tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Unidades</th>
                <th>Total</th>
              </tr>';

        $total_pedido = 0;

        foreach ($carrito as $codigo => $producto) {
            $total_producto = $producto['precio'] * $producto['unidades'];
            $total_pedido += $total_producto;

            echo '<tr>';
            echo '<td>' . htmlspecialchars($producto['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($producto['descripcion']) . '</td>';
            echo '<td>' . number_format($producto['precio'], 2) . ' €</td>';
            echo '<td><input type="number" name="nuevas_unidades[' . $codigo . ']" value="' . $producto['unidades'] . '" min="0"></td>';
            echo '<td>' . number_format($total_producto, 2) . ' €</td>';
            echo '<td><button type="submit" name="eliminar" value="' . $codigo . '">Eliminar</button></td>';
            echo '</tr>';
        }

        echo '<tr><td colspan="4">Total del pedido:</td>';
        echo '<td colspan="2">' . number_format($total_pedido, 2) . ' €</td></tr>';
        echo '</table><br>';

        echo '<button type="submit" name="actualizar">Actualizar cantidades</button> ';
        echo '<button type="submit" name="vaciar">Vaciar carrito</button>';
        echo '</form><br>';

        echo '<a href="realizar_pedido.php">Realizar pedido</a>';
    }
    ?>
</body>
</html>
