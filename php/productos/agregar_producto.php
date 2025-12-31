<?php
include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if (isset($_POST["btn-agregar"])) {
    // Captura de datos...
    $cod_producto = $_POST["cod_producto"];
    $nombre = $_POST["nombre_producto"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $num_lote = $_POST["num_lote"];
    $fecha_caducidad = $_POST["fecha_caducidad"];
    $fecha_entrada = $_POST["fecha_entrada"];
    $proveedor_id = $_POST["proveedor_id"];

    $sql_verificar = "SELECT id FROM productos WHERE codigo = '$cod_producto'";
    $resultado = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado) > 0) {
        $row = mysqli_fetch_assoc($resultado);
        $producto_id = $row['id'];

        $sql_entrada = "INSERT INTO entradas (producto_id, proveedor_id, codigo, nombre, descripcion, precio, cantidad, lote, fecha_caducidad, fecha_entrada) 
                        VALUES ('$producto_id', '$proveedor_id', '$cod_producto', '$nombre', '$descripcion', '$precio', '$cantidad', '$num_lote', '$fecha_caducidad', '$fecha_entrada')";
        
        if(mysqli_query($conn, $sql_entrada)){

            $sql_update = "UPDATE productos SET precio = '$precio', lote = '$num_lote', fecha_caducidad = '$fecha_caducidad', fecha_actualizacion = NOW() WHERE id = '$producto_id'";
            mysqli_query($conn, $sql_update);
            
            header("location: ../../inventario.php?msj=entrada_ok");
        }
    } else {

        $sql_producto = "INSERT INTO productos (codigo, nombre, descripcion, precio, lote, fecha_caducidad, fecha_creacion, fecha_actualizacion, activo) 
                         VALUES ('$cod_producto', '$nombre', '$descripcion', '$precio', '$num_lote', '$fecha_caducidad', NOW(), NOW(), 1)";

        if (mysqli_query($conn, $sql_producto)) {
            $producto_id = mysqli_insert_id($conn);
            $sql_entrada = "INSERT INTO entradas (producto_id, proveedor_id, codigo, nombre, descripcion, precio, cantidad, lote, fecha_caducidad, fecha_entrada) 
                            VALUES ('$producto_id', '$proveedor_id', '$cod_producto', '$nombre', '$descripcion', '$precio', '$cantidad', '$num_lote', '$fecha_caducidad', '$fecha_entrada')";
           
            if(mysqli_query($conn, $sql_entrada)){
                 header("location: ../../inventario.php?msj=producto_ok");
            }
        }
    }
}
mysqli_close($conn);
?>