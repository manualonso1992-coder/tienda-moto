<?php

$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "catalogo_motos"; 
$conexion = mysqli_connect($host, $usuario, $password, $base_datos);

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8mb4");
?>