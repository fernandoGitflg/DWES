<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }
    require 'conexion.php';

    $prio= $_GET["prio"] ?? "todas";
    $estado= $_GET['estado']?? "todas";

    $valid_prios = ['alta','media','baja'];
    $valid_estados = ['pendiente','completada'];

    $sql = "SELECT * FROM tareas WHERE id_usuario";
    $params = [$_SESSION['user_id']];

    if($prio !=="todas" && in_array($prio,$valid_prios)){
        $sql="AND prioridad=?";
        $params[]=$prio;
    }
    if($prio !=="todas" && in_array($estado,$valid_estados)){
        $sql="AND estado=?";
        $params[]=$estado;
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $tareas= $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Listado de tareas</h1>
    <p>Usuario: <?=(isset($_SESSION['email']))?> | <a href="logout.php">Cerrar sesion</a>
    <?php if (isset($_COOKIE['saludo'])):?>
        <p> Bienvenido, <?= $_COOKIE['saludo']?></p>
    <?php endif;?>

    <form method="get">
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
        <button>Filtrar</button>
    </form>
    <a href="tarea_form.php">Nueva tarea</a>
    <?php if (!$tareas):?>
    <p>Sin tareas</p>
    <?php else: ?>
    <table border="1">
    <tr>
        <th>Titulo</th>
        <th>Prioridad</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Acciones</th>

    </tr>
    <?php foreach($tareas as $t): ?>
        <tr>
            <td><?= $t['titulo'] ?></td>
            <td><?= $t['prioridad'] ?></td>
            <td><?= $t['estado'] ?></td>
            <td><a href= "ver_tarea.php?id=<?= $t['id_tarea'] ?>">Ver/Editar</a></td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php endif; ?>
</body>
</html>