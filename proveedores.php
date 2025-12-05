<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GALENO - Gestión de Proveedores</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="app-container">
      <!-- SIDEBAR -->
      <aside class="sidebar">
        <div class="sidebar-header">
          <div class="logo">
            <span style="font-size: 1.75rem">💊</span>
            <h1>GALENO</h1>
          </div>
        </div>

      <?php $pagina = "proveedores";
      include('sidebar.php'); ?>

        <div class="sidebar-footer">
          <a href="log_out.php" class="logout-btn">Cerrar sesión</a>
          <!-- <button class="logout-btn" onclick="confirmarCierre()">
            🚪 Cerrar Sesión
          </button> -->
        </div>
      </aside>


      <main class="main-content">

        <header class="top-header">
          <h2>Gestión de Proveedores y Compras</h2>
          <div class="header-actions">
            <span class="user-info"><?php include('php/header.php'); ?></span>
            <span class="date-time" id="dateTime"></span>
          </div>
        </header>


        <div class="content-wrapper">

          <div class="dashboard-card" style="margin-bottom: 2rem">
            <h3>Proveedores Registrados</h3>
            <button class="btn btn-primary" onclick="abrirModalAgregarProveedor()" style="margin-bottom: 1rem">
              ➕<a href="php/proveedores/form_nuevo_proveedor.php">Nuevo Proveedor</a>
            </button>

            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody id="proveedoresTable">
                  <?php include('php/proveedores/mostrar_proveedores.php');?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- SECCIÓN DE ÓRDENES DE COMPRA -->
          <!-- <div class="dashboard-card">
            <h3>Órdenes de Compra</h3>
            <button class="btn btn-primary" onclick="abrirModalAgregarOrden()" style="margin-bottom: 1rem">
              📋 Nueva Orden
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
                <tbody id="ordenesTable">
                  <tr>
                    <td colspan="8" style="text-align: center; color: var(--color-gray-400)">
                      Cargando órdenes...
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div> -->


    <script src="js/utils.js"></script>
    <script src="js/proveedores.js"></script>
  </body>
</html>
