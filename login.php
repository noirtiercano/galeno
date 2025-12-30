<?php
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

if (isset($_POST["btnSave"])) {
    
    $user = $_POST["user"];
    $contrasena = $_POST["password"];

    // Consulta que verifica usuario, contraseña Y rol
    $sql = "SELECT * FROM usuarios WHERE nombre='$user' AND clave='$contrasena'";
    $result = mysqli_query($conn, $sql);

    session_start();

    if (mysqli_num_rows($result) > 0) {
        // Usuario encontrado con el rol correcto
        $usuario = mysqli_fetch_assoc($result);
        
        $_SESSION['user'] = $user;
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['correo'] = $usuario['correo'];
    
        header("location: dashboard.php");
        exit();

    } else {
        $_SESSION['msj_error'] = "Usuario o contraseña incorrectos";
        header("location: index.php");
        exit();
    }
}

mysqli_close($conn);
?>