<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

// Verificar que el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login1.php");
    exit();
}

if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $usuario_id = $_SESSION['user_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    
    // Verificar si el producto ya está en el carrito del usuario
    $sql_verificar = "SELECT * FROM carritos WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
    $result = mysqli_query($conn, $sql_verificar);
    
    if (mysqli_num_rows($result) > 0) {
        // Si ya existe, actualizar cantidad (sumar)
        $sql = "UPDATE carritos SET cantidad = cantidad + $cantidad WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
    } else {
        // Si no existe, insertar nuevo
        $sql = "INSERT INTO carritos (usuario_id, producto_id, cantidad) VALUES ('$usuario_id', '$producto_id', '$cantidad')";
    }
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../../inventario.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>