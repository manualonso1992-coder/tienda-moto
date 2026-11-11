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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Tienda Moto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <main>
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($error)) { ?>
        <p class="mensaje-error"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form action="login.php" method="POST">
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required 
                   value="
                   <?php 
                   echo htmlspecialchars($_COOKIE['email_recordado'] ?? ''); 
                   ?>
                   ">
        </div>

        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label>
                <input type="checkbox" name="recordar" 
                       <?php echo isset($_COOKIE['email_recordado']) ? 'checked' : ''; 
                       ?>
                       > 
            </label>
        </div>

        <button type="submit">Ingresar</button>
    </form>
</main>

</body>
</html>