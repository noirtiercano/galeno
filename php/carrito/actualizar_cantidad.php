<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $usuario_id = $_SESSION['user_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    
    if ($cantidad > 0) {

        $sql = "UPDATE carritos SET cantidad = '$cantidad' WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
        mysqli_query($conn, $sql);
    } else {

        $sql = "DELETE FROM carritos WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
        mysqli_query($conn, $sql);
    }
    
    header("Location: ../../carrito.php");
    exit();
}

mysqli_close($conn);
?>