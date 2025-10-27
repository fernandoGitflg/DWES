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

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "cadena_restaurantes";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener nombre de la categoría
    $stmtCat = $conn->prepare("SELECT nombre FROM categorias WHERE codigo = :codigo");
    $stmtCat->bindParam(':codigo', $categoria_id);
    $stmtCat->execute();
    $categoria = $stmtCat->fetch(PDO::FETCH_ASSOC);

    if (!$categoria) {
        echo "Categoría no encontrada.";
        exit;
    }

    // Obtener productos de esa categoría
    $stmtProd = $conn->prepare("SELECT * FROM productos WHERE id_categoria = :categoria");
    $stmtProd->bindParam(':categoria', $categoria_id);
    $stmtProd->execute();
    $productos = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al cargar productos: " . $e->getMessage();
    exit;
}

// Validación de stock
$mensaje_error = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $codigo = $_POST['comprar'];
    $unidades = $_POST['unidades'][$codigo] ?? 0;

    foreach ($productos as $prod) {
        if ($prod['codigo'] == $codigo) {
            if ($unidades > $prod['stock']) {
                $mensaje_error[$codigo] = "No hay suficiente stock disponible.";
            } else {
                $_POST['unidades'] = $unidades;
                $_POST['comprar'] = $codigo;
                include("carrito.php");
                exit;
            }
        }
    }
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
                <th>Stock</th>
                <th>Unidades</th>
                <th>Acción</th>
                <th></th>
              </tr>';

        foreach ($productos as $prod) {
            echo '<form action="" method="post">';
            echo '<tr>';
            echo '<td>' . htmlspecialchars($prod['nombre']) . '</td>';
            echo '<td>' . htmlspecialchars($prod['descripcion']) . '</td>';
            echo '<td>' . number_format($prod['precio'], 2) . ' €</td>';
            echo '<td>' . $prod['stock'] . '</td>';
            echo '<td><input type="number" name="unidades[' . $prod['codigo'] . ']" min="1" required></td>';
            echo '<td><button type="submit" name="comprar" value="' . $prod['codigo'] . '">Comprar</button></td>';

            // Celda adicional solo si hay error
            if (isset($mensaje_error[$prod['codigo']])) {
                echo '<td style="color:red;">' . $mensaje_error[$prod['codigo']] . '</td>';
            } else {
                echo '<td></td>';
            }

            echo '</tr>';
            echo '</form>';
        }

        echo '</table>';
    }
    ?>
</body>
</html>
