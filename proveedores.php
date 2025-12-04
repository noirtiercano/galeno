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

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <!-- HEADER -->
        <header class="top-header">
          <h2>Gestión de Proveedores y Compras</h2>
          <div class="header-actions">
            <span class="user-info">👤 Farmacéutico</span>
            <span class="date-time" id="dateTime"></span>
          </div>
        </header>

        <!-- CONTENT -->
        <div class="content-wrapper">
          <!-- SECCIÓN DE PROVEEDORES -->
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
                  <!-- <tr>
                    <td colspan="5" style="text-align: center; color: var(--color-gray-400)">
                      Cargando proveedores...
                    </td>
                  </tr> -->
                  <?php include('php/proveedores/mostrar_proveedores.php');?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- SECCIÓN DE ÓRDENES DE COMPRA -->
          <div class="dashboard-card">
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
    </div>

    <!-- MODAL: AGREGAR PROVEEDOR -->
    <div id="proveedorModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2 id="proveedorModalTitle">Nuevo Proveedor</h2>
          <button class="close-btn" onclick="closeModal('proveedorModal')">&times;</button>
        </div>
        <div class="modal-body" style="padding: 1rem">
          <form id="proveedorForm">
            <div class="form-group">
              <label>Nombre de Empresa *</label>
              <input type="text" id="proveedorNombre" required />
            </div>
            <div class="form-group">
              <label>Contacto</label>
              <input type="text" id="proveedorContacto" />
            </div>
            <div class="form-group">
              <label>Teléfono</label>
              <input type="tel" id="proveedorTelefono" />
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" id="proveedorEmail" />
            </div>
            <div class="form-group">
              <label>Dirección</label>
              <input type="text" id="proveedorDireccion" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline" onclick="closeModal('proveedorModal')">
            Cancelar
          </button>
          <button class="btn btn-primary" onclick="guardarProveedor()">
            Guardar
          </button>
        </div>
      </div>
    </div>

    <!-- MODAL: AGREGAR ORDEN -->
    <div id="ordenModal" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <h2>Nueva Orden de Compra</h2>
          <button class="close-btn" onclick="closeModal('ordenModal')">&times;</button>
        </div>
        <div class="modal-body" style="padding: 1rem">
          <form id="ordenForm">
            <div class="form-group">
              <label>Proveedor *</label>
              <select id="ordenProveedor" required></select>
            </div>
            <div class="form-group">
              <label>Producto *</label>
              <select id="ordenProducto" required></select>
            </div>
            <div class="form-group">
              <label>Cantidad *</label>
              <input type="number" id="ordenCantidad" required min="1" />
            </div>
            <div class="form-group">
              <label>Precio Unitario (€) *</label>
              <input type="number" id="ordenPrecio" required min="0" step="0.01" />
            </div>
            <div class="form-group">
              <label>Fecha Entrega Esperada</label>
              <input type="date" id="ordenFecha" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-outline" onclick="closeModal('ordenModal')">
            Cancelar
          </button>
          <button class="btn btn-primary" onclick="guardarOrden()">
            Crear Orden
          </button>
        </div>
      </div>
    </div>

    <script src="js/utils.js"></script>
    <script src="js/proveedores.js"></script>
  </body>
</html>
