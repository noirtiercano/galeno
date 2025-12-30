<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALENO - Iniciar Sesión</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1>GALENO</h1>
            <p>Sistema de Gestión Farmacéutica</p>
        </div>

        <div class="login-body">
            <?php if (isset($_SESSION['msj_error'])): ?>
                <div class="alert">
                    <?php
                    echo $_SESSION['msj_error'];
                    unset($_SESSION['msj_error']);
                    ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label>Usuario</label>
                    <div class="input-wrapper">
                        <span class="input-icon">👤</span>
                        <input name="user" type="text" placeholder="Ingrese su usuario" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input name="password" type="password" placeholder="Ingrese su contraseña" required>
                    </div>
                </div>

                <button type="submit" name="btnSave" class="btn-submit">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </div>
</body>

</html>