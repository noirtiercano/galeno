<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

// $sql = "SELECT * FROM salidas ORDER BY fecha_venta DESC";

$sql = "SELECT salidas.*, 
        clientes.identificacion as id_cliente,
        productos.nombre as nombre_producto
        FROM salidas 
        LEFT JOIN clientes ON salidas.cliente_identificacion = clientes.identificacion
        LEFT JOIN productos ON salidas.producto_id = productos.id
        ORDER BY salidas.fecha_venta DESC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
         echo '<tr>
                <td>'.$row['fecha_venta'].'</td>
                <td>'.$row['cliente_identificacion'].'</td>
                <td>'.$row['producto_id'].'</td>
                <td>'.$row['nombre_producto'].'</td>
                <td>'.$row['cantidad'].'</td>
                <td>'.$row['precio_unitario'].'</td>
                <td>'.$row['total'].'</td>
              </tr>';
    }
} else {
    echo "<tr><td colspan='8'>No hay entradas registradas</td></tr>";
}
?>