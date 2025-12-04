<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

$sql = "SELECT * FROM proveedores";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
         echo '<tr>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['telefono'].'</td>
                <td>'.$row['direccion'].'</td>
                <td><a href="php/proveedores/editar_proveedor.php?id='.$row['id'].'">Editar</a></td>
                <td><a href="php/proveedores/eliminar_proveedor.php?user_id='.$row['id'].'" onclick="return confirm(\'Estás seguro de eliminar?\')">Eliminar</a></td>
              </tr>';

    }
} else {
    //echo "<br> 0 resultados";
    
}


?>