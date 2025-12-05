<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

$sql = "SELECT * FROM ordenes_compra ORDER BY fecha_orden DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
        // Obtener nombre del proveedor
        $proveedor_id = $row['proveedor_id'];
        $sql_proveedor = "SELECT nombre FROM proveedores WHERE id = '$proveedor_id'";
        $result_proveedor = mysqli_query($conn, $sql_proveedor);
        $proveedor = mysqli_fetch_assoc($result_proveedor);
        $nombre_proveedor = $proveedor['nombre'];
        
        // Color según estado
        $color_estado = '';
        $icono_estado = '';
        if ($row['estado'] == 'pendiente') {
            $color_estado = 'color: orange;';
            $icono_estado = '⏳';
        } else if ($row['estado'] == 'recibida') {
            $color_estado = 'color: green;';
            $icono_estado = '✅';
        } else if ($row['estado'] == 'cancelada') {
            $color_estado = 'color: red;';
            $icono_estado = '❌';
        }
        
        echo '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$nombre_proveedor.'</td>
                <td>'.$row['producto_nombre'].'</td>
                <td>'.$row['cantidad'].'</td>
                <td>$'.number_format($row['precio_unitario'], 0).'</td>
                <td>$'.number_format($row['total'], 0).'</td>
                <td style="'.$color_estado.' font-weight: bold;">'.$icono_estado.' '.ucfirst($row['estado']).'</td>
                <td>';
        
        // Solo mostrar editar si está pendiente
        if ($row['estado'] == 'pendiente') {
            echo '<a href="php/ordenes_compras/editar_orden.php?id='.$row['id'].'" title="Cambiar estado">✏️</a>';
        } else {
            echo '<span style="color: #ccc;">✏️</span>';
        }
        
        echo '</td>
              </tr>';
    }
} else {
    echo "<tr><td colspan='8'>No hay órdenes de compra registradas</td></tr>";
}

mysqli_close($conn);

?>