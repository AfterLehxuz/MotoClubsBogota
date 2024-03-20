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
    <script src="javaScript/ventas.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/ventas.css">
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
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
if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
    echo '<div class="foto">';
    echo '<a href="perfil.php"><span class="nombre-usuario">' . $_SESSION["nombre"] . '</span></a>';
    echo '</div>';
    echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
}
?>

            </div>
        </header>
        <div class="perfil">
            <div class="reservas-inicio">
                <h1>VENTAS</h1>
                <div class="card">
                    <div class="card-body">
                        <div class="search-item">
                            <label for="buscarProducto">Buscar Producto</label><br>
                            <input id="buscarProducto" type="text" name="buscarProducto"
                                placeholder="Código o nombre del producto" autocomplete="off">
                            <span class="text-danger" id="error_producto"></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="t_ventas_hist" style="width: 100%;">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="scope=" col">Codigo</th>
                                        <th class="scope=" col">Nombre</th>
                                        <th class="scope=" col">Stok</th>
                                        <th class="scope=" col">Cantidad</th>
                                        <th class="scope=" col">Descripción</th>
                                        <th class="scope=" col">Precio</th>
                                        <th class="scope=" col">Sub Total</th>
                                        <th class="scope=" col"></th>
                                    </tr>
                                </thead>
                                <tbody id="t_ven"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="search-item">
                            <label for="buscarReserva">Buscar servicio</label><br>
                            <input id="buscarReserva" type="text" name="buscarReserva" placeholder="Servicio"
                                autocomplete="off">
                            <span class="text-danger" id="error_producto"></span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="t_ventas_hist" style="width: 100%;">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">Servicio</th>
                                        <th scope="col">Costo</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="t_serv"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col">
                            <label for="buscarUsuario">Buscar Usuario</label><a href="registro_usuario.php"><button
                                    id="registrar">Registrar</button></a>
                            <input id="buscarUsuario" name="buscarUsuario" type="text"
                                placeholder="Documento del usuario" autocomplete="off">
                            <input hidden id="idUsuarios" name="idUsuarios">
                            <label for="nombre">Nombre</label>
                            <input id="nombre" name="nombre" placeholder="Nombre del usuario" readonly>
                            <label for="numero">Numero</label>
                            <input id="numero" name="numero" placeholder="Numero del usuario" readonly>
                            <label for="dirreccion">Dirrección</label>
                            <input id="dirreccion" name="dirreccion" placeholder="Dirrección del usuario" readonly>
                        </div>
                        <div class="col">
                            <div class="col-child">
                                <label for="efectivo_recibido">Efectivo Recibido</label>
                                <input id="efectivo_recibido" class="form-control" type="text" name="efectivo_recibido"
                                    placeholder="Recibido">
                            </div>
                            <div class="col-child">
                                <label for="cambio">Cambio</label>
                                <input id="cambio" class="form-control" type="text" name="cambio" placeholder="Cambio"
                                    disabled="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="col-child">
                                <label for="total" class="font-weight-bold">Total a Pagar</label>
                                <input id="total" class="form-control" type="text" name="total" placeholder="Total"
                                    disabled="">
                                <button type="submit" id="btnGuardarDatos">Guardar datos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>