<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");
$id = $_GET['id'];



$sql = "SELECT * FROM clientes WHERE id=" . $id;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $user = $row['nombre'];
        $tel = $row['telefono'];
        $email = $row['email'];
    }
} else {
    //echo "<br> 0 resultados";

}

if (isset($_GET['btnActualizar'])) {

    $user_edit = $_GET['cliente_edit'];
    $email_edit = $_GET['email_edit'];
    $tel_edit = $_GET['tel_edit'];


    $sql = "UPDATE clientes SET nombre = '$user_edit', email = '$email_edit', telefono = '$tel_edit' WHERE clientes.id =" . $id . " ";

    echo "<br>" . $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
        //echo "El registro fue actualizado correctamente";
        header("location: ../../clientes.php");
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
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

    <div class="modal-header">
        <h2 id="clienteModalTitle">Editar Cliente</h2>
        <!-- <button class="close-btn" onclick="closeModal('clienteModal')">&times;</button> -->
    </div>

    <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm" action="editar_cliente.php" method="get">
            <input name="user_id" type="text" value="<?php echo $id; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" id="clienteNombre" name="cliente_edit" value="<?php echo $user; ?>" required />
            </div>
            <div class="form-group">
                <label>Teléfono</label>
                <input type="tel" id="clienteTelefono" name="tel_edit" value="<?php echo $tel; ?>" />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="clienteEmail" name="email_edit" value="<?php echo $email; ?>" />
            </div>


            <button class="btn btn-primary" name="btnActualizar" type="submit">
                Actualizar
            </button>

            <button class="btn btn-outline">
                <a href="../../clientes.php">Cancelar</a>
            </button>
        </form>
    </div>
    <div class="modal-footer">


    </div>
    </div>
    </div>

</body>