<?php

include($_SERVER['DOCUMENT_ROOT'] . "/php/conexion.php");


if (isset($_GET["btn-agregar"])) {
  $user = $_GET["user"];
  $password = $_GET["password"];
  $rol = $_GET["rol"];
  $email = $_GET["email"];

  $sql = "INSERT INTO usuarios (nombre, clave, rol, correo ) VALUES ('$user',  '$password', '$rol', '$email')";

  if (mysqli_query($conn, $sql)) {
    echo " <br> Nuevo usuario agregado exitosamente";
    header("location: dashboard.php");
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GALENO - Gestión de Clientes</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>

  <div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo">
          <span style="font-size: 1.75rem">💊</span>
          <h1>GALENO</h1>
        </div>
      </div>

      <?php $pagina = "configuracion";
      include('sidebar.php'); ?>

      <div class="sidebar-footer">
        <a href="log_out.php" class="logout-btn">Cerrar sesión</a>
        <!-- <button class="logout-btn" onclick="confirmarCierre()">
            🚪 Cerrar Sesión
          </button> -->
      </div>
    </aside>


    <main class="main-content">

      <header class="top-header">
        <h2>Configuración de Usuarios</h2>
        <div class="header-actions">
          <span class="user-info"><?php include('php/header.php'); ?></span>
          <span class="date-time" id="dateTime"></span>
        </div>
      </header>


      <div class="content-wrapper">
        <div style="display: flex; gap: 2rem; margin-bottom: 2rem">
          <button class="btn btn-primary" onclick="abrirModalAgregarCliente()">
            ➕ <a href="php/configuracion/form_nuevo_usuario.php">Nuevo Usuario</a>
          </button>
          <input
            type="text"
            id="searchCliente"
            placeholder="Buscar cliente..."
            style="flex: 1; max-width: 300px"
            onkeyup="filtrarClientes()" />
        </div>

        <!-- TABLA DE CLIENTES -->
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Nombre de usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody id="proveedoresTable">
              <?php include('mostrar_usuarios.php'); ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>


</body>