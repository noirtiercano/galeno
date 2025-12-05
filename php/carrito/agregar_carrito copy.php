<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    //exit();
}

//echo "desde el agregar producto";

if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $usuario_id = $_SESSION['user_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];




    // Verificar si el producto ya está en el carrito del usuario
    $sql_verificar = "SELECT * FROM carritos WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
    $result = mysqli_query($conn, $sql_verificar);


    if (mysqli_num_rows($result) > 0) {
        // Si ya existe, actualizar cantidad (sumar)
        $sql = "UPDATE carritos SET cantidad = cantidad + $cantidad WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
        $msj = "Producto actualizado en el carrito";
    } else {
        // Si no existe, insertar nuevo
        $sql = "INSERT INTO carritos (usuario_id, producto_id, cantidad) VALUES ('$usuario_id', '$producto_id', '$cantidad')";
        $msj = "Producto actualizado en el carrito";
    }


    // Verificar si el producto ya está en el carrito del usuario
    $fecha_actual = date('Y-m-d');
    $sql_verificar2 = "SELECT * FROM productos WHERE  fecha_caducidad <= '$fecha_actual' AND id = '$producto_id'";
    ///echo $sql_verificar2;
    $result2 = mysqli_query($conn, $sql_verificar2);


    $msj = "";
    if (mysqli_num_rows($result2) > 0) {
        // Si ya existe, actualizar cantidad (sumar)
        //echo "<script>alert('Este producto está vencido'); </script>";
        //header("Location: ../../inventario.php");
        $msj = "El producto está vencido";
    } else {

        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE carritos SET cantidad = cantidad + $cantidad WHERE usuario_id = '$usuario_id' AND producto_id = '$producto_id'";
            if (mysqli_query($conn, $sql)) {
                $msj = "Producto actualizado en el carrito";
            }
        } else {
            if (mysqli_query($conn, $sql)) {
                //echo "<script>alert('porducto agregado  al carrito'); </script>";
                //header("Location: ../../inventario.php");
                //exit();
                $msj = "Producto agregado al carrito";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}

mysqli_close($conn);
header("Location: ../../inventario.php?msj=$msj");
