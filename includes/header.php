<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ruta_raiz = (basename(dirname($_SERVER['PHP_SELF'])) === 'pags') ? '../' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($titulo_pagina ?? 'Tienda Moto'); ?></title>
    <link rel="stylesheet" href="<?php echo $ruta_raiz; ?>css/style.css?v=10.0">
    <?php if (!empty($css_extra)): ?>
        <link rel="stylesheet" href="<?php echo $ruta_raiz; ?>css/<?php echo htmlspecialchars($css_extra); ?>?v=10.0">
    <?php endif; ?>
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <a href="<?php echo $ruta_raiz; ?>index.php" class="site-logo">Tienda Moto</a>
        </div>
    </header>

<?php if (!isset($ocultar_nav) || !$ocultar_nav): ?>
    <?php require_once __DIR__ . '/nav.php'; ?>
<?php endif; ?>

<?php if (isset($_SESSION['flash'])): ?>
    <div style="max-width: 900px; margin: 0 auto 20px auto; padding: 12px 20px; border-radius: 6px; font-weight: bold; text-align: center;
        background-color: <?php echo ($_SESSION['flash']['tipo'] === 'error') ? '#f8d7da' : '#d4edda'; ?>;
        color: <?php echo ($_SESSION['flash']['tipo'] === 'error') ? '#721c24' : '#155724'; ?>;
        border: 1px solid <?php echo ($_SESSION['flash']['tipo'] === 'error') ? '#f5c6cb' : '#c3e6cb'; ?>;">
        <?php echo htmlspecialchars($_SESSION['flash']['mensaje']); ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>