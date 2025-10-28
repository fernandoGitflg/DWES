<?php
session_start();

if (!isset($_SESSION['usuario']) && isset($_COOKIE['remember_email'])) {
    $_SESSION['usuario'] = $_COOKIE['remember_email'];
}

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
</head>

<body>
    <header>
        <span>Usuario: <?php echo htmlspecialchars($email); ?></span>
        <a href="categorias.php">Home</a>
        <a href="carrito.php">Ver carrito</a>
        <a href="logout.php">Cerrar sesión</a>
    </header>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cadena_restaurantes";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT codigo, nombre FROM categorias";
        $stmt = $conn->query($sql);
        $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<p>Error al cargar categorías: " . $e->getMessage() . "</p>";
        $categorias = [];
    }
    ?>

    <h2>Lista de categorías</h2>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li><a href="producto.php?categoria=<?php echo $categoria['codigo']; ?>">
                    <?php echo htmlspecialchars($categoria['nombre']); ?>
                </a></li>
        <?php endforeach; ?>
    </ul>

</body>

</html>
