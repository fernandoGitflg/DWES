<?php
$errores = [];
$nombreUser = $apellidosUser = $direccionUser = $telefonoUser = $emailUser = "";
$asignaturasUser = [];
$formularioEnviado = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validación dfgdfg
    if (empty($_POST["nombre"])) {
        $errores['nombre'] = "El campo 'Nombre' es obligatorio.";
    } else {
        $nombreUser = $_POST["nombre"];
    }

    if (empty($_POST["apellidos"])) {
        $errores['apellidos'] = "El campo 'Apellidos' es obligatorio.";
    } else {
        $apellidosUser = $_POST["apellidos"];
    }

    if (empty($_POST["direccion"])) {
        $errores['direccion'] = "El campo 'Dirección' es obligatorio.";
    } else {
        $direccionUser = $_POST["direccion"];
    }

    if (empty($_POST["email"])) {
        $errores['email'] = "El campo 'Email' es obligatorio.";
    } else {
        $emailUser = $_POST["email"];
    }

    if (empty($_POST["telefono"])) {
        $errores['telefono'] = "El campo 'Teléfono' es obligatorio.";
    } else {
        $telefonoUser = $_POST["telefono"];
    }

    if (!isset($_POST["asignaturas"])) {
        $errores['asignaturas'] = "Debes seleccionar al menos una asignatura.";
    } else {
        $asignaturasUser = $_POST["asignaturas"];
    }

    // Si no hay errores, mostrar datos y ocultar formulario
    if (empty($errores)) {
        $formularioEnviado = true;
        echo "<h2>Datos del alumno</h2>";
        echo "$nombreUser<br>$apellidosUser<br>$direccionUser<br>$telefonoUser<br>$emailUser<br>";
        echo "<h2>Asignaturas matriculadas</h2>";
        for ($i = 0; $i < count($asignaturasUser); $i++) {
            echo $asignaturasUser[$i] . "<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario alumno</title>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php if (!$formularioEnviado): ?>
    <form action="#" method="post">
        <h1>Inserte los datos del alumno</h1>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?=$nombreUser?>">
        <span class="error"><?= $errores['nombre'] ?? '' ?></span><br><br>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?= $apellidosUser?>">
        <span class="error"><?= $errores['apellidos'] ?? '' ?></span><br><br>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?=$direccionUser?>">
        <span class="error"><?= $errores['direccion'] ?? '' ?></span><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?=$emailUser?>">
        <span class="error"><?= $errores['email'] ?? '' ?></span><br><br>

        <label>Teléfono:</label>
        <input type="tel" name="telefono" value="<?=$telefonoUser ?>">
        <span class="error"><?= $errores['telefono'] ?? '' ?></span><br><br>

        <label>Asignaturas matriculadas:</label><br>
        <?php
        $asignaturasDisponibles = [
            "Desarrollo Web Entorno-Cliente" => "DWEC",
            "Desarrollo Web Entorno-Servidor" => "DWES",
            "Diseño de interfaces" => "DI",
            "Despliegue Servidor" => "DS"
        ];
        foreach ($asignaturasDisponibles as $valor => $etiqueta) {
            $checked = in_array($valor, $asignaturasUser) ? "checked" : "";
            echo "<input type='checkbox' name='asignaturas[]' value='$valor' $checked> $etiqueta ";
        }
        ?>
        <br><span class="error"><?= $errores['asignaturas'] ?? '' ?></span><br><br>


        <input type="submit" value="Enviar">
        <input type="reset" value="Reiniciar" onclick="window.location.href=window.location.pathname">
    </form>
    <?php endif ?>
</body>
</html>
