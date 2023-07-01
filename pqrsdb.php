<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["nombre"]) || $_SESSION["nombre"] == '') {
  // El usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
  header("Location: login.php");
  exit();
}

// Obtener las PQRS de la base de datos
require "conexion.php";
$query = "SELECT * FROM pqrs";
$resultado = mysqli_query($conn, $query);

// Obtener el número total de PQRS
$total_pqrs = mysqli_num_rows($resultado);

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="Estilos/pqrsdb.css">
  <title>PQRS</title>
</head>
<body>
  <aside>
    <a href="dashboard.php" class="log">
      <img src="Logo .png" alt="logo">Moto Club
    </a>
    <ul>
      <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
      <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
      <li><a href="#"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
      <li><a href="pqrsdb.php"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
      <li><a href="clientes.php"><span><i class='bx bx-briefcase'></i></span>Clientes</a></li>
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
        
        <?php
        echo '<div class="foto">';             
        echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
        echo '</div>';
        echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
        ?>
      </div>
    </header>
    <div class="pqrs">
      <h2>Total de PQRS: <?php echo $total_pqrs; ?></h2>
      <?php
      if ($total_pqrs > 0) {
        // Mostrar las PQRS en una tabla
        echo '<table>';
        echo '<tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Distrito</th>
                <th>Documento</th>
                <th>Correo Electrónico</th>
                <th>Teléfono</th>
                <th>Descripción</th>
              </tr>';

        while ($fila = mysqli_fetch_assoc($resultado)) {
          echo '<tr>';
          echo '<td>' . $fila["id"] . '</td>';
          echo '<td>' . $fila["nombre"] . '</td>';
          echo '<td>' . $fila["direccion"] . '</td>';
          echo '<td>' . $fila["distrito"] . '</td>';
          echo '<td>' . $fila["documento"] . '</td>';
          echo '<td>' . $fila["correo"] . '</td>';
          echo '<td>' . $fila["telefono"] . '</td>';
          echo '<td>' . $fila["descripcion"] . '</td>';
          echo '</tr>';
        }

        echo '</table>';
      } else {
        echo '<p>No hay PQRS registradas.</p>';
      }
      ?>
    </div>
  </div>
</body>
</html>
