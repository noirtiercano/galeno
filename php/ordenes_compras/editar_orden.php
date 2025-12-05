<?php

include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");
$id = $_GET['id'];


$sql = "SELECT * FROM ordenes_compra WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    
    $proveedor_id = $row['proveedor_id'];
    $producto_nombre = $row['producto_nombre'];
    $cantidad = $row['cantidad'];
    $precio_unitario = $row['precio_unitario'];
    $total = $row['total'];
    $estado = $row['estado'];
    
} else {
    die("Orden no encontrada");
}


if (isset($_GET['btnActualizar'])) {

    $estado_edit = $_GET['estado_edit'];
    

    if ($estado_edit == 'recibida' && $estado != 'recibida') {
        
        
        $sql_producto = "SELECT * FROM productos WHERE nombre = '$producto_nombre' LIMIT 1";
        $result_producto = mysqli_query($conn, $sql_producto);
        
        if (mysqli_num_rows($result_producto) > 0) {
            $producto = mysqli_fetch_assoc($result_producto);
            $producto_id = $producto['id'];
            $codigo = $producto['codigo'];
            $descripcion = $producto['descripcion'];
            $lote = "LOTE-OC-" . $id; 
            $fecha_caducidad = $producto['fecha_caducidad'];
            $fecha_entrada = date('Y-m-d');
            
            
            $sql_entrada = "INSERT INTO entradas 
                           (orden_compra_id, producto_id, proveedor_id, codigo, nombre, descripcion, precio, stock, lote, fecha_caducidad, fecha_entrada) 
                           VALUES 
                           ('$id', '$producto_id', '$proveedor_id', '$codigo', '$producto_nombre', '$descripcion', '$precio_unitario', '$cantidad', '$lote', '$fecha_caducidad', '$fecha_entrada')";
            
            mysqli_query($conn, $sql_entrada);
        }
    }
    

    $sql_update = "UPDATE ordenes_compra SET estado = '$estado_edit' WHERE id = $id";

    if (mysqli_query($conn, $sql_update)) {
        if ($estado_edit == 'recibida') {
            echo "<script>alert('Orden marcada como RECIBIDA y stock agregado al inventario');</script>";
        }
        header("location: ../../ordenes_compras.php");
        exit();
    } else {
        echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GALENO - Editar Orden de Compra</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>

<body>

    <div class="modal-header">
        <h2>Editar Orden de Compra</h2>
    </div>

    <div class="modal-body" style="padding: 1rem">
        

        <div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <p><strong>Producto:</strong> <?php echo $producto_nombre; ?></p>
            <p><strong>Cantidad:</strong> <?php echo $cantidad; ?> unidades</p>
            <p><strong>Precio Unitario:</strong> $<?php echo number_format($precio_unitario, 0); ?></p>
            <p><strong>Total:</strong> $<?php echo number_format($total, 0); ?></p>
        </div>

        <form action="editar_orden.php" method="get">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div class="form-group">
                <label>Estado de la Orden *</label>
                <select name="estado_edit" required>
                    <option value="pendiente" <?php if($estado=='pendiente') echo 'selected'; ?>>⏳ Pendiente</option>
                    <option value="recibida" <?php if($estado=='recibida') echo 'selected'; ?>>✅ Recibida</option>
                    <option value="cancelada" <?php if($estado=='cancelada') echo 'selected'; ?>>❌ Cancelada</option>
                </select>
                
                <?php if($estado == 'pendiente'): ?>
                <small style="color: orange; display: block; margin-top: 5px;">
                     Al marcar como "Recibida", se agregará automáticamente al inventario
                </small>
                <?php endif; ?>
            </div>

            <button class="btn btn-primary" name="btnActualizar" type="submit">
                Actualizar Estado
            </button>

            <button class="btn btn-outline" type="button">
                <a href="../../ordenes_compras.php">Cancelar</a>
            </button>
        </form>
    </div>

</body>

</html>