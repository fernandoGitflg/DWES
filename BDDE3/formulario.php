<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Comunidades</title>
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

    $sql = "SELECT id_comunidad,nombre FROM comunidades";
    $result = $conn->prepare($sql);
    $result->execute();

    if ($result) { ?>
        <form action="formulario2.php" method="POST">
            <label for="comunidad">Selecciona una comunidad:</label>
            <select name="comunidad" id="comunidad">
                <?php
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . ($row["id_comunidad"]) . "'>" .($row["nombre"]) . "</option>";
                }
                $conn = null;
                ?>
            </select>
            <button type="submit">Enviar</button>
        </form>
        
    <?php
    } else {
        echo "Error en la consulta";
        $conn = null;
    }
    } catch (PDOException $e) {
        die("Conexión fallida: " . $e->getMessage());
    }
    ?>
</body>

</html>