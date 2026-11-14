<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['moto_id'])) {
    $moto_id = (int)$_POST['moto_id'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
    
    if ($cantidad < 1) {
        $cantidad = 1;
    }

    if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    if (isset($_SESSION['carrito'][$moto_id])) {
        $_SESSION['carrito'][$moto_id] += $cantidad;
    } else {
        $_SESSION['carrito'][$moto_id] = $cantidad;
    }

   $_SESSION['flash'] = ['tipo' => 'exito', 'mensaje' => '¡Motocicleta agregada al carrito correctamente!'];
    session_write_close();
    header("Location: carrito.php");
    exit();
} else {
    header("Location: ../index.php");
    exit();
}
?>