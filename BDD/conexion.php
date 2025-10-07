<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cursos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si se ha pulsado el botón para ocupar plaza
    if (isset($_GET['ocupar'])) {
        $id = intval($_GET['ocupar']);
        $conn->query("UPDATE cursos 
                  SET plazas_ocupadas = plazas_ocupadas + 1,
                      plazas_disponibles = plazas_disponibles - 1
                  WHERE id = $id AND plazas_disponibles > 0");
        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        exit;
    }

    // Obtener todos los cursos
    $sql = "SELECT * FROM cursos";
    $result = $conn->query($sql);

    $total_disponibles = 0;
    $total_ofertadas = 0;
    $total_ocupadas = 0;

    echo "<h2>Lista de cursos</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>Título</th>
            <th>Plazas Totales</th>
            <th>Plazas Disponibles</th>
            <th></th>
          </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $total_disponibles += $row['plazas_disponibles'];
        $total_ofertadas += $row['plazas_totales'];
        $total_ocupadas += $row['plazas_ocupadas'];

        if (($row['plazas_disponibles'] == 0)) {
            echo "<tr>
                    <td><s>{$row['titulo']}</s></td>
                    <td><s>{$row['plazas_totales']}</s></td>
                    <td><s>{$row['plazas_disponibles']}</s></td>
                  </tr>";
        } else {
            echo "<tr>
                    <td>{$row['titulo']}</td>
                    <td>{$row['plazas_totales']}</td>
                    <td>{$row['plazas_disponibles']}</td>
                    <td><a href='?ocupar={$row['id']}'>Ocupar plaza</a></td>
                  </tr>";
        }
    }

    echo "</table>";

    $porcentaje = $total_ofertadas > 0 ? round(($total_ocupadas / $total_ofertadas) * 100, 2) : 0;

    echo "<h3>Resumen de ocupación</h3>";
    echo "<p>Plazas ofertadas: $total_ofertadas</p>";
    echo "<p>Plazas ocupadas: " . $total_ocupadas . "</p>";
    echo "<p>Porcentaje de ocupación: $porcentaje%</p>";

    $conn = null;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
