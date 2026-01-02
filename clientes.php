

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
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo">
          <span style="font-size: 1.75rem">💊</span>
          <h1>GALENO</h1>
        </div>
      </div>

      <?php $pagina = "clientes";
      include('sidebar.php'); ?>

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
          <button class="btn btn-primary">
            ➕ <a href="php/clientes/form_nuevo_cliente.php">Nuevo Cliente</a>
          </button>
          
        <div class="filters-section">
                    <form action="" method="get">
                        <input type="text" id="searchInput" placeholder="🔍 Buscar producto..." class="search-input" name="busqueda" value="<?php if (isset($_GET['busqueda'])) {
                                                                                                                                                echo $_GET['busqueda'];
                                                                                                                                            } ?>">
                        <input type="submit" value="Buscar" name="btnBuscar">
                    </form>
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