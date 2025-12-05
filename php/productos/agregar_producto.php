<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if (isset($_GET["btn-agregar"])) {
    
    // Recibir datos del formulario
    $cod_producto = $_GET["cod_producto"];
    $nombre = $_GET["nombre_producto"];
    $descripcion = $_GET["descripcion"];
    $precio = $_GET["precio"];
    $cantidad = $_GET["cantidad"];
    $num_lote = $_GET["num_lote"];
    $fecha_caducidad = $_GET["fecha_caducidad"];
    $fecha_entrada = $_GET["fecha_entrada"];
    $proveedor_id = $_GET["proveedor_id"];

    // ===== VERIFICAR SI EL PRODUCTO YA EXISTE =====
    $sql_verificar = "SELECT id, codigo, nombre FROM productos WHERE codigo = '$cod_producto'";
    $resultado = mysqli_query($conn, $sql_verificar);

    // ===== CASO 1: EL PRODUCTO YA EXISTE =====
    if (mysqli_num_rows($resultado) > 0) {
        
        // Obtener el ID del producto existente
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
            echo "<a href='../../inventario.php'>Volver al inventario</a>";
        } else {
            echo "<p style='color: red;'>❌ Error al agregar entrada: " . mysqli_error($conn) . "</p>";
        }
    } 
    // ===== CASO 2: EL PRODUCTO NO EXISTE (ES NUEVO) =====
    else {
        
        echo "<h2>🆕 Producto nuevo</h2>";
        echo "<p>Creando producto: <strong>$nombre</strong></p>";
        echo "<p>Código: <strong>$cod_producto</strong></p>";
        echo "<br>";
        
        // Primero crear el producto (SIN columna stock)
        $sql_producto = "INSERT INTO productos 
                        (codigo, nombre, descripcion, precio, lote, fecha_caducidad, fecha_creacion, fecha_actualizacion, activo) 
                        VALUES 
                        ('$cod_producto', '$nombre', '$descripcion', '$precio', '$num_lote', '$fecha_caducidad', NOW(), NOW(), 1)";

        if (mysqli_query($conn, $sql_producto)) {
            
            // Obtener el ID del producto recién creado
            $producto_id = mysqli_insert_id($conn);
            echo "<p style='color: green;'>✅ Producto creado correctamente! ID: $producto_id</p>";
            
            // Luego crear la entrada
            $sql_entrada = "INSERT INTO entradas 
                           (producto_id, proveedor_id, codigo, nombre, descripcion, precio, cantidad, lote, fecha_caducidad, fecha_entrada) 
                           VALUES 
                           ('$producto_id', '$proveedor_id', '$cod_producto', '$nombre', '$descripcion', '$precio', '$cantidad', '$num_lote', '$fecha_caducidad', '$fecha_entrada')";
           
            if(mysqli_query($conn, $sql_entrada)){
                echo "<p style='color: green;'>✅ Entrada agregada correctamente!</p>";
                echo "<a href='../../inventario.php'>Volver al inventario</a>";
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