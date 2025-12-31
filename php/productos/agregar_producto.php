<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if (isset($_POST["btn-agregar"])) {
    
    $cod_producto = $_POST["cod_producto"];
    $nombre = $_POST["nombre_producto"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $num_lote = $_POST["num_lote"];
    $fecha_caducidad = $_POST["fecha_caducidad"];
    $fecha_entrada = $_POST["fecha_entrada"];
    $proveedor_id = $_POST["proveedor_id"];


    $sql_verificar = "SELECT id, codigo, nombre FROM productos WHERE codigo = '$cod_producto'";
    $resultado = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado) > 0) {
        
        $row = mysqli_fetch_assoc($resultado);
        $producto_id = $row['id'];
        
        echo "<h2>✅ Producto ya existe: " . $row['nombre'] . "</h2>";
        echo "<p>Se agregará una nueva entrada con código: <strong>$cod_producto</strong></p>";
        echo "<p>Cantidad a agregar: <strong>$cantidad</strong></p>";
        echo "<br>";
        
        // Solo agregar la entrada, NO crear producto nuevo
        $sql_entrada = "INSERT INTO entradas 
                       (producto_id, proveedor_id, codigo, nombre, descripcion, precio, cantidad, lote, fecha_caducidad, fecha_entrada) 
                       VALUES 
                       ('$producto_id', '$proveedor_id', '$cod_producto', '$nombre', '$descripcion', '$precio', '$cantidad', '$num_lote', '$fecha_caducidad', '$fecha_entrada')";
        
        if(mysqli_query($conn, $sql_entrada)){
            echo "<p style='color: green;'>✅ Entrada agregada correctamente!</p>";
            header("location: ../../inventario.php");
        } else {
            echo "<p style='color: red;'>❌ Error al agregar entrada: " . mysqli_error($conn) . "</p>";
        }
    } 

    else {
        
        echo "<h2>🆕 Producto nuevo</h2>";
        echo "<p>Creando producto: <strong>$nombre</strong></p>";
        echo "<p>Código: <strong>$cod_producto</strong></p>";
        echo "<br>";
        
        $sql_producto = "INSERT INTO productos 
                        (codigo, nombre, descripcion, precio, lote, fecha_caducidad, fecha_creacion, fecha_actualizacion, activo) 
                        VALUES 
                        ('$cod_producto', '$nombre', '$descripcion', '$precio', '$num_lote', '$fecha_caducidad', NOW(), NOW(), 1)";

        if (mysqli_query($conn, $sql_producto)) {

            $producto_id = mysqli_insert_id($conn);
            echo "<p style='color: green;'>✅ Producto creado correctamente! ID: $producto_id</p>";
            
            $sql_entrada = "INSERT INTO entradas 
                           (producto_id, proveedor_id, codigo, nombre, descripcion, precio, cantidad, lote, fecha_caducidad, fecha_entrada) 
                           VALUES 
                           ('$producto_id', '$proveedor_id', '$cod_producto', '$nombre', '$descripcion', '$precio', '$cantidad', '$num_lote', '$fecha_caducidad', '$fecha_entrada')";
           
            if(mysqli_query($conn, $sql_entrada)){
                echo "<p style='color: green;'>✅ Entrada agregada correctamente!</p>";
                 header("location: ../../inventario.php");
            } else {
                echo "<p style='color: red;'>❌ Error al agregar entrada: " . mysqli_error($conn) . "</p>";
            }
            
        } else {
            echo "<p style='color: red;'>❌ Error al crear producto: " . mysqli_error($conn) . "</p>";
        }
    }
}

mysqli_close($conn);

?>