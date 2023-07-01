<?php
session_start();
$mensaje = "";
if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
    // Redirigir al formulario de inicio de sesión si el usuario no ha iniciado sesión
    header("Location: login.php");
    exit;
}

require_once "conexion.php";

// Verificar si se ha enviado el formulario para agregar un producto
if (isset($_POST["producto"]) && isset($_POST["cantidad"]) && isset($_POST["descripcion"])) {
    // Los valores del formulario están definidos, procedemos a agregar el producto al inventario
    $producto = $_POST["producto"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];

    // Insertar los datos en la tabla "inventario"
    $query = "INSERT INTO inventario (producto, cantidad, descripcion) VALUES ('$producto', '$cantidad', '$descripcion')";

    $result = $conn->query($query);

    if ($result) {
        // El producto se agregó correctamente
        $mensaje = "El producto se agregó correctamente al inventario.";
    } else {
        // Ocurrió un error al agregar el producto
        $mensaje = "Ocurrió un error al agregar el producto al inventario.";
    }
}

// Obtener los productos del inventario
$query = "SELECT * FROM inventario";
$result = $conn->query($query);

// Cerrar la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/inventario.css">
    <title>Document</title>
</head>
<body>
    <aside>
        <a href="dashboard.php" class="log"><img src="Logo .png" alt="logo">Moto Club</a>
        <ul>
             <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
            <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
            <li><a href="#"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
            <li><a href="#"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
            <li><a href="clientes.php"><span><i class='bx bx-briefcase' ></i></span>clientes</a></li>
        </ul>
    </aside>
    <div class="contenido">
        <header>
            <div class="contenido-buscar">
                <span><i class='bx bx-search-alt-2' ></i></span>
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
        <div class="perfil">
        <div class="reservas-inicio">
        <h1>INVENTARIO</h1>

        <form action="inventario.php" method="POST">
            <label for="producto">Producto:</label>
            <input type="text" name="producto" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion"></textarea>

            <input type="submit" value="Guardar">
            <?php if (!empty($mensaje)): ?>
              
              <p><?php echo $mensaje; ?></p>
          
      <?php endif; ?>
        </form>

        <h2>Productos en el inventario:</h2>

        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Descripción</th>
            </tr>
            <?php
            // Mostrar los productos del inventario en la tabla
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["producto"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    echo "<td>" . $row["descripcion"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No hay productos en el inventario.</td></tr>";
            }
            ?>
        </table>
    </div>
        </div>
    </div>
</body>
</html>