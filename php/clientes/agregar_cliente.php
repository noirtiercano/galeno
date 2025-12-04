<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");


if (isset($_GET["btn-agregar"])) {
    $user = $_GET["user"];
    $email = $_GET["email"];
    $tel = $_GET["telefono"];
    $identificacion = $_GET["identificacion"];

    $sql = "INSERT INTO clientes (nombre, email, telefono, identificacion) VALUES ('$user',  '$email', '$tel', '$identificacion')";

    if (mysqli_query($conn, $sql)) {
        echo " <br> Nuevo cliente agregado exitosamente";
        header("location: ../../clientes.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>