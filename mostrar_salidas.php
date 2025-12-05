<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

$sql = "SELECT * FROM salidas ORDER BY fecha_venta DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
        // Obtener nombre del producto
        $producto_id = $row['producto_id'];
        $sql_producto = "SELECT nombre FROM productos WHERE id = '$producto_id'";

        $result_producto = mysqli_query($conn, $sql_producto);
        $producto = mysqli_fetch_assoc($result_producto);

        $nombre_producto = $producto['nombre'];
        
        // Obtener nombre del cliente (opcional)
        $cliente_id = $row['cliente_identificacion'];
        $sql_cliente = "SELECT nombre FROM clientes WHERE identificacion = '$cliente_id'";

        $result_cliente = mysqli_query($conn, $sql_cliente);
        if(mysqli_num_rows($result_cliente) > 0){
            $cliente = mysqli_fetch_assoc($result_cliente);
            $nombre_cliente = $cliente['nombre'];
        } else {
            $nombre_cliente = "INSERT INTO clientes (nombre, telefono, identificacion) VALUES ('$cliente_id', '$cliente_id', '$cliente_id', '$cliente_id')";
        }
        
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