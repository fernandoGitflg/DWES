<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "geografia";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}

// Determinar el nombre de la provincia (POST o GET)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProvincia = $_POST["provincia"];
} elseif (isset($_GET["provincia"])) {
    $nombreProvincia = $_GET["provincia"];
} else {
    die("No se ha especificado ninguna provincia.");
}

// Buscar la provincia
$stmt = $conn->prepare("SELECT * FROM provincias WHERE LOWER(nombre) = LOWER(:nombre)");
$stmt->bindParam(':nombre', $nombreProvincia);
$stmt->execute();

if ($stmt->rowCount() == 0) {
    echo "<p>La provincia <strong>" . htmlspecialchars($nombreProvincia) . "</strong> no existe.</p>";
} else {
    $provincia = $stmt->fetch();
    $idProvincia = $provincia["n_provincia"];
    echo "<h2>Provincia encontrada: " . htmlspecialchars($provincia["nombre"]) . "</h2>";

    // Paginación
    $porPagina = 25;
    $pagina = isset($_GET["pagina"]) ? (int)$_GET["pagina"] : 1;
    $offset = ($pagina - 1) * $porPagina;

    // Obtener localidades
    $stmtLoc = $conn->prepare("SELECT nombre FROM localidades WHERE n_provincia = :id ORDER BY nombre ASC LIMIT :lim OFFSET :off");
    $stmtLoc->bindParam(':id', $idProvincia, PDO::PARAM_INT);
    $stmtLoc->bindParam(':lim', $porPagina, PDO::PARAM_INT);
    $stmtLoc->bindParam(':off', $offset, PDO::PARAM_INT);
    $stmtLoc->execute();

    echo "<h3>Localidades (Página $pagina)</h3><ul>";
    while ($loc = $stmtLoc->fetch()) {
        echo "<li>" . htmlspecialchars($loc["nombre"]) . "</li>";
    }
    echo "</ul>";

    // Total de localidades
    $stmtTotal = $conn->prepare("SELECT COUNT(*) FROM localidades WHERE n_provincia = :id");
    $stmtTotal->bindParam(':id', $idProvincia, PDO::PARAM_INT);
    $stmtTotal->execute();
    $totalLocalidades = $stmtTotal->fetchColumn();
    $totalPaginas = ceil($totalLocalidades / $porPagina);

    // Navegación
    echo "<div style='margin-top:20px;'>";
    if ($pagina > 1) {
        echo "<a href='?provincia=" . urlencode($nombreProvincia) . "&pagina=" . ($pagina - 1) . "'>Anterior</a> ";
    }
    for ($i = 1; $i <= $totalPaginas; $i++) {
        echo "<a href='?provincia=" . urlencode($nombreProvincia) . "&pagina=$i'>" . $i . "</a> ";
    }
    if ($pagina < $totalPaginas) {
        echo "<a href='?provincia=" . urlencode($nombreProvincia) . "&pagina=" . ($pagina + 1) . "'>Siguiente </a>";
    }
    echo "</div>";
}
?>
