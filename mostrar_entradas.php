<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if(isset($_GET['busqueda'])){
    $sql = "SELECT * FROM entradas WHERE nombre LIKE '%".$_GET['busqueda']."%'";
}else{
    $sql = "SELECT * FROM entradas";
}


$sql = "SELECT entradas.*, proveedores.nombre as nombre_proveedor 
        FROM entradas 
        LEFT JOIN proveedores ON entradas.proveedor_id = proveedores.id 
        ORDER BY entradas.fecha_entrada DESC";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
         echo '<tr>
                <td>'.$row['fecha_entrada'].'</td>
                <td>'.$row['nombre_proveedor'].'</td>
                <td>'.$row['codigo'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['cantidad'].'</td>
                <td>'.$row['precio'].'</td>
                <td>'.$row['lote'].'</td>
                <td>'.$row['fecha_caducidad'].'</td>
              </tr>';
    }
} else {
    echo "<tr><td colspan='8'>No hay entradas registradas</td></tr>";
}
?>