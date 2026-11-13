<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}


$sql_marcas = "SELECT * FROM marcas ORDER BY nombre ASC";
$res_marcas = mysqli_query($conexion, $sql_marcas);

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

$titulo_pagina = "Catálogo - Marketplace Motos";
$css_extra = "catalogo.css";
require_once 'includes/header.php';

?>
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
                    $nombre_imagen = !empty($moto['imagen']) ? $moto['imagen'] : 'Moto_Default.webp';
                    $ruta_fisica = __DIR__ . '/imagenes_catalogo/' . $nombre_imagen;

                    if (file_exists($ruta_fisica)) {
                        $imagen_final = 'imagenes_catalogo/' . $nombre_imagen;
                    } else {
                        $imagen_final = 'imagenes_catalogo/Moto_Default.webp';
                    }
            ?>
                    <article class="moto-card">
                        <div class="moto-img-container">
                            <img src="<?php echo htmlspecialchars($imagen_final); ?>" 
                                 alt="<?php echo htmlspecialchars($moto['modelo']); ?>">
                        </div>

                        <span class="marca-badge"><?php echo htmlspecialchars($moto['marca_nombre']); ?></span>
                        <h3><?php echo htmlspecialchars($moto['modelo']); ?></h3>
                        <p class="precio">USD $<?php echo number_format($moto['precio'], 2); ?></p>
                        <a href="detalle.php?id=<?php echo $moto['id']; ?>" class="btn-ver-detalle">Ver Detalle</a>
                    </article>
            <?php 
                }
            } 
            ?>
            </section>
    </main> 
    
    <?php require_once 'includes/footer.php'; ?>