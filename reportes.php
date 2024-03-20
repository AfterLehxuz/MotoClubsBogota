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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="javaScript/reportes.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/ventas.css">
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Reportes</title>
</head>

<body>
    <aside>
        <a href="dashboard.php" class="log"><img src="Imagenes/Logo.png" alt="logo">MOTO ClUB'S BOGOTÁ</a>
        <ul>
            <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
            <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2): ?>
                <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
            <?php endif; ?>
            <li><a href="reservadb.php"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
            <li><a href="pqrsdb.php"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
            <?php if ($_SESSION["rol_idRol"] == 1): ?>
                <li><a href="clientes.php"><span><i class='bx bx-question-mark'></i></span>Clientes</a></li>
            <?php endif; ?>
            <li><a href="reportes.php"><span><i class='bx bx-question-mark'></i></span>Reportes</a></li>
            <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2): ?>
                <li><a href="ventas.php"><span><i class='bx bx-question-mark'></i></span>Ventas</a></li>
            <?php endif; ?>
            <?php if ($_SESSION["rol_idRol"] == 1 || $_SESSION["rol_idRol"] == 2): ?>
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
    <?php if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])): ?>
        <div class="foto">
            <a href="perfil.php"><span class="nombre-usuario"><?php echo $_SESSION["nombre"]; ?></span></a>
        </div>
        <a href="logout.php"><button>Cerrar sesión</button></a>
    <?php endif; ?>
</div>

        </header>

        <div class="perfil">
            <div class="reservas-inicio">
                <h1>REPORTES</h1>
                <div class="card">
                    <div class="card-body">

                        <form id="form-periodo">
                            <label for="select-periodo">Reporte de ventas :</label>
                            <select id="select-periodo" class="form-control" aria-label="Default select example">
                                <option selected>Elige el periodo</option>
                                <option value="semanal">Semanal</option>
                                <option value="mensual">Mensual</option>
                                <option value="anual">Anual</option>
                            </select>
                            <br>
                            <button type="button" onclick="generarPDFPeriodo($('#select-periodo').val())"
                                class="btn btn-outline-danger">Generar
                                PDF<span><i class='bi bi-file-pdf'></i></span></button>
                        </form>
                    </div>
                </div>

                <h2>Reportes generales</h2>
                <div class="card">
                    <div class="card-body">

                        <table class="table table-striped table-bordered" id="reporte">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Dinero Recibido</th>
                                    <th scope="col">Cambio</th>
                                    <th scope="col">Descargar pdf</th>
                                </tr>
                            </thead>
                            <tbody id="t_rep">

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>

</html>