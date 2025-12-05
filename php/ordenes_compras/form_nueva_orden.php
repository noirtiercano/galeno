<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Nueva Orden de Compra</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<body>

<h2>Nueva Orden de Compra</h2>

<form action="agregar_orden.php" method="get">

    <div class="form-group">
        <label>Proveedor *</label>
        <select name="proveedor_id" required>
            <option value="">Seleccione un proveedor</option>
            <?php
            include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");
            $proveedores = mysqli_query($conn, "SELECT id, nombre FROM proveedores WHERE activo = 1");
            while($proveedor = mysqli_fetch_assoc($proveedores)){
                echo "<option value='{$proveedor['id']}'>{$proveedor['nombre']}</option>";
            }
            mysqli_close($conn);
            ?>
        </select>
    </div>

    <div class="form-group">
        <label>Nombre del Producto *</label>
        <input type="text" name="producto_nombre" required placeholder="Ej: Aspirina 500mg" />
    </div>

    <div class="form-group">
        <label>Cantidad *</label>
        <input type="number" name="cantidad" required min="1" />
    </div>

    <div class="form-group">
        <label>Precio Unitario *</label>
        <input type="number" name="precio_unitario" required min="0" />
    </div>

    <div class="form-group">
        <label>Fecha Entrega</label>
        <input type="date" name="fecha_entrega_esperada" />
    </div>

    <button class="btn btn-primary" name="btn-agregar" type="submit">Crear Orden</button>
    <a href="../../ordenes_compras.php" class="btn btn-outline">Cancelar</a>
</form>

</body>
</html>