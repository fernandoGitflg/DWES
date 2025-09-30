<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Alumno</title>
</head>

<body>
    <?php
    if (
        !empty($_POST["nombre"]) &&
        !empty($_POST["apellidos"]) &&
        !empty($_POST["direccion"]) &&
        !empty($_POST["telefono"]) &&
        !empty($_POST["email"]) &&
        isset($_POST["asignaturas"])
    ) {
        $nombreUser = $_POST["nombre"];
        $apellidosUser = $_POST["apellidos"];
        $direccionUser = $_POST["direccion"];
        $telefonoUser = $_POST["telefono"];
        $emailUser = $_POST["email"];
        $asignaturasUser = $_POST["asignaturas"];
        echo "<h2>Datos del alumno</h2>";
        echo $nombreUser . "<br>";
        echo $apellidosUser . "<br>";
        echo $direccionUser . "<br>";
        echo $telefonoUser . "<br>";
        echo $emailUser . "<br>";
        echo "<h2>Asignaturas matriculadas</h2>";

        for ($i = 0; $i < count($asignaturasUser); $i++) {
            echo $asignaturasUser[$i] . "<br>";
        }
    } else {
        include("formulario1.php");
    }
    ?>
</body>

</html>