<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
  // Redirigir al formulario de inicio de sesión si el usuario no ha iniciado sesión
  header("Location: login.php");
  exit;
}

// Verificar si se proporcionó un ID de usuario válido
if (!isset($_POST["idUsuarios"]) || empty($_POST["idUsuarios"])) {
  // Redirigir a una página de error o a la lista de usuarios
  header("Location: clientes.php");
  exit;
}

// Obtener el ID del usuario a editar
$idUsuario = $_POST["idUsuarios"];
$documentoID = $_POST["documentoID"];
$nombre = $_POST["nombre"];
$email = $_POST["email"];
$dirreccion = $_POST["dirreccion"];
$telefono = $_POST["telefono"];


// Incluir archivo de conexión
require_once "conexion.php";

// Actualizar los datos del usuario en la base de datos
$actualizarQuery = "UPDATE usuarios SET documentoID = '$documentoID', nombre = '$nombre', numero = '$telefono', email = '$email', dirreccion = '$dirreccion' WHERE idUsuarios = '$idUsuario'";
if ($conn->query($actualizarQuery) === TRUE) {
  // La actualización se realizó correctamente
  // Redirigir a la página de clientes después de actualizar los datos
  header("Location: clientes.php");
  exit;
} else {
  // Ocurrió un error al actualizar los datos
  // Manejar el caso apropiado, como mostrar un mensaje de error o redirigir a una página de error
}
?>