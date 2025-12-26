<?php
// Solo iniciar sesión si NO está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$rol_usuario = $_SESSION['rol'] ?? '';
?>

    <ul class="nav-menu">

        <li><a href="dashboard.php" class="nav-link <?php if ($pagina == "dashboard") {
                                                        echo "active";
                                                    } ?>" data-module="dashboard">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column-icon lucide-chart-column"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>
                    </svg>
                </span>
                <span>Dashboard</span>
            </a></li>


        <li><a href="inventario.php" class="nav-link <?php if ($pagina == "inventario") {
                                                            echo "active";
                                                        } ?>" data-module="inventario">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-icon lucide-package"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"/><path d="M12 22V12"/><polyline points="3.29 7 12 12 20.71 7"/><path d="m7.5 4.27 9 5.15"/>
                    </svg>
                </span>
                <span>Inventario</span>
            </a></li>

        <li><a href="productos.php" class="nav-link <?php if ($pagina == "productos") {
                                                        echo "active";
                                                    } ?>" data-module="productos">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pill-icon lucide-pill"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/>
                    </svg>
                </span>
                <span>Productos</span>
            </a></li>


        <li><a href="carrito.php" class="nav-link <?php if ($pagina == "carrito") {
                                                        echo "active";
                                                    } ?>" data-module="carrito">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                </span>
                <span>Carrito</span>
            </a></li>


        <li><a href="salidas.php" class="nav-link <?php if ($pagina == "salidas") {
                                                        echo "active";
                                                    } ?>" data-module="salidas">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-arrow-out-up-right-icon lucide-square-arrow-out-up-right"><path d="M21 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h6"/><path d="m21 3-9 9"/><path d="M15 3h6v6"/>
                    </svg>
                </span>
                <span>Salidas</span>
            </a></li>



        <?php if ($rol_usuario == 'admin' || $rol_usuario == 'farmaceutico') { ?>

            <li><a href="entradas.php" class="nav-link <?php if ($pagina == "entradas") {
                                                            echo "active";
                                                        } ?>" data-module="entradas">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-arrow-out-down-left-icon lucide-square-arrow-out-down-left"><path d="M13 21h6a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6"/><path d="m3 21 9-9"/><path d="M9 21H3v-6"/>
                        </svg>
                    </span>
                    <span>Entradas</span>
                </a></li>

            <li><a href="proveedores.php" class="nav-link <?php if ($pagina == "proveedores") {
                                                                echo "active";
                                                            } ?>" data-module="proveedores">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck-icon lucide-truck"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>
                        </svg>
                    </span>
                    <span>Proveedores</span>
                </a></li>
        <?php } ?>


        <li><a href="clientes.php" class="nav-link <?php if ($pagina == "clientes") {
                                                        echo "active";
                                                    } ?>" data-module="clientes">
                <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                </span>
                <span>Clientes</span>
            </a></li>

        <?php if ($rol_usuario == 'admin') { ?>

            <li><a href="configuracion.php" class="nav-link <?php if ($pagina == "configuracion") {
                                                                echo "active";
                                                            } ?>" data-module="configuracion">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </span>
                    <span>Configuración</span>
                </a></li>
        <?php } ?>
    </ul>

    <div class="sidebar-footer">
        <form action="log_out.php" method="POST">
            <button type="submit" class="logout-btn">
                Cerrar sesión
            </button>
        </form>
    </div>
