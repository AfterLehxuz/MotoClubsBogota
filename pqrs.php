<?php
session_start();
$mensaje = "";
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si el usuario ha iniciado sesión
  if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
    // El usuario ha iniciado sesión, proceder a guardar la PQR en la base de datos
    require "conexion.php";

    // Obtener los valores del formulario
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $direccion = mysqli_real_escape_string($conn, $_POST["direccion"]);
    $distrito = mysqli_real_escape_string($conn, $_POST["distrito"]);
    $documento = mysqli_real_escape_string($conn, $_POST["documento"]);
    $correo = mysqli_real_escape_string($conn, $_POST["correo"]);
    $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
    $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);

    // Insertar la PQR en la tabla
    $query = "INSERT INTO pqrs (nombre, direccion, distrito, documento, correo, telefono, descripcion)
              VALUES ('$nombre', '$direccion', '$distrito', '$documento', '$correo', '$telefono', '$descripcion')";

    if (mysqli_query($conn, $query)) {
      // La inserción se realizó con éxito
      $mensaje = "PQR enviada correctamente";
    } else {
      // Hubo un error al insertar los datos
      $mensaje = "Error al enviar la PQR: " . mysqli_error($conn);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
  } else {
    // El usuario no ha iniciado sesión, mostrar un mensaje de inicio de sesión requerido
    echo '<p>Debes iniciar sesión para poder enviar una PQR.</p>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="Estilos/pqrs.css">
  <link rel="shortcut icon" href="Estilos/imagenes/logo .png" type="image/x-icon">
  <title>Document</title>
</head>
<body>
  <header>
    <a href="index.php" class="logo">
      <img src="Imagenes/Logo .png" alt="Icono de la empresa">Moto Club
    </a>
    <nav>
      <ul>
        <li id="inicio"><a href="index.php">Inicio</a></li>
        <li><a href="#">Reservas</a></li>
        <li><a href="#">Repuestos</a></li>
        <li><a href="#">PQRS</a></li>
        <li><a href="#">Contactos</a></li>
      </ul>
      <?php
      if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
        // El usuario ha iniciado sesión, muestra su nombre en su lugar
        echo '<div class="foto">';
        echo '<span><i class="bx bx-user"></i></span>';
        echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
        echo '</div>';
        echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
        echo '<a href="dashboard.php"><button>Perfil</button></a>'; // Agrega este enlace para ir a dashboard.php
      } else {
        // El usuario no ha iniciado sesión, muestra los botones "Iniciar sesión" y "Registrarse"
        echo '<a href="login.php"><button>Iniciar sesión</button></a>';
        echo '<a href="signup.php"><button>Registrarse</button></a>';
      }
      ?>
    </nav>
  </header>
  <section class="pqrs">
    <h2>Enviar PQR</h2>

    <form action="" method="POST">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>
      <div class="form-group">
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>
      </div>
      <div class="form-group">
        <label for="distrito">Distrito:</label>
        <input type="text" id="distrito" name="distrito" required>
      </div>
      <div class="form-group">
        <label for="documento">Documento:</label>
        <input type="text" id="documento" name="documento" required>
      </div>
      <div class="form-group">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>
      </div>
      <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>
      </div>
      <div class="form-group">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
      </div>

      <?php
      if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
        // El usuario ha iniciado sesión, muestra el botón de enviar
        echo '<button type="submit">Enviar</button>';
      } else {
        // El usuario no ha iniciado sesión, muestra un mensaje de inicio de sesión requerido
        echo '<p>Debes iniciar sesión para poder enviar una PQR.</p>';
      }
      ?>
      <?php if (!empty($mensaje)): ?>
              
              <p><?php echo $mensaje; ?></p>
          
      <?php endif; ?>
    </form>
  </section>

  <footer>
    <div class="contactos"></div>
    <div class="redes"></div>
  </footer>
</body>
</html>
