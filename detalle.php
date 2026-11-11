<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

// 1. Definimos la imagen o la por defecto
$nombre_imagen = !empty($moto['imagen']) ? $moto['imagen'] : 'Moto_Default.webp';

// 2. Ruta física absoluta para validar que el archivo exista en el disco
$ruta_fisica = __DIR__ . '/imagenes_catalogo/' . $nombre_imagen;

// 3. Asignación correcta de la ruta para el navegador
if (file_exists($ruta_fisica)) {
    $imagen_final = 'imagenes_catalogo/' . $nombre_imagen;
} else {
    $imagen_final = 'imagenes_catalogo/Moto_Default.webp';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($moto['modelo']); ?> - Detalle</title>
    <link rel="stylesheet" href="style.css?v=1.2">
    <link rel="stylesheet" href="detalle.css?v=1.2">
</head>
<body>

    <header class="header-global">
        <div class="nav-links">
            <a href="index.php" class="btn-nav">← Volver al Catálogo</a>
            <a href="carrito.php" class="btn-nav">Ver Carrito</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </header>

    <main class="detalle-wrapper">
        <article class="detalle-card">
            
            <div class="detalle-img-container">
                <img src="<?php echo htmlspecialchars($imagen_final); ?>" 
                     alt="<?php echo htmlspecialchars($moto['modelo']); ?>">
            </div>

            <div class="detalle-info-container">
                <span class="marca-badge"><?php echo htmlspecialchars($moto['marca_nombre']); ?></span>
                <h2><?php echo htmlspecialchars($moto['modelo']); ?></h2>
                
                <?php if (!empty($moto['cilindrada'])): ?>
                    <p class="detalle-item"><strong>Cilindrada:</strong> <?php echo htmlspecialchars($moto['cilindrada']); ?> cc</p>
                <?php endif; ?>

                <p class="detalle-item">
                    <strong>Descripción:</strong><br>
                    <?php echo htmlspecialchars($moto['descripcion'] ?? 'Sin descripción disponible.'); ?>
                </p>

                <p class="detalle-precio">Precio: USD $<?php echo number_format($moto['precio'], 2); ?></p>

                <form action="add_carrito.php" method="POST" class="form-agregar-carrito">
                    <input type="hidden" name="moto_id" value="<?php echo $moto['id']; ?>">
                    <div class="cantidad-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" value="1" min="1" max="10" required>
                    </div>
                    <button type="submit" class="btn-agregar">Agregar al Carrito</button>
                </form>
            </div>

        </article>
    </main>

</body>
</html>