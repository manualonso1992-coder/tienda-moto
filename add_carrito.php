<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_POST['id'] ?? null;
$cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT) || $cantidad < 1) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_SESSION['carrito'][$id])) {
    $_SESSION['carrito'][$id] += $cantidad;
} else {
    $_SESSION['carrito'][$id] = $cantidad;
}

header("Location: carrito.php");
exit();

?>