<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");


if (isset($_GET["btn-agregar"])) {
    $nombre = $_GET["nombre_producto"];
    $precio = $_GET["precio"];
    $cantidad = $_GET["cantidad"];
    // $producto_id = $_GET["producto_id"];
    $fecha_entrada = $_GET["fecha_entrada"];
    $num_lote = $_GET["num_lote"];
    $fecha_caducidad = $_GET["fecha_caducidad"];
    $descripcion = $_GET["descripcion"];
    $cod_producto = $_GET["cod_producto"];
    $proveedor_id =  $_GET["proveedor_id"]; 

    $sql_verificar = "SELECT codigo FROM productos WHERE codigo = '$cod_producto'";
    $resultado = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado) > 0) {
    echo "Error: El código '$cod_producto' ya está registrado.";
    exit();
    }

    $sql_producto = "INSERT INTO productos (codigo, nombre, descripcion, precio, stock, lote, fecha_caducidad, fecha_creacion, fecha_actualizacion, activo) VALUES ('$cod_producto', '$nombre', '$descripcion', '$precio', '$cantidad', '$num_lote', '$fecha_caducidad',  NOW(), NOW(), '1')";

    if (mysqli_query($conn, $sql_producto)) {

        $producto_id_nuevo = mysqli_insert_id($conn);
        
        $sql_entrada = "INSERT INTO entradas (producto_id, codigo, nombre, descripcion, precio, stock, lote, fecha_caducidad, fecha_entrada, proveedor_id) VALUES ('$producto_id_nuevo', '$cod_producto', '$nombre', '$descripcion', '$precio', '$cantidad', '$num_lote', '$fecha_caducidad',  '$fecha_entrada', '$proveedor_id')";
       
        if(mysqli_query($conn, $sql_entrada)){
            header("location: ../../inventario.php");
            exit();
        } else {
        echo "Error: " . $sql_entrada . "<br>" . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);

?>