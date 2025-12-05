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
        <h2 id="clienteModalTitle">Nuevo Proveedor</h2>
        <!-- <button class="close-btn" onclick="closeModal('clienteModal')">&times;</button> -->
    </div>

    <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm" action="agregar_proveedor.php" method="get">
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" id="clienteNombre" name="nombre" required />
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" id="clienteEmail" name="email" />
            </div>

            <div class="form-group">
                <label>Teléfono</label>
                <input type="tel" id="clienteTelefono" name="telefono" />
            </div>

            <div class="form-group">
                <label>Direccion *</label>
                <input type="text" id="clienteNombre" name="direccion" required />
            </div>

            <button class="btn btn-primary" name="btn-agregar" type="submit">
                Guardar
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