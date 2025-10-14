<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Localidades</title>
</head>

<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "geografia";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["provincia"])) {
            $idProvincia = $_POST["provincia"];

            $sql = "SELECT id_localidad,nombre FROM localidades WHERE n_provincia = :id ORDER BY nombre ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $idProvincia, PDO::PARAM_INT);
            $stmt->execute();

            echo "<h3>Localidadaes de la provincia seleccionada:</h3>";
            echo "<form method='POST' action='formulario3.php'>";
            echo "<select name='localidad'>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row["id_localidad"]) . "'>" . htmlspecialchars($row["nombre"]) . "</option>";
            }
            echo "</select>";
            echo "<button type='submit'>Buscar</button>";
            echo "</form>";

            if (isset($_POST["localidad"])) {
                $idLocalidad = $_POST["localidad"];
                $sql = "SELECT nombre,poblacion FROM localidades WHERE id_localidad = :id ORDER BY nombre ASC";
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

            echo "Por favor seleccione una provincia";
            $conn = null;
        }
    } catch (PDOException $e) {
        die("Conexión fallida: " . $e->getMessage());
    }
    ?>

</body>

</html>