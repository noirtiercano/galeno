<?php
// Solo iniciar sesión si NO está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol_usuario = $_SESSION['rol'] ?? '';
?>

<ul class="nav-menu">

    <li><a href="dashboard.php" class="nav-link <?php if($pagina=="dashboard"){echo "active";}?>" data-module="dashboard">
            <span class="icon">📊</span>
            <span>Dashboard</span>
        </a></li>
    

    <li><a href="inventario.php" class="nav-link <?php if($pagina=="inventario"){echo "active";}?>" data-module="inventario">
            <span class="icon">📦</span>
            <span>Inventario</span>
        </a></li>

    <li><a href="productos.php" class="nav-link <?php if($pagina=="productos"){echo "active";}?>" data-module="productos">
            <span class="icon">💊</span>
            <span>Productos</span>
        </a></li>
    

    <li><a href="carrito.php" class="nav-link <?php if($pagina=="carrito"){echo "active";}?>" data-module="carrito">
            <span class="icon">🛒</span>
            <span>Carrito</span>
        </a></li>
    

    <li><a href="salidas.php" class="nav-link <?php if($pagina=="salidas"){echo "active";}?>" data-module="salidas">
            <span class="icon">📤</span>
            <span>Salidas</span>
        </a></li>



    <?php if ($rol_usuario == 'admin' || $rol_usuario == 'farmaceutico') { ?>

        <li><a href="entradas.php" class="nav-link <?php if($pagina=="entradas"){echo "active";}?>" data-module="entradas">
                <span class="icon">📥</span>
                <span>Entradas</span>
            </a></li>

        <li><a href="ordenes_compras.php" class="nav-link <?php if($pagina=="ordenes_compras"){echo "active";}?>" data-module="ordenes_compras">
            <span class="icon">📋</span>
            <span>Ordenes de Compra</span>
        </a></li>
        

        <li><a href="proveedores.php" class="nav-link <?php if($pagina=="proveedores"){echo "active";}?>" data-module="proveedores">
                <span class="icon">🚚</span>
                <span>Proveedores</span>
            </a></li>
    <?php } ?>


    <li><a href="clientes.php" class="nav-link <?php if($pagina=="clientes"){echo "active";}?>" data-module="clientes">
            <span class="icon">👥</span>
            <span>Clientes</span>
        </a></li>

    <?php if ($rol_usuario == 'admin') { ?>

        <li><a href="configuracion.php" class="nav-link <?php if($pagina=="configuracion"){echo "active";}?>" data-module="configuracion">
                <span class="icon">⚙️</span>
                <span>Configuración</span>
            </a></li>
    <?php } ?>
</ul>