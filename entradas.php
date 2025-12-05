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

            <?php $pagina = "entradas";
            include('sidebar.php'); ?>

            <div class="sidebar-footer">
                <a href="log_out.php" class="logout-btn">Cerrar sesión</a>
            </div>
        </nav>
     
     <main class="main-content">

            <header class="top-header">
                <h2>Entradas</h2>
                <div class="header-actions">
                    <span class="user-info"><?php include('php/header.php'); ?></span>
                    <span class="date-time" id="dateTime"></span>
                </div>
            </header>

            <div class="content-wrapper">

                <div class="controls-section">
                    <div class="filters-section">
                    <button class="btn btn-primary" onclick="openProductModal()">
                        ➕ <a href="php/productos/form_nuevo_producto.php">Nueva Entrada</a>
                    </button>
                    
                         <form action="" method="get">
                            <input type="text" id="searchInput" placeholder="🔍 Buscar producto..." class="search-input" name="busqueda" value="<?php if(isset($_GET['busqueda'])){echo $_GET['busqueda'];}?>">
                            <input type="submit" value="Buscar" name="btnBuscar">
                        </form>

                    </div>
                </div>


                <div class="table-container">
                    <h4>Historial de Entradas</h4>
                    <table id="productosTable">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>CANT</th>
                                <th>Precio unit</th>
                                <th>Lote</th>
                                <th>Caducidad</th>
                            </tr>
                        </thead>
                        <tbody id="productosBody">
                            <?php include('mostrar_entradas.php'); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>    
  </body>