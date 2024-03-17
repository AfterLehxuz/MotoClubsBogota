<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
   // redirigir si hay un error
  header("Location: login.php");
  exit;
}

// Verificacion de el idPqrs sea correcto
if (!isset($_POST["idPqrs"]) || empty($_POST["idPqrs"])) {
  // redirigir si hay un error
  header("Location: dashboard.php");
  exit;
}
$idPqrs = $_POST["idPqrs"];

$tipo = $_POST["tipo"];
$descripcion = $_POST["descripcion"];


// Incluir archivo de conexión
require_once "conexion.php";

// Actualizar los datos del usuario en la base de datos
$actualizarQuery = "UPDATE pqrs SET tipo = '$tipo', descripcion = '$descripcion' WHERE idPqrs = '$idPqrs'";
if ($conn->query($actualizarQuery) === TRUE) {
  
  header("Location: pqrsdb.php");
  exit;
} else {
 
}
