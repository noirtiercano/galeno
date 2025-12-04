<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        
         echo '<tr>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['correo'].'</td>
                <td>'.$row['rol'].'</td>
                <td><a href="php/configuracion/editar_usuario.php?id='.$row['id'].'">✏️</a></td>
                <td><a href="php/configuracion/eliminar_usuario.php?id='.$row['id'].'" onclick="return confirm(\'Estás seguro de eliminar?\')">🗑️</a></td>
              </tr>';

    }
} else {
    //echo "<br> 0 resultados";
    
}


?>