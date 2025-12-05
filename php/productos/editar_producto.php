<?php

include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");
$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id=" . $id;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $codigo = $row['codigo'];
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $precio = $row['precio'];
        $lote = $row['lote'];
        $fecha_caducidad = $row['fecha_caducidad'];
        $activo = $row['activo'];

    }
} else {
    //echo "<br> 0 resultados";

}

if (isset($_GET['btnActualizar'])) {

    $codigo_edit = $_GET['codigo_edit'];
    $nombre_edit = $_GET['nombre_edit'];
    $descripcion_edit = $_GET['descripcion_edit'];
    $precio_edit = $_GET['precio_edit'];
    $lote_edit = $_GET['lote_edit'];
    $fecha_caducidad_edit = $_GET['fecha_caducidad_edit'];
    $activo_edit = $_GET['activo_edit'];


    $sql = "UPDATE productos SET nombre = '$nombre_edit', codigo = '$codigo_edit' , fecha_caducidad = '$fecha_caducidad_edit', lote = '$lote_edit', precio = '$precio_edit', activo = '$activo_edit', descripcion = '$descripcion_edit' WHERE productos.id =" . $id . " ";

    echo "<br>" . $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
        //echo "El registro fue actualizado correctamente";
        header("location: ../../inventario.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GALENO - Editar Producto</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>

<body>

    <div class="modal-header">
        <h2>Editar Producto</h2>
    </div>

    <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm" action="editar_producto.php" method="get">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <div class="form-group">
                <label>Código *</label>
                <input type="text" name="codigo_edit" value="<?php echo $codigo; ?>" required />
            </div>
            
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre_edit" value="<?php echo $nombre; ?>" required />
            </div>
            
            <div class="form-group">
                <label>Descripción</label>
                <input type="text" name="descripcion_edit" value="<?php echo $descripcion; ?>" />
            </div>
            
            <div class="form-group">
                <label>Precio</label>
                <input type="number" name="precio_edit" value="<?php echo $precio; ?>" />
            </div>
            
            <div class="form-group">
                <label for="activo_edit">Estado:</label>
                <select id="activo_edit" name="activo_edit">
                    <option value="1" <?php if($activo==1){ echo "selected";}?>>Activo</option>
                    <option value="0" <?php if($activo==0){ echo "selected";}?>>Inactivo</option>
                </select>
            </div>

            <button class="btn btn-primary" name="btnActualizar" type="submit">
                Actualizar
            </button>

            <button class="btn btn-outline" type="button">
                <a href="../../productos.php">Cancelar</a>
            </button>
        </form>
    </div>

</body>

</html>