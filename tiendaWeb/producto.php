<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['usuario'];
$categoria_id = $_GET['categoria'] ?? null;

if (!$categoria_id) {
    echo "No se ha especificado una categoría.";
    exit;
}

$mensaje_global = $_GET['mensaje'] ?? null;
$error_global = $_GET['error'] ?? null;
$codigo_mensaje = $_GET['codigo'] ?? null;

try {
    $conn = new PDO("mysql:host=localhost;dbname=cadena_restaurantes", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtCat = $conn->prepare("SELECT nombre FROM categorias WHERE codigo = :codigo");
    $stmtCat->bindParam(':codigo', $categoria_id);
    $stmtCat->execute();
    $categoria = $stmtCat->fetch(PDO::FETCH_ASSOC);

    $stmtProd = $conn->prepare("SELECT * FROM productos WHERE id_categoria = :categoria");
    $stmtProd->bindParam(':categoria', $categoria_id);
    $stmtProd->execute();
    $productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al cargar productos: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <header>
        <span>Usuario: <?php echo htmlspecialchars($email); ?></span>
        <a href="categorias.php">Home</a>
        <a href="carrito.php">Ver carrito</a>
        <a href="logout.php">Cerrar sesión</a>
    </header>

    <h2><?php echo htmlspecialchars($categoria['nombre']); ?></h2>

    <?php
    if (count($productos) === 0) {
        echo "<p>No hay productos en esta categoría.</p>";
    } else {
        echo '<table>';
        echo '<tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Stock disponible</th>
                <th>Unidades</th>
                <th>Acción</th>
                <th></th>
              </tr>';

        foreach ($productos as $prod) {
            $codigo = $prod['codigo'];
            $stock_real = $prod['stock'];
            $en_carrito = $_SESSION['carrito'][$codigo]['unidades'] ?? 0;
            $stock_disponible = $stock_real - $en_carrito;

            echo '<form action="añadirCarrito.php" method="post">';
            echo '<tr>';
            echo '<td>' . htmlspecialchars($prod['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($prod['descripcion']) . '</td>';
            echo '<td>' . number_format($prod['precio'], 2) . ' €</td>';
            echo '<td>';
            if ($stock_disponible <= 0) {
                echo 'Producto agotado';
            } elseif ($stock_disponible < 5) {
                echo '¡Sólo quedan ' . $stock_disponible . '!';
            } else {
                echo $stock_disponible;
            }
            echo '</td>';
            echo '<td><input type="number" name="unidades[' . $codigo . ']" min="1" max="' . $stock_disponible . '"></td>';
            echo '<td>
                    <input type="hidden" name="categoria_id" value="' . htmlspecialchars($categoria_id) . '">
                    <button type="submit" name="comprar" value="' . $codigo . '" ' . ($stock_disponible <= 0 ? 'disabled' : '') . '>Comprar</button>
                  </td>';
            echo '<td>';
            if ($codigo_mensaje == $codigo) {
                if ($mensaje_global === 'producto_añadido') {
                    echo '<span style="color:green;">Añadido al carrito</span>';
                } elseif ($error_global === 'stock_insuficiente') {
                    echo '<span style="color:red;">No hay suficiente stock</span>';
                } elseif ($error_global === 'datos_invalidos') {
                    echo '<span style="color:red;">Cantidad inválida</span>';
                }
            }
            echo '</td>';
            echo '</tr>';
            echo '</form>';
        }

        echo '</table>';
    }
    ?>
</body>
</html>
