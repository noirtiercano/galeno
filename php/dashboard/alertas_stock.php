<?php
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

$result = mysqli_query($conn, "SELECT * FROM productos WHERE activo = 1");
$tiene_alertas = false;

while ($row = mysqli_fetch_assoc($result)) {
    $entradas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(cantidad) as total FROM entradas WHERE producto_id = '{$row['id']}'"))['total'];
    $salidas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(cantidad) as total FROM salidas WHERE producto_id = '{$row['id']}'"))['total'];
    $stock = $entradas - $salidas;
    
    if ($stock <= 10 && $stock > 0) {
        echo '<p style="color: orange;">⚠️ '.$row['nombre'].' - Stock: '.$stock.'</p>';
        $tiene_alertas = true;
    } else if ($stock <= 0) {
        echo '<p style="color: red;">❌ '.$row['nombre'].' - SIN STOCK</p>';
        $tiene_alertas = true;
    }
}

if (!$tiene_alertas) echo '<p>No hay alertas de stock</p>';
mysqli_close($conn);
?>