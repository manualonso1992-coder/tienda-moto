<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT m.*, b.nombre AS marca_nombre 
        FROM motos m 
        JOIN marcas b ON m.marca_id = b.id 
        WHERE m.id = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$moto = mysqli_fetch_assoc($resultado);

if (!$moto) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($moto['marca_nombre'] . ' ' . $moto['modelo']); ?> - Detalle</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="detalle.css">
</head>
<body>
    <header>
        <h1>¡Bienvenido/a, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>! 👋</h1>
        <a href="logout.php">Cerrar Sesión</a>
    </header>

    <main>
        <a href="index.php" class="btn-volver">← Volver al Catálogo</a>

        <article class="tarjeta-detalle">
            <span class="marca-tag"><?php echo htmlspecialchars($moto['marca_nombre']); ?></span>
            
            <h1><?php echo htmlspecialchars($moto['modelo']); ?></h1>
            
            <p><strong>Cilindrada:</strong> <?php echo htmlspecialchars($moto['cilindrada']); ?></p>
            
            <p><strong>Descripción:</strong></p>
            <p><?php echo htmlspecialchars($moto['descripcion']); ?></p>
            
            <h2 class="precio-texto">
                Precio: USD $<?php echo number_format($moto['precio'], 2); ?>
            </h2>

            <hr>

            <button type="button" class="btn-agregar">
                Agregar al Carrito
            </button>
        </article>
    </main>
</body>
</html>