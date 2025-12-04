<?php
session_start();
if(isset($_SESSION['msj_error'])){
    echo $_SESSION['msj_error'];
}
session_destroy();
?>

<form action="login.php" method="post">
    <input name="user" type="text" placeholder="Usuario" required>
    <input name="password" type="password" placeholder="Contraseña" required>
    
    <select name="rol" required>
        <option value="">Seleccione un rol</option>
        <option value="admin">Administrador</option>
        <option value="farmaceutico">Farmacéutico</option>
        <option value="cajero">Cajero</option>
    </select>
    
    <input name="btnSave" type="submit" value="Iniciar sesión">
</form>