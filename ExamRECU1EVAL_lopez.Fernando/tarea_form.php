<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }

    $id= $_GET['id'] ?? null;
    $tarea=null;
    if($id){
        require 'conexcion.php';
        $stmt = $conn->prepare("SELECT * FROM tareas where id_tarea=? AND  id_usuario=?");
        $stmt->execute([$id, $_SESSION['user_id']]);
        $tarea = $stmt-fetch();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1><?= $tarea ? "Editar tarea": "Nueva tarea"?></h1>
    <form method="post" action="guardar_tarea.php">
        Titulo
        <input type="text" name="titulo">
        Descripcion
        <input type="textarea" name="descripcion">
        Prioridad:
        <select name="prio">
            <option value="todas">Todas</option>
            <option value="alta ">Alta</option>
            <option value="media">Media</option>
            <option value="baja ">Baja</option>
        </select>
        Estado:
        <select name="estado">
            <option value="todas">Todos</option>
            <option value="pendiente ">Pendiente</option>
            <option value="completada">Completada</option>
        </select>
        <button>Guardar</button>
    </form>
</body>
</html>