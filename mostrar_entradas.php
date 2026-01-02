<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");


$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conn, $_GET['busqueda']) : '';

$sql = "SELECT entradas.*, proveedores.nombre as nombre_proveedor 
        FROM entradas 
        LEFT JOIN proveedores ON entradas.proveedor_id = proveedores.id";

if ($busqueda != '') {
    $sql .= " WHERE entradas.nombre LIKE '%$busqueda%' 
              OR entradas.codigo LIKE '%$busqueda%' 
              OR proveedores.nombre LIKE '%$busqueda%'";
}

$sql .= " ORDER BY entradas.fecha_entrada DESC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

        $proveedor = $row['nombre_proveedor'] ?? 'Sin proveedor';
        
        echo '<tr>
                <td>'.$row['fecha_entrada'].'</td>
                <td>'.$proveedor.'</td>
                <td>'.$row['codigo'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['cantidad'].'</td>
                <td>'.$row['precio'].'</td>
                <td>'.$row['lote'].'</td>
                <td>'.$row['fecha_caducidad'].'</td>
              </tr>';
    }
} else {
    echo "<tr><td colspan='8'>No se encontraron entradas con ese criterio.</td></tr>";
}
?>