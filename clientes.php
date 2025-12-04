

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GALENO - Gestión de Clientes</title>
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

      <?php $pagina = "clientes";
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
        <h2>Gestión de Clientes</h2>
        <div class="header-actions">
          <span class="user-info">👤 Farmacéutico</span>
          <span class="date-time" id="dateTime"></span>
        </div>
      </header>

      <!-- CONTENT -->
      <div class="content-wrapper">
        <div style="display: flex; gap: 2rem; margin-bottom: 2rem">
          <button class="btn btn-primary" onclick="abrirModalAgregarCliente()">
            ➕ <a href="php/clientes/form_nuevo_cliente.php">Nuevo Cliente</a>
          </button>
          <input
            type="text"
            id="searchCliente"
            placeholder="Buscar cliente..."
            style="flex: 1; max-width: 300px"
            onkeyup="filtrarClientes()" />
        </div>

        <!-- TABLA DE CLIENTES -->
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="clientesTable">
              <?php include('php/clientes/mostrar_clientes.php');?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- MODAL: AGREGAR/EDITAR CLIENTE -->
  <div id="clienteModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <h2 id="clienteModalTitle">Nuevo Cliente</h2>
        <button class="close-btn" onclick="closeModal('clienteModal')">&times;</button>
      </div>
      <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm">
          <div class="form-group">
            <label>Nombre *</label>
            <input type="text" id="clienteNombre" required />
          </div>
          <div class="form-group">
            <label>Teléfono</label>
            <input type="tel" id="clienteTelefono" />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="clienteEmail" />
          </div>
          <div class="form-group">
            <label>Descuento Personalizado (%)</label>
            <input type="number" id="clienteDescuento" min="0" max="100" value="0" />
          </div>
          <div class="form-group">
            <label>Notas</label>
            <textarea id="clienteNotas" placeholder="Información adicional..."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('clienteModal')">
          Cancelar
        </button>
        <button class="btn btn-primary" onclick="guardarCliente()">
          Guardar
        </button>
      </div>
    </div>
  </div>

  <!-- MODAL: HISTORIAL DE COMPRAS -->
  <div id="historialModal" class="modal">
    <div class="modal-content" style="max-width: 700px">
      <div class="modal-header">
        <h2>Historial de Compras</h2>
        <button class="close-btn" onclick="closeModal('historialModal')">&times;</button>
      </div>
      <div id="historialContent" style="padding: 1rem; max-height: 400px; overflow-y: auto"></div>
      <div class="modal-footer">
        <button class="btn btn-outline" onclick="closeModal('historialModal')">
          Cerrar
        </button>
      </div>
    </div>
  </div>

  <script src="js/utils.js"></script>
  <script src="js/clientes.js"></script>
</body>

</html>
?>