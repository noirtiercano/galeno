<?php

include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");


$rol_usuario = $_SESSION['rol']; 

if(isset($_GET['busqueda'])){
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%".$_GET['busqueda']."%' AND activo = 1";
}else{
    $sql = "SELECT * FROM productos WHERE activo = 1";
}
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $entrada = 0;
        $salida = 0;
        
        $sql2 = "SELECT SUM(cantidad) as TOTAL FROM entradas WHERE producto_id = '".$row['id']."';";
        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $entrada = $row2['TOTAL'];
            }
        }
        $sql2 = "SELECT SUM(cantidad) as TOTAL FROM salidas WHERE producto_id = '".$row['id']."';";
        $result2 = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $salida = $row2['TOTAL'];
            }
        }
        $stock = $entrada - $salida;
        
        echo '<tr>
                <td>' . $row['codigo'] . '</td>
                <td>' . $row['nombre'] . '</td>
                <td>' . $row['descripcion'] . '</td>
                <td>' . $row['precio'] . '</td>
                <td>' . $stock . '</td>
                <td>' . $row['lote'] . '</td>
                <td>' . $row['fecha_caducidad'] . '</td>
                <td>';
                
        if ($row['activo'] == 1) {
            echo "Activo";
        } else {
            echo "No Activo";
        }
        
        echo '</td>
              <td>
                  <form action="../../php/carrito/agregar_carrito.php" method="POST" style="display:inline;">
                      <input type="hidden" name="producto_id" value="' . $row['id'] . '">
                      <input type="hidden" name="cantidad" value="1">
                      <button type="submit" style="background:none; border:none; cursor:pointer; font-size:18px;">
                          🛒
                      </button>
                  </form>
              </td>';
        

        if ($rol_usuario == 'admin') {
            echo '<td><a href="php/productos/cambiar_estado.php?id='.$row['id'].'">✏️</a></td>';
        } else {

            echo '<td></td>';
            echo '<td></td>';
        }
        
        echo '</tr>';
    }
} else {
    //echo "<br> 0 resultados";
}

?>