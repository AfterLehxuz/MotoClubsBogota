<?php
session_start();

require_once "conexion.php";

$productos = array();

if (isset($_SESSION["rol_idRol"])) {
    $rol_idRol = $_SESSION["rol_idRol"];
    $sql = "SELECT p.idProducto, p.codigo_producto, p.costo, p.descripcion, p.nombre, p.cantidad, pr.Nombre AS nombreProveedor, p.rutaImagen 
            FROM producto p 
            INNER JOIN proveedores pr ON p.proveedor_idProveedor = pr.Nip";
    
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $eliminarBoton = ($rol_idRol == 1) ? '<button class="btn btn-danger" data-id="' . $row["idProducto"] . '" id="eliminar-producto"><span><i class="bx bx-trash"></i></span></button>' : '';

                $productos[] = array(
                    "codigo_producto" => $row["codigo_producto"],
                    "costo" => $row["costo"],
                    "descripcion" => $row["descripcion"],
                    "nombre" => $row["nombre"],
                    "cantidad" => $row["cantidad"],
                    "proveedor_nombre" => $row["nombreProveedor"], 
                    "rutaImagen" => $row["rutaImagen"],
                    "eliminarBoton" => $eliminarBoton,
                    "editarBoton" => '<button class="btn btn-info" data-id="' . $row["idProducto"] . '" id="editar-producto"><i class="bx bx-edit"></i> </button>',
                    "rol_idRol" => $rol_idRol
                );
            }
        } else {
            $productos[] = array("mensaje" => "No hay productos encontrados", "rol_idRol" => $rol_idRol);
        }
    } else {
        $productos[] = array("error" => $conn->error, "rol_idRol" => $rol_idRol);
    }
} else {
    $productos[] = array("mensaje" => "La variable de sesión rol_idRol no está definida");
}

header('Content-Type: application/json');
echo json_encode($productos);

$conn->close();
