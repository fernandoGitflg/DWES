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

$servername = "localhost";
$username = "root";
$password = "";
$database = "cadena_restaurantes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtCat = $conn->prepare("SELECT nombre FROM categorias WHERE codigo = :codigo");
    $stmtCat->bindParam(':codigo', $categoria_id);
    $stmtCat->execute();
    $categoria = $stmtCat->fetch(PDO::FETCH_ASSOC);

    if (!$categoria) {
        echo "Categoría no encontrada.";
        exit;
    }

    $stmtProd = $conn->prepare("SELECT * FROM productos WHERE id_categoria = :categoria");
    $stmtProd->bindParam(':categoria', $categoria_id);
    $stmtProd->execute();
    $productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al cargar productos: " . $e->getMessage();
    exit;
}

$mensaje_global = $_GET['mensaje'] ?? null;
$error_global = $_GET['error'] ?? null;
$codigo_mensaje = $_GET['codigo'] ?? null;
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
                <th>Stock</th>
                <th>Unidades</th>
                <th>Acción</th>
                <th></th>
              </tr>';

        foreach ($productos as $prod) {
            echo '<form action="añadirCarrito.php" method="post">';
            echo '<tr>';
            echo '<td>' . htmlspecialchars($prod['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($prod['descripcion']) . '</td>';
            echo '<td>' . number_format($prod['precio'], 2) . ' €</td>';
            echo '<td>';
            if ($prod['stock'] == 0) {
                echo 'Producto agotado';
            } elseif ($prod['stock'] < 5) {
                echo '¡Sólo quedan ' . $prod['stock'] . '!';
            } else {
                echo $prod['stock'];
            }
            echo '</td>';
            echo '<td><input type="number" name="unidades[' . $prod['codigo'] . ']" min="1"></td>';
            echo '<td>
                    <input type="hidden" name="categoria_id" value="' . htmlspecialchars($categoria_id) . '">
                    <button type="submit" name="comprar" value="' . $prod['codigo'] . '">Comprar</button>
                  </td>';
            echo '<td>';
            if ($codigo_mensaje == $prod['codigo']) {
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