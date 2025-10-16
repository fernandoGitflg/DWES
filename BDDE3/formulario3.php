<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "geografia";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica si se ha enviado una provincia
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["provincia"])) {
        $idProvincia = $_POST["provincia"];

        // Mostrar localidades de la provincia seleccionada
        $sql = "SELECT id_localidad,nombre FROM localidades WHERE n_provincia = :id ORDER BY nombre ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $idProvincia, PDO::PARAM_INT);
        $stmt->execute();

        echo "<h3>Localidades de la provincia seleccionada:</h3>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='provincia' value='" . htmlspecialchars($idProvincia) . "'>";
        echo "<select name='localidad'>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . htmlspecialchars($row["id_localidad"]) . "'>" . htmlspecialchars($row["nombre"]) . "</option>";
        }
        echo "</select>";
        echo "<button type='submit'>Buscar</button>";
        echo "</form>";

        // Si también se ha enviado una localidad
        if (isset($_POST["localidad"])) {
            $idLocalidad = $_POST["localidad"];
            $sql = "SELECT nombre,poblacion FROM localidades WHERE id_localidad = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $idLocalidad, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                echo "<p>La población de <strong>" . htmlspecialchars($row["nombre"]) . "</strong> es de " . htmlspecialchars($row["poblacion"]) . " habitantes.</p>";
            } else {
                echo "<p>No se encontró la localidad seleccionada.</p>";
            }
        }
    } else {
        // Solo se muestra si no se ha enviado ninguna provincia
        echo "<p>Por favor seleccione una provincia.</p>";
    }
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>
