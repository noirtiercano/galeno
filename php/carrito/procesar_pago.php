<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login1.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];
$cliente_identificacion = $_POST['cliente_identificacion'] ?? 'Sin identificar';

// Obtener productos del carrito del usuario
$sql = "SELECT * FROM carritos WHERE usuario_id = '$usuario_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: ../../carrito.php");
    exit();
}

// Procesar cada producto
while ($row = mysqli_fetch_assoc($result)) {
    $producto_id = $row['producto_id'];
    $cantidad = $row['cantidad'];

    // Obtener precio del producto
    $sql_producto = "SELECT precio FROM productos WHERE id = '$producto_id'";
    $result_producto = mysqli_query($conn, $sql_producto);
    $producto = mysqli_fetch_assoc($result_producto);

    $precio_unitario = $producto['precio'];
    $total = $precio_unitario * $cantidad;

    // Insertar en salidas
    $sql_salida = "INSERT INTO salidas (producto_id, cantidad, precio_unitario, total, cliente_identificacion, fecha_venta) 
                   VALUES ('$producto_id', '$cantidad', '$precio_unitario', '$total', '$cliente_identificacion', NOW())";
    mysqli_query($conn, $sql_salida);
}

// Vaciar el carrito del usuario
$sql_vaciar = "DELETE FROM carritos WHERE usuario_id = '$usuario_id'";
mysqli_query($conn, $sql_vaciar);

unset($_SESSION['total_compra']);

mysqli_close($conn);

header("Location: ../../carrito.php");
exit();
