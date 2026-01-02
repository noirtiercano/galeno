<?php

include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");


$rol_usuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : '';


if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
    $busqueda = mysqli_real_escape_string($conn, $_GET['busqueda']); 
    $sql = "SELECT * FROM clientes WHERE nombre LIKE '%$busqueda%'";
} else {
    $sql = "SELECT * FROM clientes";
}

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['telefono'].'</td>
                <td>'.$row['email'].'</td>';
        
        if ($rol_usuario == 'admin') {
            echo '<td>
                    <a href="php/clientes/editar_cliente.php?id='.$row['id'].'">✏️</a>
                    <a href="php/clientes/eliminar_cliente.php?id='.$row['id'].'" onclick="return confirm(\'¿Seguro que deseas eliminar?\')">🗑️</a>
                  </td>';
        }
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">No se encontraron clientes.</td></tr>';
}
?>