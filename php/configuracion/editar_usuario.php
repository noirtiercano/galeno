<?php

include($_SERVER['DOCUMENT_ROOT'] ."/php/conexion.php");
$id = $_GET['id'];



$sql = "SELECT * FROM usuarios WHERE id=" . $id;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $user = $row['nombre'];
        $rol = $row['rol'];
        $email = $row['correo'];
    }
} else {
    //echo "<br> 0 resultados";

}

if (isset($_GET['btnActualizar'])) {

    $user_edit = $_GET['user_edit'];
    $email_edit = $_GET['email_edit'];
    $rol_edit = $_GET['rol_edit'];


    $sql = "UPDATE usuarios SET nombre = '$user_edit', correo = '$email_edit', rol = '$rol_edit' WHERE usuarios.id =" . $id . " ";

    echo "<br>" . $sql . "<br>";

    if (mysqli_query($conn, $sql)) {
        //echo "El registro fue actualizado correctamente";
        header("location: ../../configuracion.php");
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
        <h2 id="clienteModalTitle">Editar Usuario</h2>
        <!-- <button class="close-btn" onclick="closeModal('clienteModal')">&times;</button> -->
    </div>

    <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm" action="editar_usuario.php" method="get">
            <input name="user_id" type="text" value="<?php echo $id; ?>" />
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" id="clienteNombre" name="user_edit" value="<?php echo $user; ?>" required />
            </div>
            <div class="form-group">
            <select name="rol_edit" required>
                <option value="">Editar rol</option>
                <option value="admin">Administrador</option>
                <option value="farmaceutico">Farmacéutico</option>
                <option value="cajero">Cajero</option>
            </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="clienteEmail" name="email_edit" value="<?php echo $email; ?>" />
            </div>


            <button class="btn btn-primary" name="btnActualizar" type="submit">
                Actualizar
            </button>

            <button class="btn btn-outline">
                <a href="../../configuracion.php">Cancelar</a>
            </button>
        </form>
    </div>
    <div class="modal-footer">


    </div>
    </div>
    </div>

</body>