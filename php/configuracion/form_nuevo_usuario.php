   
   <div class="modal-body" style="padding: 1rem">
        <form id="clienteForm" action="configuracion.php" method="get">
            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" id="clienteNombre" name="user" required />
            </div>
            <div class="form-group">
                <label>Correo *</label>
                <input type="text" id="clienteNombre" name="email" required />
            </div>
            <div class="form-group">
            <select name="rol" required>
                <option value="">Seleccione un rol</option>
                <option value="admin">Administrador</option>
                <option value="farmaceutico">Farmacéutico</option>
                <option value="cajero">Cajero</option>
            </select>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" id="clienteEmail" name="password" required />
            </div>

            <button class="btn btn-primary" name="btn-agregar" type="submit">
                Guardar
            </button>
        </form>
    </div>