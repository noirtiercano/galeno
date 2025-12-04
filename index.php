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

            <?php $pagina = "index";
            include('sidebar.php'); ?>

            <div class="sidebar-footer">
                <a href="log_out.php" class="logout-btn">Cerrar sesión</a>
                <!-- <button class="logout-btn" onclick="confirmarCierre()">
            🚪 Cerrar Sesión
          </button> -->
            </div>
        </nav>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- HEADER -->
            <header class="top-header">
                <h2>Dashboard - Sistema GALENO</h2>
                <div class="header-actions">
                    <span class="user-info">Admin</span>
                    <span class="date-time" id="dateTime"></span>
                </div>
            </header>

            <!-- CONTENT AREA -->
            <div class="content-wrapper">
                <!-- ALERTAS Y RESUMEN -->
                <div class="dashboard-grid">
                    <!-- Tarjeta de Alertas de Stock -->
                    <div class="dashboard-card alert-card">
                        <h3>⚠️ Alertas de Stock Bajo</h3>
                        <div class="alert-list" id="alertasStock">
                            <p class="empty-state">No hay alertas de stock</p>
                        </div>
                    </div>

                    <!-- Tarjeta de Alertas de Vencimiento -->
                    <div class="dashboard-card alert-card">
                        <h3>⏰ Alertas de Vencimiento</h3>
                        <div class="alert-list" id="alertasVencimiento">
                            <p class="empty-state">No hay productos próximos a vencer</p>
                        </div>
                    </div>

                    <!-- Estadísticas Generales -->
                    <div class="dashboard-card stats-card">
                        <h3>📊 Resumen General</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <span class="stat-label">Total Productos</span>
                                <span class="stat-value" id="totalProductos"></span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Stock Total</span>
                                <span class="stat-value" id="totalStock">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Productos Críticos</span>
                                <span class="stat-value critical" id="productosCriticos">0</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label">Próximos a Vencer</span>
                                <span class="stat-value warning" id="proximosVencer">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ventas Recientes -->
                    <div class="dashboard-card sales-card">
                        <h3>💰 Ventas Recientes</h3>
                        <div class="sales-list" id="ventasRecientes">
                            <p class="empty-state">No hay ventas registradas</p>
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