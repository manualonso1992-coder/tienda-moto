<?php
session_start();
require_once 'conexion.php';

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener marcas para los botones de filtro
$sql_marcas = "SELECT * FROM marcas ORDER BY nombre ASC";
$res_marcas = mysqli_query($conexion, $sql_marcas);

// Filtrado por marca si viene por GET
$marca_id = isset($_GET['marca_id']) ? (int)$_GET['marca_id'] : 0;

if ($marca_id > 0) {
    $sql_motos = "SELECT m.*, b.nombre AS marca_nombre 
                  FROM motos m 
                  JOIN marcas b ON m.marca_id = b.id 
                  WHERE m.marca_id = ? 
                  ORDER BY m.id DESC";
    $stmt = mysqli_prepare($conexion, $sql_motos);
    mysqli_stmt_bind_param($stmt, "i", $marca_id);
    mysqli_stmt_execute($stmt);
    $res_motos = mysqli_stmt_get_result($stmt);
} else {
    $sql_motos = "SELECT m.*, b.nombre AS marca_nombre 
                  FROM motos m 
                  JOIN marcas b ON m.marca_id = b.id 
                  ORDER BY m.id DESC";
    $res_motos = mysqli_query($conexion, $sql_motos);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo - Marketplace Motos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="catalogo.css">
</head>
<body>

    
    <header class="header-global">
        <h1>¡Bienvenido/a, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?>! 👋</h1>
        <nav style="display: flex; gap: 15px; align-items: center;">
            <a href="carrito.php" style="text-decoration: none; font-weight: bold; color: #007bff;">Ver Carrito</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <h2>Catálogo de Motocicletas</h2>
        
        <div class="filtros-marcas">
            <a href="index.php" class="btn-filtro <?php echo ($marca_id === 0) ? 'activo' : ''; ?>">Todas</a>
            <?php 
            while ($marca = mysqli_fetch_assoc($res_marcas)) { 
                $activa = ($marca_id === (int)$marca['id']) ? 'activo' : '';
            ?>
                <a href="index.php?marca_id=<?php echo $marca['id']; ?>" class="btn-filtro <?php echo $activa; ?>">
                    <?php echo htmlspecialchars($marca['nombre']); ?>
                </a>
            <?php 
            } 
            ?>
        </div>

        <section class="motos-grid">
            <?php 
            if (mysqli_num_rows($res_motos) > 0) {
                while ($moto = mysqli_fetch_assoc($res_motos)) { 
            ?>
                    <article class="moto-card">
                        <span class="marca-badge"><?php echo htmlspecialchars($moto['marca_nombre']); ?></span>
                        <h3><?php echo htmlspecialchars($moto['modelo']); ?></h3>
                        <p class="precio">USD $<?php echo number_format($moto['precio'], 2); ?></p>
                        <a href="detalle.php?id=<?php echo $moto['id']; ?>" class="btn-ver-detalle">Ver Detalle</a>
                    </article>
            <?php 
                }
            } else { 
            ?>
                <p>No se encontraron motocicletas disponibles para esta marca.</p>
            <?php 
            } 
            ?>
        </section>
    </main>

</body>
</html>