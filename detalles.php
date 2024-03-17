<?php
session_start();
require "conexion.php";

if (!isset ($_SESSION["nombre"]) || empty ($_SESSION["nombre"])) {
  header("Location: login.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="Estilos/reservadb.css">
    <title>Document</title>
</head>

<body>

    <aside>
        <a href="dashboard.php" class="log"><img src="Imagenes/Logo.png" alt="logo">Moto Club</a>
        <ul>
            <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
            <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
            <li><a href="reservadb.php"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
            <li><a href="pqrsdb.php"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
            <li><a href="clientes.php"><span><i class='bx bx-question-mark'></i></span>Clientes</a></li>
            <li><a href="reportes.php"><span><i class='bx bx-question-mark'></i></span>Reportes</a></li>
            <li><a href="ventas.php"><span><i class='bx bx-question-mark'></i></span>Ventas</a></li>
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
                <?php if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])): ?>
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
            <form id="detallesForm" action="detalles.php" method="post">
                <div class="detalle">
                    <div class="form-group">
                        <label for="nombreServicio">Servicio:</label>
                        <input type="text" id="nombreServicio" name="nombreServicio" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="descripcionServicio">Descripción del servicio:</label>
                        <textarea id="descripcionServicio" name="descripcionServicio" rows="1" class="form-control"
                            readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="costo">Precio:</label>
                        <input type="text" id="costo" name="costo" class="form-control" readonly>
                    </div>
                </div>

                <h2>Detalles de la reserva</h2>
                <div class="detalle">
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="text" id="fecha" name="fecha" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="hora">Hora:</label>
                        <input type="text" id="hora" name="hora" class="form-control" required readonly>
                    </div>
                </div>
                <a href="reservadb.php"><button type="button" class="btn btn-primary">Volver</button></a>
            </form>
        </div>
    </div>
    <script>

        const urlParams = new URLSearchParams(window.location.search);
        const datosString = urlParams.get('datos');

        if (datosString) {
            // Convertir la cadena JSON a objeto
            const datos = JSON.parse(decodeURIComponent(datosString));

            // Asignar datos a los campos del formulario
            document.getElementById("nombreServicio").value = datos.nombreServicio || '';
            document.getElementById("descripcionServicio").value = datos.descripcionServicio || '';
            document.getElementById("costo").value = datos.precio || '';
            document.getElementById("descripcion").value = datos.descripcion || '';
            document.getElementById("fecha").value = datos.fecha || '';
            document.getElementById("hora").value = datos.hora || '';
        }
    </script>
</body>

</html>