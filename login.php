<?php
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");

if (isset($_POST["btnSave"])) {
    
    $user = $_POST["user"];
    $contrasena = $_POST["password"];
    $rol = $_POST["rol"];

    // Consulta que verifica usuario, contraseña Y rol
    $sql = "SELECT * FROM usuarios WHERE nombre='$user' AND clave='$contrasena' AND rol='$rol'";
    $result = mysqli_query($conn, $sql);

    session_start();

    if (mysqli_num_rows($result) > 0) {
        // Usuario encontrado con el rol correcto
        $usuario = mysqli_fetch_assoc($result);
        
        $_SESSION['user'] = $user;
        $_SESSION['rol'] = $usuario['rol'];
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['correo'] = $usuario['correo'];

        // Redirigir según el rol
        if($rol == "admin"){
            header("location: index.php");
            exit();
        } else if($rol == "farmaceutico"){
            header("location: index.php");
            exit();
        } else if($rol == "cajero"){
            header("location: index.php");
            exit();
        }
        
    } else {
        $_SESSION['msj_error'] = "Usuario, contraseña o rol incorrectos";
        header("location: login1.php");
        exit();
    }
}

mysqli_close($conn);
?>