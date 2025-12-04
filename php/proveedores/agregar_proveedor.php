<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");


if (isset($_GET["btn-agregar"])) {
    $user = $_GET["nombre"];
    $email = $_GET["email"];
    $tel = $_GET["telefono"];
    $direccion = $_GET["direccion"];

    $sql = "INSERT INTO proveedores (nombre, email, telefono, direccion) VALUES ('$user',  '$email', '$tel', '$direccion')";

    if (mysqli_query($conn, $sql)) {
        echo " <br> Nuevo proveedor agregado exitosamente";
        header("location: ../../proveedores.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>