<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if(isset($_GET['busqueda'])){
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%".$_GET['busqueda']."%'";
}else{
    $sql = "SELECT * FROM productos";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
        // CALCULAR STOCK REAL
        $entrada = 0;
        $salida = 0;
        
        $sql2 = "SELECT SUM(cantidad) as TOTAL FROM entradas WHERE producto_id = '".$row['id']."'";
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            $row2 = mysqli_fetch_assoc($result2);
            $entrada = $row2['TOTAL'];
        }
        
        $sql3 = "SELECT SUM(cantidad) as TOTAL FROM salidas WHERE producto_id = '".$row['id']."'";
        $result3 = mysqli_query($conn, $sql3);
        if (mysqli_num_rows($result3) > 0) {
            $row3 = mysqli_fetch_assoc($result3);
            $salida = $row3['TOTAL'];
        }
        
        $stock = $entrada - $salida;
        
        echo '<tr>
                <td>'.$row['codigo'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['descripcion'].'</td>
                <td>' . $stock . '</td>
                <td>'.$row['precio'].'</td>
                <td>';
                
                
        if ($row['activo'] == 1) {
            echo '<span style="color: green;">✓ Activo</span>';
        } else {
            echo '<span style="color: red;">❌ Inactivo</span>';
        };

            echo '</td>
              <td><a href="php/productos/editar_producto.php?id='.$row['id'].'">✏️</a></td>
              <td><a href="php/productos/eliminar_producto.php?id='.$row['id'].'" onclick="return confirm(\'Estás seguro de eliminar?\')">🗑️</a></td>
            </tr>';

            
        
    }
} else {
    //echo "<br> 0 resultados";
    
}
?>