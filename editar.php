<?php
session_start();
require_once "conexion.php";

if (!isset ($_SESSION["nombre"]) || empty ($_SESSION["nombre"])) {
    header("Location: login.php");
    exit;
}
if (!isset ($_SESSION["rol_idRol"]) || $_SESSION["rol_idRol"] != 1) {
    header("Location: login.php");
    exit;
}


if (isset ($_GET['id']) && !empty ($_GET['id'])) {
    $idUsuario = $_GET['id'];

    $query = "SELECT * FROM usuarios WHERE idUsuarios = $idUsuario";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
        $documentoID = $usuario["documentoID"];
        $nombre = $usuario["nombre"];
        $email = $usuario["email"];
        $numero = $usuario["numero"];
        $dirreccion = $usuario["dirreccion"];

    } else {
        echo "Usuario no encontrado";
        exit;
    }
} else {
    echo "ID de usuario no proporcionado";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="javaScript/actualizar_usuarios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="Estilos/pqrsdb.css">
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Editar Usuario</title>
</head>

<body>
    <aside>
    <a href="dashboard.php" class="log"><img src="Imagenes/Logo.png" alt="logo">Moto Clubs Bogota</a>
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
                <?php if (isset ($_SESSION["nombre"]) && !empty ($_SESSION["nombre"])): ?>
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
                <h1>Editar Usuario</h1>
                <form id="editarPerfilForm" method="POST" action="actualizar_usuario.php">
                    <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
                    <div class="form-group">
                        <label for="documentoID">Documento</label>
                        <input type="text" class="form-control" id="documentoID" name="documentoID"
                            value="<?php echo $documentoID; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?php echo $nombre; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="numero">Numero</label>
                        <input type="text" class="form-control" id="numero" name="numero"
                            value="<?php echo $numero; ?>">
                    </div>
                    <div class="form-group">
                        <label for="dirreccion">Dirreccion</label>
                        <input type="text" class="form-control" id="dirreccion" name="dirreccion"
                            value="<?php echo $dirreccion; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar cambios</button>
                    <button type="button" id="cancelarEdicion" class="btn btn-secondary">Cancelar</button>

                </form>
            </div>
        </div>
    </div>

</body>

</html>