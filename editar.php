<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
  // Redirigir al formulario de inicio de sesión si el usuario no ha iniciado sesión
  header("Location: login.php");
  exit;
}

// Verificar si se proporcionó un ID de usuario válido
if (!isset($_GET["id"]) || empty($_GET["id"])) {
  // Redirigir a una página de error o a la lista de usuarios
  header("Location: login.php");
  exit;
}

// Obtener el ID del usuario a editar
$idUsuario = $_GET["id"];

// Incluir archivo de conexión
require_once "conexion.php";

// Obtener los datos del usuario de la base de datos
$query = "SELECT * FROM usuarios WHERE idUsuario = '$idUsuario'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  // El usuario fue encontrado en la base de datos
  $row = $result->fetch_assoc();

  // Extraer los datos del usuario
  $nombre = $row["nombre"];
  $email = $row["email"];
  $telefono = $row["numero"];
} else {
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="Estilos/editar.css">
  <title>Document</title>
</head>
<body>
  <aside>
    <a href="dashboard.php" class="log"><img src="Logo .png" alt="logo">Moto Club</a>
    <ul>
      <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
      <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
      <li><a href="#"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
      <li><a href="#"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
      <li><a href="#"><span><i class='bx bx-briefcase'></i></span>clientes</a></li>
    </ul>
  </aside>
  <div class="contenido">
    <header>
      <div class="contenido-buscar">
        <span><i class='bx bx-search-alt-2'></i></span>
        <input type="search" placeholder="Buscar">
      </div>
      <div class="contenido-perfil">
        <span><i class='bx bx-bell'></i></span>
        <span><i class='bx bx-message-dots'></i></span>
        <?php if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])): ?>
          <div class="foto">
            <span class="nombre-usuario"><?php echo $_SESSION["nombre"]; ?></span>
          </div>
          <a href="logout.php"><button>Cerrar sesión</button></a>
        <?php endif; ?>
      </div>
    </header>
 
      <div class="registro">
      <h1>Editar usuario</h1>
            <form action="Actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $idUsuario; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" required>

    <label for="email">Email:</label>
     <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>

    <label for="telefono">Teléfono:</label>
    <input type="text" name="telefono" id="telefono" value="<?php echo $telefono; ?>" required>

    <button  class ="enviar" type="submit">Guardar cambios</button>
  </form>
      </div>
    </div>
  </div>
</body>
</html>


