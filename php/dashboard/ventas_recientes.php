<?php
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

$result = mysqli_query($conn, "SELECT * FROM salidas ORDER BY fecha_venta DESC LIMIT 5");

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $nombre = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nombre FROM productos WHERE id = '{$row['producto_id']}'"))['nombre'];
        echo '<p>'.$nombre.' - Cantidad: '.$row['cantidad'].' - Total: $'.number_format($row['total'], 0).'</p>';
    }
} else {
    echo '<p>No hay ventas registradas</p>';
}
mysqli_close($conn);
?>