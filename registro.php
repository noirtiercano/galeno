<?php

include "conexion.php";
if (isset($_GET["btnRegistrar"])) {
    $user = $_GET["user"];
    $contrasena = $_GET["password"];

    $sql = "INSERT INTO usuarios (user, password) VALUES ('$user', '$contrasena')";

    if (mysqli_query($conn, $sql)) {
        echo " <br> Nuevo registro creado exitosamente";
        header("location: login1.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}



// $sql = "SELECT * FROM usuarios";
// $result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         "id: " . $row["id"] . "- Nombre: " . $row["user"] . " - Clave: " . $row["password"] . "<br>";

//     }
// } else {
//     echo "<br> 0 resultados";
// }



mysqli_close($conn);

?>


<html>

<head>

    <title>Formulario</title>
    <style>
        input {
            border: 1px solid blue;
        }
    </style>
</head>

<body>
    <form method="get" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="usuario" name="user" placeholder="Escribe tu nombre" required />

        <label for="password">Contraseña:</label>
        <input type="password" id="contrasena" name="password" placeholder="Contraseña" />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email" />

        <label for="tel">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Teléfono" />

        <input name="btnRegistrar" type="submit" id="btnRegistrar" value="Registrar" />
        <a href="login1.php">Volver</a>
    </form>
</body>

</html>