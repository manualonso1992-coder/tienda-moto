<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_completo = trim($_POST['nombre_completo']);
    $email = trim($_POST['email']);
    $password_ingresada = trim($_POST['password']);

    if (empty($nombre_completo) || empty($email) || empty($password_ingresada)) {
        $mensaje_error = "Todos los campos son obligatorios.";
    } else {
        $sql_check = "SELECT id FROM usuarios WHERE email = ?";
        $stmt_check = mysqli_prepare($conexion, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $mensaje_error = "El correo electrónico ya está registrado.";
        } else {
            // 2. Encriptar e insertar el nuevo usuario
            $password_encriptada = password_hash($password_ingresada, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO usuarios (nombre_completo, email, password) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($conexion, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "sss", $nombre_completo, $email, $password_encriptada);
            
            if (mysqli_stmt_execute($stmt_insert)) {
                $mensaje_exito = "¡Usuario registrado correctamente! Inicie sesión.";
            } else {
                $mensaje_error = "Hubo un error al registrar el usuario. Vuelva a intentarlo.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Catálogo de Motos</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

    <h2>Registro de Usuario</h2>
    <?php if (!empty($mensaje_error)) { ?>
        <p class="mensaje error"><?php echo $mensaje_error; ?></p>
    <?php } ?>

    <?php if (!empty($mensaje_exito)) { ?>
        <p class="mensaje exito"><?php echo $mensaje_exito; ?></p>
    <?php } ?>

    <form action="registro.php" method="POST">
        <label>Nombre Completo:</label>
        <input type="text" name="nombre_completo">
        
        <label>Correo Electrónico:</label>
        <input type="email" name="email">
        
        <label>Contraseña:</label>
        <input type="password" name="password">
        
        <button type="submit">Crear Cuenta</button>
    </form>

</body>
</html>