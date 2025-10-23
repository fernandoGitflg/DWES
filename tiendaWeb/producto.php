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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
</head>
<body>
    <header>
        <span>Usuario:<?php echo htmlspecialchars($email); ?></span>
        <a href="categorias.php">Home</a>
        <a href="carrito.php">Ver carrito</a>
        <a href="logout.php">Cerrar sesión</a>
    </header>

    <h2><?php echo htmlspecialchars($categoria['nombre']); ?></h2>

    <?php if (count($productos) === 0): ?>
        <p>No hay productos en esta categoría.</p>
    <?php else: ?>
        <form action="carrito.php" method="post">
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Unidades</th>
                    <th>Acción</th>
                </tr>
                <?php foreach ($productos as $prod): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($prod['descripcion']); ?></td>
                        <td><?php echo $prod['precio']; ?> €</td>
                        <td><?php echo $prod['stock']; ?></td>
                        <td>
                            <input type="number" name="unidades[<?php echo $prod['codigo']; ?>]" min="0" max="<?php echo $prod['stock']; ?>">
                        </td>
                        <td>
                            <button type="submit" name="comprar" value="<?php echo $prod['codigo']; ?>">Comprar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    <?php endif; ?>
</body>
</html>
