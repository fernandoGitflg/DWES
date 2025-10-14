<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Provincias</title>
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


        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["comunidad"])) {
            $idComunidad = $_POST["comunidad"];

            $sql = "SELECT n_provincia,nombre FROM provincias WHERE id_comunidad = :id ORDER BY nombre ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $idComunidad, PDO::PARAM_INT);
            $stmt->execute();

            echo "<h3>Provincias de la comunidad seleccionada:</h3>";
            echo "<form method='POST' action='formulario3.php'>";
            echo "<select name='provincia'>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row["n_provincia"]) . "'>" . htmlspecialchars($row["nombre"]) . "</option>";
            }
            echo "</select>";
            echo "<button type='submit'>Buscar</button>";
            echo "</form>";
            $conn = null;
        } else {
            echo "Por favor seleccione una comunidad";
            $conn = null;
        }
    } catch (PDOException $e) {
        die("Conexión fallida: " . $e->getMessage());
    }
    ?>

</body>

</html>