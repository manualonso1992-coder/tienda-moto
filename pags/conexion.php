<?php
$host = "localhost";
$usuario = "root";
$password = "";
$bd = "tienda_moto";

$conexion = mysqli_connect($host, $usuario, $password, $bd);

if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}
?>