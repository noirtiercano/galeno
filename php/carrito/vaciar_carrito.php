<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login1.php");
    exit();
}

$usuario_id = $_SESSION['user_id'];

// Eliminar todos los productos del carrito de este usuario
$sql = "DELETE FROM carritos WHERE usuario_id = '$usuario_id'";
mysqli_query($conn, $sql);

unset($_SESSION['total_compra']);

header("Location: ../../carrito.php");
exit();
?>