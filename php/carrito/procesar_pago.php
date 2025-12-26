<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['cliente_identificacion'])) {
    
    $usuario_id = $_SESSION['user_id'];
    $cliente_identificacion = $_POST['cliente_identificacion'];
    $cliente_nombre = $_POST['cliente_nombre'];
    $cliente_telefono = $_POST['cliente_telefono'];
    
    $sql_verificar = "SELECT * FROM clientes WHERE identificacion = '$cliente_identificacion'";
    $result = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($result) == 0) {
        
        mysqli_query($conn, "INSERT INTO clientes (identificacion, nombre, telefono) VALUES ('$cliente_identificacion', '$cliente_nombre', '$cliente_telefono')");
    }
    
    
    $result_carrito = mysqli_query($conn, "SELECT * FROM carritos WHERE usuario_id = '$usuario_id'");
    
    if (mysqli_num_rows($result_carrito) == 0) {
        echo "<script>alert('El carrito está vacío'); window.location.href='../../carrito.php';</script>";
        exit();
    }
    

    while ($row = mysqli_fetch_assoc($result_carrito)) {
        $producto_id = $row['producto_id'];
        $cantidad = $row['cantidad'];
        

        $precio = mysqli_fetch_assoc(mysqli_query($conn, "SELECT precio FROM productos WHERE id = '$producto_id'"))['precio'];
        $total = $precio * $cantidad;
        

        mysqli_query($conn, "INSERT INTO salidas (producto_id, cantidad, precio_unitario, total, cliente_identificacion, fecha_venta) VALUES ('$producto_id', '$cantidad', '$precio', '$total', '$cliente_identificacion', NOW())");
    }
    

    mysqli_query($conn, "DELETE FROM carritos WHERE usuario_id = '$usuario_id'");
    
    echo "<script>alert('Venta procesada correctamente'); window.location.href='../../salidas.php';</script>";
    exit();
}

mysqli_close($conn);
?>