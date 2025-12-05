

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


    <main class="main-content">

      <header class="top-header">
        <h2>Gestión de Clientes</h2>
        <div class="header-actions">
          <span class="user-info"><?php include('php/header.php'); ?></span>
          <span class="date-time" id="dateTime"></span>
        </div>
      </header>


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


        <div class="table-container">
          <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>

                <?php if ($rol_usuario == 'admin') { ?>
                    <th>Acciones</th>
                <?php } ?>
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

  <script src="js/utils.js"></script>
  <script src="js/clientes.js"></script>
</body>

</html>
?>