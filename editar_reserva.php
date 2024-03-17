<?php
session_start();

if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
  header("Location: login.php");
  exit;
}

if (!isset($_GET["idReserva"]) || empty($_GET["idReserva"])) {
  header("Location: login.php");
  exit;
}

$idReserva = $_GET["idReserva"];

require_once "conexion.php";

$query = "SELECT * FROM reserva WHERE idReserva = '$idReserva'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  
  $row = $result->fetch_assoc();

  
  $servicio = $row["servicio"];
  $descripcion = $row["descripcion"];
  $fecha = $row["fecha"];
  $hora = $row["hora"];
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
        <a href="index.php" class="log"><img src="Logo .png" alt="logo">Moto Club</a>
        <ul>
            <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
            <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
            <li><a href="#"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
            <li><a href="pqrsdb.php"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
          
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

                if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
                    echo '<div class="foto">';
                    echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
                    echo '</div>';
                    echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
                }
                ?>
            </div>
        </header>
        <div >
            <form action="actualizacionReserva.php" method="POST">
                <input type="hidden" name="idReserva" value="<?php echo $idReserva; ?>">

                <label for="tipo">Tipo:</label>
                <select id="tipo" name="servicio" required>
                    <option value="mantenimiento general">mantenimiento general</option>
                    <option value="sincronizacion">sincronizacion</option>
                    <option value="reparacion de motor">reparacion de motor</option>
                    <option value="servicio de escaner">servicio de escaner</option>
                    <option value="cambio de aceite">cambio de aceite</option>
                    <option value="acesorios">acesorios</option>
                </select>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>

                <label for="fecha">Descripción:</label>
                <input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>">

                <label for="hora">Descripción:</label>
                <input type="time" name="hora" id="hora" value="<?php echo $hora; ?>">

                <button type="submit">Guardar cambios</button>
            </form>


        </div>
    </div>
    </div>
</body>

</html>