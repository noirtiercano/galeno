<?php
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

$fecha_limite = date('Y-m-d', strtotime('+30 days'));
$result = mysqli_query($conn, "SELECT * FROM productos WHERE activo = 1 AND fecha_caducidad <= '$fecha_limite' ORDER BY fecha_caducidad");

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<p style="color: orange;">⏰ '.$row['nombre'].' - Vence: '.date('d/m/Y', strtotime($row['fecha_caducidad'])).'</p>';
    }
} else {
    echo '<p>No hay productos por vencer</p>';
}
mysqli_close($conn);
?>