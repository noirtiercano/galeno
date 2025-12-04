<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");
$id = $_GET['id'];

$sql = "SELECT * FROM proveedores WHERE id=" . $id;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $user = $row['nombre'];
        $email = $row['email'];
        $tel = $row['telefono'];
        $direccion = $row['direccion'];
    }
} else {
    //echo "<br> 0 resultados";

}

if (isset($_GET['btnActualizar'])) {

    $id_edit = $_GET['user_id'];
    $user_edit = $_GET['cliente_edit'];
    $email_edit = $_GET['email_edit'];
    $tel_edit = $_GET['tel_edit'];
    $direccion_edit = $_GET['direccion_edit'];




    $sql = "UPDATE proveedores SET id = '$id_edit', nombre = '$user_edit', email = '$email_edit', telefono = '$tel_edit', direccion = '$direccion_edit' WHERE proveedores.id =" . $id . " ";

    echo "<br>" . $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
        //echo "El registro fue actualizado correctamente";
        header("location: ../../proveedores.php");
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
    <title>GALENO - Gestión de Clientes</title>
    <link rel="stylesheet" href="css/style.css" />-
</head>

<body>

    <div class="modal-header">
        <h2 id="clienteModalTitle">Editar Proveedor</h2>
        <!-- <button class="close-btn" onclick="closeModal('clienteModal')">&times;</button> -->
    </div>

    <div class="modal-body" style="padding: 1rem">

        <form id="clienteForm" action="editar_proveedor.php" method="get">

            <div class="form-group">
                <label>Id</label>
                <input name="user_id" type="text" value="<?php echo $id; ?>" />
            </div>

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" id="clienteNombre" name="cliente_edit" value="<?php echo $user; ?>" required />
            </div>

            <div class="form-group">
                <label>Contacto</label>
                <input type="email" id="clienteEmail" name="email_edit" value="<?php echo $email; ?>" />
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="tel" id="clienteTelefono" name="tel_edit" value="<?php echo $tel; ?>" />
            </div>

            <div class="form-group">
                <label>Dirección</label>
                <input type="text" id="clienteTelefono" name="direccion_edit" value="<?php echo $direccion; ?>" />
            </div>



            <button class="btn btn-primary" name="btnActualizar" type="submit">
                Actualizar
            </button>

            <button class="btn btn-outline">
                <a href="../../proveedores.php">Cancelar</a>
            </button>

        </form>

    </div>

    <div class="modal-footer">


    </div>
    </div>
    </div>

</body>