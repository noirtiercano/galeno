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


        <main class="main-content">

            <header class="top-header">
                <h2>Inventario - Gestión de Productos</h2>
                <div class="header-actions">
                    <span class="user-info"><?php include('php/header.php'); ?></span>
                    <span class="date-time" id="dateTime"></span>
                </div>
            </header>

            <div class="content-wrapper">

                <div class="controls-section">
                    <button class="btn btn-primary" onclick="openProductModal()">
                        ➕ <a href="php/productos/form_nuevo_producto.php">Nuevo Producto</a>
                    </button>

                    <div class="filters-section">

                        <form action="" method="get">
                            <input type="text" id="searchInput" placeholder="🔍 Buscar producto..." class="search-input" name="busqueda" value="<?php if(isset($_GET['busqueda'])){echo $_GET['busqueda'];}?>">
                            <input type="submit" value="Buscar" class="btn btn-primary btn-search" name="btnBuscar">
                        </form>

                        <select id="filterStatus" class="filter-select" onchange="filtrarProductos()">
                            <option value="">Todos los estados</option>
                            <option value="stock-bajo">Stock Bajo</option>
                            <option value="proximo-vencer">Próximo a Vencer</option>
                            <option value="ok">OK</option>
                        </select>
                    </div>
                </div>

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

    <!-- SCRIPTS -->
    <script src="js/utils.js"></script>
    <script src="js/inventario.js"></script>
</body>

</html>