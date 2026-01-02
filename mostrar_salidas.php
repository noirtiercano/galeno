<?php
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conn, $_GET['busqueda']) : '';

$sql = "SELECT s.*, p.nombre AS nombre_producto, c.nombre AS nombre_cliente 
        FROM salidas s
        LEFT JOIN productos p ON s.producto_id = p.id
        LEFT JOIN clientes c ON s.cliente_identificacion = c.identificacion";

if ($busqueda != '') {
    $sql .= " WHERE p.nombre LIKE '%$busqueda%' 
              OR c.nombre LIKE '%$busqueda%' 
              OR s.cliente_identificacion LIKE '%$busqueda%'";
}

$sql .= " ORDER BY s.fecha_venta DESC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
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
    echo "<tr><td colspan='7'>No se encontraron registros que coincidan con la búsqueda.</td></tr>";
}

mysqli_close($conn);
?>