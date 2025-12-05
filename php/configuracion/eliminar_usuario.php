<?php 
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if(isset($_GET["user_id"])){

    $user_id = $_GET["user_id"];
    $sql = "DELETE FROM usuarios WHERE `usuarios`.`id` = $user_id";
    

    session_start();

    if (mysqli_query($conn, $sql)){
        echo "Usuario eliminado";
        header("location: ../../clientes.php");
    } else {
        echo "Error al eliminar";
        $_SESSION['msj_error'] = "error al eliminar";
        header("location: ../../index.php");
    }

}
mysqli_close($conn);