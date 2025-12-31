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
    </div>

    <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm" action="agregar_producto.php" method="post">

            <div class="form-group">
                <label>Fecha entrada *</label>
                <input type="date" id="clienteNombre" name="fecha_entrada" required />
            </div>

            <div class="form-group">
                <label>Proveedor *</label>
                <select name="proveedor_id" required>
                    <option value="">Seleccione un proveedor</option>
                    <?php
                    include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");
                    $proveedores = mysqli_query($conn, "SELECT id, nombre FROM proveedores WHERE activo = 1");
                    while ($proveedor = mysqli_fetch_assoc($proveedores)) {
                        echo "<option value='{$proveedor['id']}'>{$proveedor['nombre']}</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select>
            </div>



            <div class="form-group">
                <select name="producto_id" id="select_producto" required onchange="gestionarProducto()">
                    <option value="">Seleccione un producto</option>
                    <option value="nuevo">➕ Crear producto nuevo</option>
                    <?php
                    include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");
                    $productos = mysqli_query($conn, "SELECT id, codigo, nombre, descripcion FROM productos WHERE activo = 1 ORDER BY nombre");
                    while ($producto = mysqli_fetch_assoc($productos)) {
                        echo "<option value='{$producto['id']}'
                            data-codigo='{$producto['codigo']}'
                            data-nombre='{$producto['nombre']}'
                            data-descripcion='{$producto['descripcion']}'>
                            {$producto['codigo']} - {$producto['nombre']}
                        </option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Código del Producto *</label>
                <input type="text" id="cod_producto" name="cod_producto" required />
            </div>
            <div class="form-group">
                <label>Nombre del Producto *</label>
                <input type="text" id="nombre_producto" name="nombre_producto" required />
            </div>
            <div class="form-group">
                <label>Descripción *</label>
                <input type="text" id="descripcion" name="descripcion" required />
            </div>
            <div class="form-group">
                <label>Precio Unitario</label>
                <input type="number" name="precio" min="0" step="0.01"/>
            </div>
            <div class="form-group">
                <label>Cantidad</label>
                <input type="number" name="cantidad" min="1"/>
            </div>
            <div class="form-group">
                <label>Número de Lote</label>
                <input type="text" name="num_lote" required />
            </div>
            <div class="form-group">
                <label>Fecha de Caducidad</label>
                <input type="date" name="fecha_caducidad" required />
            </div>

            <button class="btn btn-primary" name="btn-agregar" type="submit">
                Guardar
            </button>
            <a href="../../inventario.php">Cancelar</a>
        </form>
    </div>

   <script>
    function gestionarProducto(){
        const select = document.getElementById('select_producto');
        const option = select.options[select.selectedIndex];

        const inputCod = document.getElementById('cod_producto');
        const inputNom = document.getElementById('nombre_producto');
        const inputDes = document.getElementById('descripcion');

        if (select.value === "nuevo"){
            inputCod.value = "";
            inputNom.value = "";
            inputDes.value = "";

            inputCod.readOnly = false;
            inputNom.readOnly = false;
            inputDes.readOnly = false;
        } else if (select.value !== ""){
            inputCod.value = option.getAttribute('data-codigo');
            inputNom.value = option.getAttribute('data-nombre');
            inputDes.value = option.getAttribute('data-descripcion');

            inputCod.readOnly = true;
            inputNom.readOnly = true;
            inputDes.readOnly = true;
        } else {
            inputCod.value = "";
            inputNom.value = "";
            inputDes.value = "";
        }
    }
   </script>


</body>
</html>