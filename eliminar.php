<?php
session_start();

// Incluir archivo de conexión
require_once "conexion.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
  // Redirigir al formulario de inicio de sesión si el usuario no ha iniciado sesión
  header("Location: login.php");
  exit;
}

// Verificar si se recibió el ID del usuario por GET
if (isset($_GET["id"])) {
  $idUsuario = $_GET["id"];

  // Eliminar el usuario de la base de datos
  $eliminarQuery = "DELETE FROM usuarios WHERE idUsuario = '$idUsuario'";
  if ($conn->query($eliminarQuery) === TRUE) {
    // La eliminación se realizó correctamente
    // Redirigir a la página de clientes después de eliminar el usuario
    header("Location: clientes.php");
    exit;
  } else {
    // Ocurrió un error al eliminar el usuario
    // Manejar el caso apropiado, como mostrar un mensaje de error o redirigir a una página de error
  }
} else {
  // Si no se proporcionó el ID del usuario, redirigir a la página de clientes
  header("Location: clientes.php");
  exit;
}
?>

