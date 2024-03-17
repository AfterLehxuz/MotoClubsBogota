<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
   // redirigir si hay un error
  header("Location: login.php");
  exit;
}

// Verificacion de el idReserva sea correcto
if (!isset($_POST["idReserva"]) || empty($_POST["idReserva"])) {
  // redirigir si hay un error
  header("Location: dashboard.php");
  exit;
}
$idReserva = $_POST["idReserva"];

$servicio = $_POST["servicio"];
$descripcion = $_POST["descripcion"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];


// Incluir archivo de conexión
require_once "conexion.php";

// Actualizar los datos del reserva en la base de datos
$actualizarQuery = "UPDATE reserva SET servicio = '$servicio', descripcion = '$descripcion', fecha = '$fecha', hora = '$hora' WHERE idReserva = '$idReserva'";
if ($conn->query($actualizarQuery) === TRUE) {
  
  header("Location: reservadb.php");
  exit;
} else {
 
}
