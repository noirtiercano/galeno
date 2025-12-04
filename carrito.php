<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");
$total_compra = 0;
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GALENO - Punto de Venta</title>
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

      <?php $pagina = "carrito";
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
        <h2>Carrito</h2>
        <div class="header-actions">
          <span class="user-info">👤 Farmacéutico</span>
          <span class="date-time" id="dateTime"></span>
        </div>
      </header>

      <div class="table-container">
        <table id="productosTable">
          <thead>
            <tr>
              <th>Código</th>
              <th>Producto</th>
              <th>Precio UNIT</th>
              <th>Cantidad</th>
              <th>Subtotal</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="productosBody">
            <?php include('php/carrito/mostrar_carrito.php'); ?>
          </tbody>
        </table>
      </div>

      <div style="display: flex; justify-content: space-between; font-size: 1.25rem">
        <span>Total:</span>
        <span id="totalDisplay" style="color: black">$<?php echo number_format($_SESSION['total_compra'] ?? 0, 0); ?></span>
      </div>



      <!-- CONTENT -->
      <div class="content-wrapper">
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem">
          <!-- LEFT: BÚSQUEDA Y CARRITO -->
          <div>


            <!-- DATOS DEL CLIENTE -->
            <div class="dashboard-card" style="margin-top: 2rem">
              <h3>Información del Cliente</h3>
              <form action="php/carrito/procesar_pago.php" method="POST" id="formPago">
                <div class="form-group">
                  <label>Identificación del Cliente *</label>
                  <input type="text" name="cliente_identificacion" placeholder="Cédula o ID" required />
                </div>
                <div class="form-group">
                  <label>Nombre del Cliente</label>
                  <input type="text" name="cliente_nombre" placeholder="Nombre del cliente" />
                </div>
                <div class="form-group">
                  <label>Teléfono (Opcional)</label>
                  <input type="tel" name="cliente_telefono" placeholder="Teléfono" />
                </div>
              </form>
            </div>

            <!-- BOTONES -->
            <div style="margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.5rem">
              <button type="submit" form="formPago" class="btn btn-success btn-block">
                💳 Procesar Pago
              </button>

              <form action="php/carrito/vaciar_carrito.php" method="POST">
                <button type="submit" class="btn btn-outline btn-block">
                  🗑️ Vaciar Carrito
                </button>
              </form>
            </div>

            <!-- RIGHT: CARRITO Y RESUMEN -->



            <!-- <div> 
              <div class="dashboard-card" style="margin-bottom: 2rem; max-height: 400px; overflow-y: auto">
                <h3>Carrito de Compra</h3>
                <div id="cartItems" style="display: flex; flex-direction: column; gap: 1rem">
                  <div class="empty-state"></div>
                </div>
              </div>

         RESUMEN DE TOTALES 
              <div class="dashboard-card" style="background-color: #f0f9ff; border: 2px solid var(--color-secondary)">
                <h3 style="color: var(--color-secondary)">Resumen de Venta</h3>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem">
                  <span>Subtotal:</span>
                  <strong id="subtotalDisplay">€ 0.00</strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem">
                  <span>IVA (21%):</span>
                  <strong id="ivaDisplay">€ 0.00</strong>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 2px solid var(--color-secondary)">
                  <span>Descuento:</span>
                  <strong id="discountDisplay">€ 0.00</strong>
                </div>
                
                

                
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--color-secondary-light)">
                  <button class="btn btn-danger btn-sm btn-block" onclick="abrirModalDevolucion()">
                    ↩️ Devolución/Anulación
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div> -->
    </main>
  </div>

  <script src="js/utils.js"></script>
  <script src="js/ventas.js"></script>


</body>

</html>