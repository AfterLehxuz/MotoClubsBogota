<?php
session_start();
require_once "conexion.php";

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

if (isset ($_GET['id']) && !empty ($_GET['id'])) {
    $idProducto = $_GET['id'];

    $sql = "SELECT * FROM producto WHERE idProducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idProducto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
        $costo = $row['costo'];
        $cantidad = $row['cantidad'];
        $codigo_producto = $row['codigo_producto'];
        $proveedor_idProveedor = $row['proveedor_idProveedor'];
        $rutaImagen = $row['rutaImagen'];

        $sqlProveedor = "SELECT Nombre FROM proveedores WHERE Nip = ?";
        $stmtProveedor = $conn->prepare($sqlProveedor);
        $stmtProveedor->bind_param("i", $proveedor_idProveedor);
        $stmtProveedor->execute();
        $resultProveedor = $stmtProveedor->get_result();

        if ($resultProveedor->num_rows > 0) {
            $rowProveedor = $resultProveedor->fetch_assoc();
            $proveedorNombre = $rowProveedor['Nombre'];
        } else {
            $proveedorNombre = "Proveedor desconocido";
        }
    } else {
        header("Location: Inventario.php");
        exit;
    }
    $stmt->close();
    $stmtProveedor->close();
    $conn->close();
} else {

    header("Location: Inventario.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="Estilos/producto.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="javaScript/editar_producto.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Editar_Producto</title>
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
                <h1>Editar producto</h1>
                <form id="editarProductoForm" method="POST" enctype="multipart/form-data" class="mt-4">
                    <input type="hidden" name="idProducto" value="<?php echo $idProducto; ?>">
                    <div class="form-group">
                        <label for="nombreProducto">Nombre:</label>
                        <input type="text" id="nombreProducto" name="nombreProducto" class="form-control"
                            value="<?php echo $nombre; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" class="form-control"
                            required><?php echo $descripcion; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="costo">Costo:</label>
                        <input type="number" id="costo" name="costo" class="form-control" value="<?php echo $costo; ?>"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control"
                            value="<?php echo $cantidad; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo_producto">Código de Producto:</label>
                        <input type="text" id="codigo_producto" name="codigo_producto" class="form-control"
                            value="<?php echo $codigo_producto; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="proveedor">Provedor actual:</label>
                        <input type="text" id="proveedor" name="proveedor" class="form-control"
                            value="<?php echo $proveedorNombre; ?>" required readonly>
                        <input type="hidden" id="proveedorId" name="proveedorId"
                            value="<?php echo $proveedor_idProveedor; ?>">
                    </div>
                    <div class="form-group">
                        <label for="newProveedor">Nuevo provedor:</label>
                        <input type="text" id="newProveedor" name="newProveedor" class="form-control">
                        <input type="hidden" id="newProveedorId" name="newProveedorId">
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen actual:</label>
                        <img src="<?php echo $rutaImagen; ?>" alt="Imagen actual" style="width:50px;height:50px;">
                    </div>
                    <div class="form-group">
                        <label for="imagen">Nueva imagen:</label>
                        <input type="file" id="imagen" name="imagen" accept="image/*" class="form-control-file">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="Inventario.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>