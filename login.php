<?php
session_start();
require_once 'conexion.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $recordar = isset($_POST['recordar']);

    if (empty($email) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $sql = "SELECT id, nombre_completo, password FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);

            if ($usuario = mysqli_fetch_assoc($resultado)) {
                if (password_verify($password, $usuario['password'])) {
                    session_regenerate_id(true);

                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre_completo'];
                    $_SESSION['flash'] = ['tipo' => 'exito', 'mensaje' => '¡Bienvenido/a de nuevo, ' . $usuario['nombre_completo'] . '!'];

                    if ($recordar) {
                        setcookie('email_recordado', $email, time() + (86400 * 30), "/");
                    } else {
                        setcookie('email_recordado', '', time() - 3600, "/");
                    }
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Credenciales incorrectas.";
                }
            } else {
                $error = "Credenciales incorrectas.";
            }

            mysqli_stmt_close($stmt);
        } else {
            $error = "Error al procesar la solicitud.";
        }
    }
}

$titulo_pagina = "Iniciar Sesión - Tienda Moto";
$ocultar_nav = true;
require_once 'includes/header.php';
?>

<div class="auth-container">
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($error)): ?>
        <p style="color: #dc3545; margin-bottom: 15px; text-align: center; font-weight: bold;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required 
                   value="<?php echo htmlspecialchars($_COOKIE['email_recordado'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" id="recordar" name="recordar" 
                   <?php echo isset($_COOKIE['email_recordado']) ? 'checked' : ''; ?>>
            <label for="recordar" style="font-weight: normal; margin: 0;">Recordarme</label>
        </div>

        <button type="submit" class="btn-auth">Ingresar</button>
    </form>

    <a href="registro.php" class="auth-link">¿No tienes cuenta? Regístrate aquí</a>
</div>

<?php require_once 'includes/footer.php'; ?>