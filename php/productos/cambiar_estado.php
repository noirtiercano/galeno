<?php

include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");
$id = $_GET['id'];

$sql = "SELECT * FROM productos WHERE id=" . $id;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $codigo = $row['codigo'];
        $nombre = $row['nombre'];
        $activo = $row['activo'];

    }
} else {
    //echo "<br> 0 resultados";

}

if (isset($_GET['btnActualizar'])) {

    $activo_edit = $_GET['activo_edit'];


    $sql = "UPDATE productos SET activo = '$activo_edit' WHERE id =" . $id . " ";

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
    <title>GALENO - Cambiar Estado</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>

<body>

    <div class="modal-header">
        <h2>Cambiar Estado del Producto</h2>
    </div>

    <div class="modal-body" style="padding: 1rem">
        
        <div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <p><strong>Código:</strong> <?php echo $codigo; ?></p>
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
        </div>

        <form action="cambiar_estado.php" method="get">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="form-group">
                <label>Nuevo Estado *</label>
                <select name="activo_edit" required>
                    <option value="1" <?php if($activo==1) echo "selected"; ?>>✓ Activo (visible en inventario)</option>
                    <option value="0" <?php if($activo==0) echo "selected"; ?>>✗ Inactivo (oculto del inventario)</option>
                </select>
            </div>

            <button class="btn btn-primary" name="btnActualizar" type="submit">
                Cambiar Estado
            </button>

            <button class="btn btn-outline" type="button">
                <a href="../../inventario.php">Cancelar</a>
            </button>
        </form>
    </div>

</body>

</html>