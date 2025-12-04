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
        
         echo '<tr>
                <td>'.$row['fecha_creacion'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['codigo'].'</td>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['stock'].'</td>
                <td>'.$row['precio'].'</td>
                <td>'.$row['lote'].'</td>
                <td>'.$row['fecha_caducidad'].'</td>
                <td>';

    }
} else {
    //echo "<br> 0 resultados";
    
}
?>