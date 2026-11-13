<?php
require_once 'conexion.php';

$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre_completo = trim($_POST['nombre_completo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password_ingresada = trim($_POST['password'] ?? '');

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
            $password_encriptada = password_hash($password_ingresada, PASSWORD_DEFAULT);
            $sql_insert = "INSERT INTO usuarios (nombre_completo, email, password) VALUES (?, ?, ?)";
            $stmt_insert = mysqli_prepare($conexion, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "sss", $nombre_completo, $email, $password_encriptada);
            
            if (mysqli_stmt_execute($stmt_insert)) {
                $mensaje_exito = "¡Usuario registrado correctamente! Iniciá sesión.";
            } else {
                $mensaje_error = "Hubo un error al registrar el usuario. Vuelva a intentarlo.";
            }
        }
    }
}

$titulo_pagina = "Registro - Catálogo de Motos";
$ocultar_nav = true;
require_once 'includes/header.php';

?>
    <div class="auth-container">
        <h2>Registro de Usuario</h2>

        <?php if (!empty($mensaje_error)): ?>
            <p style="color: #dc3545; margin-bottom: 15px; text-align: center; font-weight: bold;">
                <?php echo htmlspecialchars($mensaje_error); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($mensaje_exito)): ?>
            <p style="color: #28a745; margin-bottom: 15px; text-align: center; font-weight: bold;">
                <?php echo htmlspecialchars($mensaje_exito); ?>
            </p>
        <?php endif; ?>

        <form action="registro.php" method="POST">
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" required>
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-auth">Crear Cuenta</button>
        </form>

        <div class="registro-login-link">
            <p>¿Ya tenés una cuenta?</p>
            <a href="login.php" class="btn-secundario">Iniciar Sesión</a>
        </div>
    </div>

</body>
</html>