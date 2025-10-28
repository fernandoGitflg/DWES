<?php
session_start();
session_destroy();

setcookie('remember_email', '', time() - 3600, '/', '', true, true);

header("Location: login.php");
exit;
