<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Alumnado</title>
</head>

<body>
    <h1>
        Inserte los datos del alumno
    </h1>
    <form action="visor.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" placeholder="calle, num, etc..." required><br><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" required><br><br>
        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" required><br><br>

        <label>Asignaturas matriculadas:</label><br>
        <input type="checkbox" name="asignaturas[]" value="Desarrollo Web Entorno-Cliente"> DWEC
        <input type="checkbox" name="asignaturas[]" value="Desarrollo Web Entorno-Servidor"> DWES<br>
        <input type="checkbox" name="asignaturas[]" value="Diseño de interfaces"> DI
        <input type="checkbox" name="asignaturas[]" value="Despliegue Servidor"> DS<br><br>

        <input type="submit" value="Enviar">
        <input type="reset" value="Reiniciar">
    </form>

</body>

</html>