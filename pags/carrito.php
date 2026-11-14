<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['accion']) && $_GET['accion'] === 'vaciar') {
    unset($_SESSION['carrito']);
    header("Location: carrito.php");
    exit();
}

if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $id_eliminar = (int)$_GET['id'];
    unset($_SESSION['carrito'][$id_eliminar]);
    header("Location: carrito.php");
    exit();
}

$items = [];
$total_general = 0;

if (!empty($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
    $ids = array_map('intval', array_keys($_SESSION['carrito']));
    $ids_validos = array_filter($ids, function($id) { return $id > 0; });

    if (!empty($ids_validos)) {
        $placeholders = implode(',', array_fill(0, count($ids_validos), '?'));
        $types = str_repeat('i', count($ids_validos));

        $sql = "SELECT m.*, b.nombre AS marca_nombre 
                FROM motos m 
                JOIN marcas b ON m.marca_id = b.id 
                WHERE m.id IN ($placeholders)";

        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$ids_validos);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($resultado)) {
            $id_moto = (int)$row['id'];
            $cantidad = isset($_SESSION['carrito'][$id_moto]) ? (int)$_SESSION['carrito'][$id_moto] : 1;
            if ($cantidad < 1) $cantidad = 1;

            $subtotal = $row['precio'] * $cantidad;
            $total_general += $subtotal;

            $nombre_img = !empty($row['imagen']) ? $row['imagen'] : 'Moto_Default.webp';
            $ruta_fisica = __DIR__ . '/../imagenes_catalogo/' . $nombre_img;
            $img_final = file_exists($ruta_fisica) ? '/..imagenes_catalogo/' . $nombre_img : 'imagenes_catalogo/Moto_Default.webp';

            $nombre_mostrar = $row['modelo'];
            if (stripos($row['modelo'], $row['marca_nombre']) === false) {
                $nombre_mostrar = $row['marca_nombre'] . ' ' . $row['modelo'];
            }

            $items[] = [
                'id'       => $id_moto,
                'nombre'   => $nombre_mostrar,
                'precio'   => $row['precio'],
                'cantidad' => $cantidad,
                'subtotal' => $subtotal,
                'imagen'   => $img_final
            ];
        }
    }
}

$titulo_pagina = "Tu Carrito de Compras";
$css_extra = "carrito.css";
require_once '../includes/header.php';
?>

    <main class="carrito-wrapper">
        <h2>Tu Carrito de Compras</h2>

        <?php if (empty($items)): ?>
            <div class="carrito-vacio">
                <p>El carrito está vacío.</p>
                <a href="index.php" class="btn-nav">Volver al catálogo para agregar motos</a>
            </div>
        <?php else: ?>
            
            <div class="carrito-lista">
                <?php foreach ($items as $item): ?>
                    <article class="item-card">
                        <div class="item-img-box">
                            <img src="<?php echo htmlspecialchars($item['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['nombre']); ?>">
                        </div>

                        <div class="item-detalles">
                            <p class="dato-row">
                                <span class="label">Moto:</span>
                                <strong class="val-nombre"><?php echo htmlspecialchars($item['nombre']); ?></strong>
                            </p>
                            <p class="dato-row">
                                <span class="label">Precio unitario:</span>
                                <span>USD $<?php echo number_format($item['precio'], 2); ?></span>
                            </p>
                            <p class="dato-row">
                                <span class="label">Cantidad:</span>
                                <span><?php echo $item['cantidad']; ?></span>
                            </p>
                            <p class="dato-row">
                                <span class="label">Subtotal:</span>
                                <strong class="val-subtotal">USD $<?php echo number_format($item['subtotal'], 2); ?></strong>
                            </p>
                        </div>

                        <div class="item-accion">
                            <a href="carrito.php?accion=eliminar&id=<?php echo $item['id']; ?>" class="btn-eliminar">Quitar</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="carrito-resumen">
                <div class="total-box">
                    <span>Total General:</span>
                    <strong>USD $<?php echo number_format($total_general, 2); ?></strong>
                </div>
                <div class="acciones-carrito">
                    <a href="carrito.php?accion=vaciar" class="btn-vaciar">Vaciar Carrito</a>
                    <button class="btn-finalizar" onclick="alert('¡Gracias por tu compra!')">Finalizar Compra</button>
                </div>
            </div>

        <?php endif; ?>
    </main>

<?php require_once '../includes/footer.php'; ?>