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

// Verificar si se proporcionó un ID de usuario válido
if (!isset($_POST["idUsuarios"]) || empty($_POST["idUsuarios"])) {
  // Redirigir a una página de error o a la lista de usuarios
  header("Location: perfil.php");
  exit;
}

$idUsuarios = $_POST["idUsuarios"];
$idUsuarios = mysqli_real_escape_string($conn, $idUsuarios);

$documentoID = $_POST["documentoID"];
$documentoID = mysqli_real_escape_string($conn, $documentoID);

$nombre = $_POST["nombre"];
$nombre = mysqli_real_escape_string($conn, $nombre);

$numero = $_POST["numero"];
$numero = mysqli_real_escape_string($conn, $numero);

$email= $_POST["email"];
$email = mysqli_real_escape_string($conn, $email);

$dirreccion = $_POST["dirreccion"];
$dirreccion = mysqli_real_escape_string($conn, $dirreccion);

$password= $_POST["password"];
$password = mysqli_real_escape_string($conn, $password);

$query = "UPDATE usuarios SET documentoID = '$documentoID', nombre = '$nombre', numero = '$numero', email = '$email', dirreccion = '$dirreccion', password = '$password'  WHERE idUsuarios = '$idUsuarios'";






$query = "UPDATE usuarios SET documentoID = '$documentoID', nombre = '$nombre', numero = '$numero', email = '$email', dirreccion = '$dirreccion', password = '$password'  WHERE idUsuarios = '$idUsuarios'";


// Agrega más consultas SQL aquí para actualizar otros campos, como la contraseña

if ($conn->query($query) === TRUE) {
    $_SESSION["nombre"] = $nombre; // Donde $nombre es el nuevo nombre del usuario

    // Redirige al usuario de vuelta a la página de perfil
    header("Location: perfil.php");
    exit;
} else {
  // Manejar el caso en que la actualización falló
}
?>
