<?php
session_start();
$_SESSION = array();
$_SESSION['flash'] = ['tipo' => 'exito', 'mensaje' => 'Has cerrado sesión correctamente.'];
header("Location: login.php");
exit();
?>