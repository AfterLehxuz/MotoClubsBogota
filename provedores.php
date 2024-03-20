<?php
session_start();
require_once "conexion.php";

// Verificar la sesión
if (!isset ($_SESSION["nombre"]) || empty ($_SESSION["nombre"])) {
    header("Location: login.php");
    exit;
}
if (!isset ($_SESSION["rol_idRol"]) || ($_SESSION["rol_idRol"] != 1 && $_SESSION["rol_idRol"] != 2)) {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="javaScript/provedores.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/ventas.css">
    <title>Ventas</title>
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
                <?php
                if (isset ($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
                    echo '<div class="foto">';
                    echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
                    echo '</div>';
                    echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
                }
                ?>
            </div>
        </header>
        <div class="perfil">
            <div class="reservas-inicio">
                <h1>Provedores</h1>
                <div class="card">
                    <div class="card-body">
                    <a href="registro_proveedores.php"><button
                                    id="registrar">Registrar provedor</button></a> 
                        <div class="search-item">
                            <label for="buscarProvedor">Buscar Provedor</label>
                            <input id="buscarProvedor" type="text" name="buscarProvedor"
                                placeholder="Código o nombre del producto" autocomplete="off">
                            <span class="text-danger" id="error_producto"></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="t_ventas_hist" style="width: 100%;">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="scope=" col">Codio Provedor</th> 
                                        <th class="scope=" col">Nombre</th>
                                        <th class="scope=" col">Telefono</th>
                                        <th class="scope=" col">Dirrección</th>
                                        <th class="scope=" col">Email</th>
                                        <th class="scope=" col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="t_bus"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <h1>Lista de provedores</h1>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-bordered" id="t_ventas_hist" style="width: 100%;">
                            <thead class="table-dark">
                                <tr>
                                    <th class="scope=" col">Codio Provedor</th>
                                    <th class="scope=" col">Nombre</th>
                                    <th class="scope=" col">Telefono</th>
                                    <th class="scope=" col">Dirrección</th>
                                    <th class="scope=" col">Email</th>
                                    <th class="scope=" col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="t_pro"></tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
</body>

</html>