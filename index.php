<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
</head>
    <body>
        <h1>¡Bienvenido/a, 
            <?php 
            echo htmlspecialchars($_SESSION['usuario_nombre'] ?? $_SESSION['nombre'] ?? 'Usuario'); 
            ?>! </h1>

            <p>Iniciaste sesión con éxito.</p>
            
            <a href="logout.php">Cerrar Sesión</a>
            
    </body>
</html>