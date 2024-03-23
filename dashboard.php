<?php
session_start();
require_once "conexion.php";

// Verificar la sesión
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="javaScript/dashboard.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/dashboard.css">
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Dashboard</title>
    <style>
    .logo img {
        border-radius: 10%; /* Esto hace que la imagen sea redonda */
    }
    
    </style>

<body>
    <aside>
        <a href="index.php" class="log"><img src="Imagenes/Logo.png" alt="logo">MOTO ClUB'S BOGOTÁ</a>
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
                <h1>dashboard</h1>
                <div class="card">
                    <div class="container">
                        <canvas id="grafico"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h2>Haz tu reserva aqui</h2>
                        <img src="Imagenes/moto1.jpg" alt="Descripción de la imagen">
                        <div>

                            <p>
                                En nuestro taller, entendemos la importancia de mantener tu moto en óptimas condiciones
                                para garantizar tu seguridad y disfrute en cada viaje. Nuestro equipo de expertos en
                                mecánica está aquí para brindarte un servicio de alta calidad y confianza. Desde el
                                mantenimiento regular hasta las reparaciones especializadas, nos comprometemos a cuidar
                                de tu moto como si fuera nuestra. Con la atención y el cuidado que merece, tu moto
                                estará lista para enfrentar cualquier camino y aventura que se presente. ¡No esperes
                                más, reserva tu servicio ahora y mantén tu moto en su mejor estado!
                            </p>

                        </div>
                        <a href="reserva.php"><button class="btn btn-primary">AQUI</button></a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h2>Échale un ojo a nuestros artículos</h2>
                        <img src="Imagenes/moto4.jpg" alt="Descripción de la imagen">
                        <div>

                            <p>Descubre nuestra amplia selección de artículos de alta calidad para satisfacer tus
                                necesidades y gustos. Desde accesorios únicos hasta productos de última tecnología,
                                tenemos todo lo que necesitas para complementar tu estilo de vida. Explora nuestra
                                variedad de artículos y encuentra las mejores opciones para ti. ¡No esperes más para
                                descubrir lo que tenemos para ofrecerte!</p>


                        </div>
                        <a href="repuestos.php"><button class="btn btn-primary">AQUI</button></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h2>¿alguna queja, reclamo o petición?</h2>
                        <img src="Imagenes/PQRS.jpg" alt="Descripción de la imagen">
                        <div>

                            <p>
                                Si tienes alguna queja, reclamo o petición sobre el estado o el servicio de tu moto,
                                estamos aquí para ayudarte. En nuestro taller, comprendemos la importancia de resolver
                                cualquier problema que puedas enfrentar con tu vehículo. Nuestro equipo de expertos en
                                mecánica está comprometido en brindarte soluciones efectivas y rápidas para garantizar
                                tu satisfacción. No dudes en contactarnos y dejarnos saber cómo podemos mejorar tu
                                experiencia y resolver cualquier inconveniente. ¡Estamos aquí para servirte!
                            </p>

                        </div>
                        <a href="pqrs.php"><button class="btn btn-primary">AQUI</button></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>