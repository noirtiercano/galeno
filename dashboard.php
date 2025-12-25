<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

// CALCULAR DATOS
$total_productos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM productos WHERE activo = 1"))['total'];

$total_entradas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(cantidad) as total FROM entradas"))['total'];
$total_salidas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(cantidad) as total FROM salidas"))['total'];
$stock_total = $total_entradas - $total_salidas;

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALENO - Sistema de Gestión Farmacéutica</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="app-container">
        <!-- SIDEBAR NAVIGATION -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="#10B981" />
                        <text x="16" y="22" font-size="18" font-weight="bold" fill="white" text-anchor="middle">G</text>
                    </svg>
                    <h1>GALENO</h1>
                </div>
            </div>

            <?php $pagina = "dashboard";
            include('sidebar.php'); ?>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- HEADER -->
            <header class="top-header">
                <h2>Dashboard - Sistema GALENO</h2>
                <div class="header-actions">
                    <span class="user-info"><?php include('php/header.php'); ?></span>
                    <span class="date-time" id="dateTime"></span>
                </div>
            </header>

            <!-- CONTENT AREA -->
            <div class="content-wrapper">
                <!-- ALERTAS Y RESUMEN -->
                <div class="dashboard-grid">

                    <!-- RESUMEN GENERAL -->
                    <div class="dashboard-card stats-card">
                        <h3>📊 Resumen General</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <span class="stat-label">Total Productos</span>
                                <span class="stat-value"><?php echo $total_productos; ?></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Stock Total</span>
                                <span class="stat-value"><?php echo $stock_total; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- ALERTAS DE STOCK -->
                    <div class="dashboard-card alert-card">
                        <h3>⚠️ Alertas de Stock Bajo</h3>
                        <div class="alert-list">
                            <?php include('php/dashboard/alertas_stock.php'); ?>
                        </div>
                    </div>

                    <!-- ALERTAS DE VENCIMIENTO -->
                    <!-- <div class="dashboard-card alert-card">
                        <h3>⏰ Alertas de Vencimiento</h3>
                        <div class="alert-list">
                            <?php include('php/dashboard/alertas_vencimiento.php'); ?>
                        </div>
                    </div> -->

                    <!-- VENTAS RECIENTES -->
                    <div class="dashboard-card sales-card">
                        <h3>💰 Ventas Recientes</h3>
                        <div class="sales-list">
                            <?php include('php/dashboard/ventas_recientes.php'); ?>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <script src="js/utils.js"></script>
    <script src="js/dashboard.js"></script>
</body>

</html>