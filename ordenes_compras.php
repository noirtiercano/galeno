<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GALENO - Órdenes de Compra</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="app-container">
      <!-- SIDEBAR -->
      <aside class="sidebar">
        <div class="sidebar-header">
          <div class="logo">
            <span style="font-size: 1.75rem"></span>
            <h1>GALENO</h1>
          </div>
        </div>

      <?php 
      session_start();
      $pagina = "ordenes_compras";
      include('sidebar.php'); ?>

        <div class="sidebar-footer">
          <a href="log_out.php" class="logout-btn">Cerrar sesión</a>
        </div>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <!-- HEADER -->
        <header class="top-header">
          <h2>Gestión de Órdenes de Compras</h2>
          <div class="header-actions">
            <span class="user-info"><?php include('php/header.php'); ?></span>
            <span class="date-time" id="dateTime"></span>
          </div>
        </header>

        <div class="content-wrapper">
          <!-- SECCIÓN DE ÓRDENES DE COMPRA -->
          <div class="dashboard-card">
            <h3>Órdenes de Compra</h3>
            <button class="btn btn-primary" style="margin-bottom: 1rem">
              <a href="php/ordenes_compras/form_nueva_orden.php" style="color: white; text-decoration: none;">📋 Nueva Orden</a>
            </button>

            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Orden ID</th>
                    <th>Proveedor</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php include('php/ordenes_compras/mostrar_ordenes.php'); ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>

    <script src="js/utils.js"></script>
  </body>
</html>