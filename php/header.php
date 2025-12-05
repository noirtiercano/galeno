<header>
        <span>
            <?php 
            if($_SESSION['rol'] == 'admin') {
                echo '👤 Administrador';
            } else if($_SESSION['rol'] == 'farmaceutico') {
                echo '💊 Farmacéutico';
            } else if($_SESSION['rol'] == 'cajero') {
                echo '💰 Cajero';
            }
            ?>
        </span>

</header>