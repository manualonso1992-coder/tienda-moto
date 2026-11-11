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

$items = [];
$total_general = 0;

if (!empty($_SESSION['carrito'])) {
    $ids = array_keys($_SESSION['carrito']);
    
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $types = str_repeat('i', count($ids));

    $sql = "SELECT m.*, b.nombre AS marca_nombre 
            FROM motos m 
            JOIN marcas b ON m.marca_id = b.id 
            WHERE m.id IN ($placeholders)";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$ids);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultado)) {
        $cantidad = $_SESSION['carrito'][$row['id']];
        $subtotal = $row['precio'] * $cantidad;
        $total_general += $subtotal;

        $items[] = [
            'id'       => $row['id'],
            'marca'    => $row['marca_nombre'],
            'modelo'   => $row['modelo'],
            'precio'   => $row['precio'],
            'cantidad' => $cantidad,
            'subtotal' => $subtotal
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras - Marketplace</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/carrito.css">
</head>
<body>
    <header class="header-global">
        <h1>¡Bienvenido/a, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>! 👋</h1>
        <nav>
            <a href="index.php" style="margin-right: 15px; text-decoration: none; font-weight: bold; color: #007bff;">Catálogo</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <h2>Tu Carrito de Compras</h2>

        <?php if (empty($items)): ?>
            <p style="margin-top: 15px;">El carrito está vacío. <a href="index.php">Volver al catálogo para agregar motos</a>.</p>
        <?php else: ?>
            <table class="carrito-tabla">
                <thead>
                    <tr>
                        <th>Moto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><strong>
                                <?php
                                    echo htmlspecialchars($item['marca'] . ' ' . $item['modelo']); 
                                ?>
                            </strong></td>
                            <td>USD $
                                <?php
                                     echo number_format($item['precio'], 2); 
                                ?>
                            </td>
                            <td><?php
                                     echo $item['cantidad']; 
                                ?>
                            </td>
                            <td>USD $
                                <?php
                                     echo number_format($item['subtotal'], 2); 
                                ?>
                            </td>
                        </tr>
                    <?php 
                        endforeach;
                    ?>
                </tbody>
            </table>

            <div class="carrito-acciones">
                <a href="carrito.php?accion=vaciar" class="btn-vaciar">Vaciar Carrito</a>
                <div class="total-contenedor">
                    Total: USD $
                    <?php
                         echo number_format($total_general, 2);
                    ?>
                </div>
            </div>
        <?php 
            endif;
        ?>
    </main>
</body>
</html>