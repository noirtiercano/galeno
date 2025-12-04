<?php

// Verificar que el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo '<tr><td colspan="6" style="text-align:center;">Debes iniciar sesión</td></tr>';
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Obtener los productos del carrito de este usuario
$sql = "SELECT c.*, p.codigo, p.nombre, p.descripcion, p.precio 
        FROM carritos c 
        INNER JOIN productos p ON c.producto_id = p.id 
        WHERE c.usuario_id = '$usuario_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo '<tr><td colspan="6" style="text-align:center;">El carrito está vacío</td></tr>';
} else {
    $total_compra = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $subtotal = $row['precio'] * $row['cantidad'];
        $total_compra += $subtotal;
        
        echo '<tr>
                <td>' . $row['codigo'] . '</td>
                <td>' . $row['nombre'] . '</td>
                <td>$' . number_format($row['precio'], 0) . '</td>
                <td>
                    <form action="php/carrito/actualizar_cantidad.php" method="POST" style="display:inline;">
                        <input type="hidden" name="producto_id" value="' . $row['producto_id'] . '">
                        <input type="number" name="cantidad" value="' . $row['cantidad'] . '" min="1" style="width:80px;">
                        <button type="submit" style="padding:2px 8px;">✓</button>
                    </form>
                </td>
                <td>$' . number_format($subtotal, 0) . '</td>
                <td>
                    <form action="php/carrito/eliminar_carrito.php" method="POST" style="display:inline;">
                        <input type="hidden" name="producto_id" value="' . $row['producto_id'] . '">
                        <button type="submit" style="background:none; border:none; cursor:pointer; color:red; font-size:18px;">
                            🗑️
                        </button>
                    </form>
                </td>
              </tr>';
    }
    
    // Guardar el total en sesión para mostrarlo
    $_SESSION['total_compra'] = $total_compra;
}

?>