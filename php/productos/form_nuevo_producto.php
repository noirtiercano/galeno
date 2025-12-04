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
        <h2 id="clienteModalTitle">Nuevo Producto</h2>
        <!-- <button class="close-btn" onclick="closeModal('clienteModal')">&times;</button> -->
    </div>

    <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm" action="agregar_producto.php" method="get">
            <div class="form-group">
                <label>Fecha entrada *</label>
                <input type="date" id="clienteNombre" name="fecha_entrada" required />
            </div>

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
                <label>Código del producto *</label>
                <input type="text" id="clienteNombre" name="cod_producto" required />
            </div>
            <div class="form-group">
                <label>Nombre del Producto *</label>
                <input type="text" id="clienteNombre" name="nombre_producto" required />
            </div>
            <div class="form-group">
                <label>Descripción *</label>
                <input type="text" id="clienteNombre" name="descripcion" required />
            </div>
            <div class="form-group">
                <label>Precio</label>
                <input type="number" id="clienteTelefono" name="precio" min="0"/>
            </div>
            <div class="form-group">
                <label>Cantidad</label>
                <input type="number" id="clienteTelefono" name="cantidad" min="0"/>
            </div>
            <div class="form-group">
                <label>Número de Lote</label>
                <input type="text" id="clienteTelefono" name="num_lote" required/>
            </div>
            <div class="form-group">
                <label>Fecha de Caducidad</label>
                <input type="date" id="clienteTelefono" name="fecha_caducidad" required/>
            </div>

            <button class="btn btn-primary" name="btn-agregar" type="submit">
                Guardar
            </button>

            <button class="btn btn-outline">
                <a href="../../inventario.php">Cancelar</a>
            </button>
        </form>
    </div>
    <div class="modal-footer">


    </div>
    </div>
    </div>

</body>