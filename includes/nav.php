<header class="header-global">
    <?php if (isset($_SESSION['usuario_id'])): ?>
        <h1>¡Bienvenido/a, <?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?>! </h1>
        <nav style="display: flex; gap: 15px; align-items: center;">
            <a href="<?php echo $ruta_raiz; ?>index.php" style="text-decoration: none; font-weight: bold; color: #2c3e50;">Catálogo</a>
            <a href="<?php echo $ruta_raiz; ?>pags/carrito.php" style="text-decoration: none; font-weight: bold; color: #007bff;">
                Ver Carrito (<?php echo isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0; ?>)
            </a>
            <a href="<?php echo $ruta_raiz; ?>pags/logout.php" class="btn-logout">Cerrar Sesión</a>
        </nav>
    <?php else: ?>
        <h1>Marketplace Motos</h1>
        <nav style="display: flex; gap: 15px; align-items: center;">
            <a href="<?php echo $ruta_raiz; ?>pags/login.php" style="text-decoration: none; font-weight: bold; color: #007bff;">Iniciar Sesión</a>
            <a href="<?php echo $ruta_raiz; ?>pags/registro.php" style="text-decoration: none; font-weight: bold; color: #2c3e50;">Registrarse</a>
        </nav>
    <?php endif; ?>
</header>