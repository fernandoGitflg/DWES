<?php 
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }
    require 'conexion.php';

    $id= $_POST['id'] ?? null;
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $prioridad = ($_POST['prioridad']);
    $estado = ($_POST['estado']);

    $valid_prios = ['alta','media','baja'];
    $valid_estados = ['pendiente','completada'];

    if($titulo === "") die("El tituloo es obligatorio");
    if(!in_array($prio,$valid_prios))die("Prioridad no valida");
    if(!in_array($estados,$valid_estados))die("Estado no valido");

    $stmt = $conn->prepare("SELECT id_tarea FROM tareas WHERE id_usuario=? AND titulo=?");
    $stmt->execute([$_SESSION['user_id'],$titulo]);
    $existe = $stmt->fetch();

    if($existe && !$id){
        $stmt= $conn->prepare("UPDATE tarea SET descripcion?=. prioridad=?, estado=?,fecha_creacion=CURDATE() WHERE id_tarea=?");
        $stmt->execute([$descripcion,$prio,$estado,$existe['id_tarea']]);
    }//faltan dos casos
?>
