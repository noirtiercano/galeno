<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");

if (isset($_GET["btn-agregar"])) {
    
    $proveedor_id = $_GET["proveedor_id"];
    $producto_nombre = $_GET["producto_nombre"];
    $cantidad = $_GET["cantidad"];
    $precio_unitario = $_GET["precio_unitario"];
    $fecha_entrega = $_GET["fecha_entrega_esperada"];
    
    // Calcular el total
    $total = $cantidad * $precio_unitario;
    
    // Estado por defecto: pendiente
    $estado = "pendiente";
    
    // Insertar la orden de compra
    $sql = "INSERT INTO ordenes_compra (proveedor_id, producto_nombre, cantidad, precio_unitario, total, fecha_entrega_esperada, estado, fecha_orden) 
            VALUES ('$proveedor_id', '$producto_nombre', '$cantidad', '$precio_unitario', '$total', '$fecha_entrega', '$estado', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Orden de compra creada correctamente'); window.location.href='../../ordenes_compras.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>