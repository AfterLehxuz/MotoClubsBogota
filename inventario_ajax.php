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
            <?php endif; ?><?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscarProducto"])) {
    $buscarProducto = $_POST["buscarProducto"];

    $query = "SELECT p.*, pr.Nombre AS nombreProveedor 
              FROM producto p 
              INNER JOIN proveedores pr ON p.proveedor_idProveedor = pr.Nip 
              WHERE p.nombre LIKE '%$buscarProducto%' OR p.codigo_producto = '$buscarProducto'";
    
    $result = mysqli_query($conn, $query);

    $productos = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = $row;
    }

    echo json_encode($productos);
} else {
    echo json_encode(array("error" => "Invalid Request"));
}
