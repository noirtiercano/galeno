<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GALENO - Reportes</title>
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

      <?php $pagina = "reportes";
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
        <h2>Reportes y Análisis</h2>
        <div class="header-actions">
          <span class="user-info">👤 Farmacéutico</span>
          <span class="date-time" id="dateTime"></span>
        </div>
      </header>

      <!-- CONTENT -->
      <div class="content-wrapper">
        <!-- FILTROS -->
        <div class="dashboard-card" style="margin-bottom: 2rem">
          <h3>Filtros de Reporte</h3>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem">
            <div class="form-group">
              <label>Tipo de Reporte</label>
              <select id="reporteType" onchange="cambiarReporte()">
                <option value="ventas">Ventas</option>
                <option value="inventario">Inventario</option>
                <option value="clientes">Clientes Top</option>
                <option value="productos-vendidos">Productos Más Vendidos</option>
              </select>
            </div>
            <div class="form-group">
              <label>Fecha Inicio</label>
              <input type="date" id="fechaInicio" onchange="generarReporte()" />
            </div>
            <div class="form-group">
              <label>Fecha Fin</label>
              <input type="date" id="fechaFin" onchange="generarReporte()" />
            </div>
            <div style="display: flex; align-items: flex-end; gap: 0.5rem">
              <button class="btn btn-primary" onclick="generarReporte()">
                📊 Generar Reporte
              </button>
              <button class="btn btn-secondary" onclick="exportarPDF()">
                📥 Descargar PDF
              </button>
            </div>
          </div>
        </div>

        <!-- CONTENIDO DEL REPORTE -->
        <div id="reporteContent"></div>
      </div>
    </main>
  </div>

  <script src="js/utils.js"></script>
  <script src="js/reportes.js"></script>
</body>

</html>