<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login1.php");
    exit();
}

if (isset($_POST['producto_id'])) {
    $usuario_id = $_SESSION['user_id'];
    $producto_id = $_POST['producto_id'];

    $sql = "DELETE FROM carritos WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
    mysqli_query($conn, $sql);

    header("Location: ../../carrito.php");
    exit();
}

mysqli_close($conn);
