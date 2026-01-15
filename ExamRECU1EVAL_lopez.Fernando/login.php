<?php
    session_start();
    require 'conexion.php';
    $msg =$_GET['msg'] ?? "";
    $error="";

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $email=trim($_POST['email'] ?? "");
        $pass=trim($_POST['password'] ?? "");
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $error="Correo no valido";
        }else if($pass=""){
            $error="La contraseña no puede estar vacia";
        } else{ 
            $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email=?");
            $stmt-> execute([$email]);
            $u= $stmt->fetch(PDO::FETCH_ASSOC);

            if($u && $u['password'] === $pass){
                $_SESSION['user_id']= $u['id_usuario'];
                $_SESSION['email']= $u['email'];
                setcookie("saludo",$u['nombre'],time ()*3600*24*30);

                header("Location:tareas.php");
                exit;
            }else{
                $error="Credenciales incorrectas";
            }
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginEx</title>
</head>
<body>
    <h1>Login</h1>
    <?php if($msg): ?><p style="color:green"><?= $msg ?><?php endif; ?>
    <?php if($error): ?><p style="color:red"><?= $error ?><?php endif; ?>

    <form method="post">
        <label for="email">Correo:</label>
        <input type="email" name="email"><br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password"><br>
        <input type="submit" name="enviar" value="Enviar">
    </form>

</body>
</html>