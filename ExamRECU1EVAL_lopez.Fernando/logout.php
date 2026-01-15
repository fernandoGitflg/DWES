<?php
session_start();
session_destroy();
setcookie("saludo","",time()-3600);
header("Location: login.php?msg=Sesion cerrada correctamente"); 
?>