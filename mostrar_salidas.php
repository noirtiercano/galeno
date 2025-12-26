<?php
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

// Usamos LEFT JOIN para asegurar que la venta se muestre aunque el cliente/producto ya no existan
$sql = "SELECT s.*, p.nombre AS nombre_producto, c.nombre AS nombre_cliente 
        FROM salidas s
        LEFT JOIN productos p ON s.producto_id = p.id
        LEFT JOIN clientes c ON s.cliente_identificacion = c.identificacion
        ORDER BY s.fecha_venta DESC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
        // Evitamos valores nulos en la tabla si la relación en la DB se rompe
        $nombre_cliente = $row['nombre_cliente'] ?? 'Cliente no registrado';
        $nombre_producto = $row['nombre_producto'] ?? 'Producto no encontrado';
        
        echo '<tr>
                <td>'.date('d/m/Y H:i', strtotime($row['fecha_venta'])).'</td>
                <td>'.$nombre_cliente.'</td>
                <td>'.$row['cliente_identificacion'].'</td>
                <td>'.$nombre_producto.'</td>
                <td>'.$row['cantidad'].'</td>
                <td>$'.number_format($row['precio_unitario'], 0).'</td>
                <td>$'.number_format($row['total'], 0).'</td>
              </tr>';
    }
} else {
    echo "<tr><td colspan='7'>No hay salidas registradas</td></tr>";
}

mysqli_close($conn);
?>