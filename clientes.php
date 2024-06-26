<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
  header("Location: login.php");
  exit;
}

if (!isset($_SESSION["rol_idRol"]) || $_SESSION["rol_idRol"] != 1) {
  header("Location: acceso_denegado.php");
  exit;
}
$sql = "SELECT u.*, r.nombre as nombre_rol 
        FROM usuarios u 
        INNER JOIN rol r ON u.rol_idRol = r.idRol
        WHERE u.idUsuarios = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $_SESSION["rol"]);

$stmt->execute();

$resultado = $stmt->get_result();

$usuario = $resultado->fetch_assoc();

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="javaScript/clientes.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="Estilos/pqrsdb.css">
  <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
  <title>Clientes</title>

</head>

<body>
  <aside>
    <a href="dashboard.php" class="log"><img src="Imagenes/Logo.png" alt="logo">MOTO ClUB'S BOGOTÁ</a>
    <ul>
      <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
      <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2) : ?>
        <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
      <?php endif; ?>
      <li><a href="reservadb.php"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
      <li><a href="pqrsdb.php"><span><i class='bx bx-message-square-dots'></i></span>PQRS</a></li>
      <?php if ($_SESSION["rol_idRol"] == 1) : ?>
        <li><a href="clientes.php"><span><i class='bx bx-user'></i></span>Clientes</a></li>
      <?php endif; ?>
      <li><a href="reportes.php"><span><i class='bx bxs-report'></i></span>Reportes</a></li>
      <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2) : ?>
        <li><a href="ventas.php"><span><i class='bx bx-shopping-bag'></i></span>Ventas</a></li>
      <?php endif; ?>
      <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2) : ?>
        <li><a href="provedores.php"><span><i class='bx bx-scan'></i></span>Provedores</a></li>
      <?php endif; ?><li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
      <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2) : ?>
        <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
      <?php endif; ?>
      <li><a href="reservadb.php"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
      <li><a href="pqrsdb.php"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
      <?php if ($_SESSION["rol_idRol"] == 1) : ?>
        <li><a href="clientes.php"><span><i class='bx bx-question-mark'></i></span>Clientes</a></li>
      <?php endif; ?>
      <li><a href="reportes.php"><span><i class='bx bx-question-mark'></i></span>Reportes</a></li>
      <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2) : ?>
        <li><a href="ventas.php"><span><i class='bx bx-question-mark'></i></span>Ventas</a></li>
      <?php endif; ?>
      <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2) : ?>
        <li><a href="provedores.php"><span><i class='bx bxs-cabinet'></i></span>Provedores</a></li>
      <?php endif; ?>
    </ul>
  </aside>
  <div class="contenido">
    <header>
      <div class="contenido-rol">
        <span>
          <?php echo $usuario['nombre_rol']; ?>
        </span>
      </div>
      <div class="contenido-perfil">
        <?php if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])) : ?>
          <div class="foto">
            <span class="nombre-usuario">
              <?php echo $_SESSION["nombre"]; ?>
            </span>
          </div>
          <a href="logout.php"><button>Cerrar sesión</button></a>
        <?php endif; ?>
      </div>
    </header>

    <div class="perfil">
      <div class="reservas-inicio">
        <h1>Usuarios Registrados</h2>
          <table class="table table-striped table-bordered">
            <thead class="table-dark">
              <tr>
                <th scope="col">Documento</th>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Dirreccion</th>
                <th scope="col">Rol</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody id="t_inf">
            </tbody>
          </table>
      </div>
    </div>
  </div>

</body>

</html>