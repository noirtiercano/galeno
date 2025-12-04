<?php
// Solo iniciar sesión si NO está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol_usuario = $_SESSION['rol'] ?? '';
?>

<ul class="nav-menu">
    <!-- Dashboard: TODOS -->
    <li><a href="index.php" class="nav-link <?php if($pagina=="dashboard"){echo "active";}?>" data-module="dashboard">
            <span class="icon">📊</span>
            <span>Dashboard</span>
        </a></li>
    
    <!-- Inventario: TODOS -->
    <li><a href="inventario.php" class="nav-link <?php if($pagina=="inventario"){echo "active";}?>" data-module="inventario">
            <span class="icon">📦</span>
            <span>Inventario</span>
        </a></li>
    
    <!-- Carrito: TODOS -->
    <li><a href="carrito.php" class="nav-link <?php if($pagina=="carrito"){echo "active";}?>" data-module="carrito">
            <span class="icon">🛒</span>
            <span>Carrito</span>
        </a></li>
    
    <!-- Salidas: TODOS (para ver historial) -->
    <li><a href="salidas.php" class="nav-link <?php if($pagina=="salidas"){echo "active";}?>" data-module="salidas">
            <span class="icon">📤</span>
            <span>Salidas</span>
        </a></li>

    <?php if ($rol_usuario == 'admin' || $rol_usuario == 'farmaceutico') { ?>
        <!-- Entradas: Solo admin y farmacéutico -->
        <li><a href="entradas.php" class="nav-link <?php if($pagina=="entradas"){echo "active";}?>" data-module="entradas">
                <span class="icon">📥</span>
                <span>Entradas</span>
            </a></li>
        
        <!-- Proveedores: Solo admin y farmacéutico -->
        <li><a href="proveedores.php" class="nav-link <?php if($pagina=="proveedores"){echo "active";}?>" data-module="proveedores">
                <span class="icon">🚚</span>
                <span>Proveedores</span>
            </a></li>
    <?php } ?>

    <!-- Clientes: TODOS -->
    <li><a href="clientes.php" class="nav-link <?php if($pagina=="clientes"){echo "active";}?>" data-module="clientes">
            <span class="icon">👥</span>
            <span>Clientes</span>
        </a></li>

    <?php if ($rol_usuario == 'admin') { ?>
        <!-- Configuración: Solo admin -->
        <li><a href="configuracion.php" class="nav-link <?php if($pagina=="configuracion"){echo "active";}?>" data-module="configuracion">
                <span class="icon">📈</span>
                <span>Configuración</span>
            </a></li>
    <?php } ?>
</ul>