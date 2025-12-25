<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - GALENO</title>
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

            <?php $pagina = "productos";
            include('sidebar.php'); ?>

        </nav>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <!-- HEADER -->
            <header class="top-header">
                <h2>Inventario - Gestión de Productos</h2>
                <div class="header-actions">
                    <span class="user-info"><?php include('php/header.php'); ?></span>
                    <span class="date-time" id="dateTime"></span>
                </div>
            </header>

            <!-- CONTENT AREA -->
            <div class="content-wrapper">
                <!-- CONTROLES Y FILTROS -->
                <div class="controls-section">
                    <button class="btn btn-primary" onclick="openProductModal()">
                        ➕ <a href="php/productos/form_nuevo_producto.php">Nuevo Producto</a>
                    </button>

                    <div class="filters-section">

                        <form action="" method="get">
                            <input type="text" id="searchInput" placeholder="🔍 Buscar producto..." class="search-input" name="busqueda" value="<?php if(isset($_GET['busqueda'])){echo $_GET['busqueda'];}?>">
                            <input type="submit" value="Buscar" name="btnBuscar">
                        </form>

                        <select id="filterStatus" class="filter-select" onchange="filtrarProductos()">
                            <option value="">Todos los estados</option>
                            <option value="stock-bajo">Stock Bajo</option>
                            <option value="proximo-vencer">Próximo a Vencer</option>
                            <option value="ok">OK</option>
                        </select>
                    </div>
                </div>

                <!-- TABLA DE PRODUCTOS -->
                <div class="table-container">
                    <table id="productosTable">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Stock</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productosBody">
                            <?php include('php/productos/mostrar_productos.back.php'); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL: AGREGAR/EDITAR PRODUCTO -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Nuevo Producto</h2>
                <button class="close-btn" onclick="closeProductModal()">&times;</button>
            </div>

            <form id="productForm" onsubmit="guardarProducto(event)">
                <div class="form-group">
                    <label for="codigo">Código del Producto *</label>
                    <input type="text" id="codigo" required placeholder="Ej: PRD-001">
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre del Producto *</label>
                    <input type="text" id="nombre" required placeholder="Ej: Ibuprofeno 400mg">
                </div>

                <div class="form-group">
                    <label for="precio">Precio (€) *</label>
                    <input type="number" id="precio" required step="0.01" min="0" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" required min="0" placeholder="0">
                </div>

                <div class="form-group">
                    <label for="lote">Número de Lote *</label>
                    <input type="text" id="lote" required placeholder="Ej: L20240101">
                </div>

                <div class="form-group">
                    <label for="fechaCaducidad">Fecha de Caducidad *</label>
                    <input type="date" id="fechaCaducidad" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" placeholder="Información adicional del producto..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeProductModal()">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="js/utils.js"></script>
    <script src="js/inventario.js"></script>
</body>

</html>