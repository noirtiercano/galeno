<?php 
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if(isset($_GET["producto_id"])){

    $producto_id = $_GET["producto_id"];
    $sql = "DELETE FROM productos WHERE `productos`.`id` = $producto_id";
    

    session_start();

    if (mysqli_query($conn, $sql)){
        echo "Producto eliminado";
        header("location: ../../inventario.php");
    } else {
        echo "Error al eliminar";
        $_SESSION['msj_error'] = "error al eliminar";
        header("location: ../../login1.php");
    }

}
mysqli_close($conn);