<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="Estilos/contactos.css">
    <link rel="shortcut icon" href="Estilos/imagenes/logo.png" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Contactos</title>
    
</head>

<body>
    <header>
        <a href="index.php" class="logo">
            <img src="Imagenes/Logo.png" alt="Icono de la empresa">Moto Clubs Bogota
        </a>
        <nav>
            <ul>
                <li id="inicio"><a href="index.php">Inicio</a></li>
                <li><a href="reserva.php">Reservas</a></li>
                <li><a href="repuestos.php">Repuestos</a></li>
                <li><a href="pqrs.php">PQRS</a></li>
                <li><a href="contactos.php">Contactos</a></li>
            </ul>
            <?php
            if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
                // El usuario ha iniciado sesión, muestra su nombre en su lugar
                echo '<div class="foto">';
                echo '<span><i class="bx bx-user"></i></span>';
                echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
                echo '</div>';
                echo '<a href="logout.php"><button id="cerrar-sesion">Cerrar sesión</button></a>';
                echo '<a href="dashboard.php"><button id="perfil">Perfil</button></a>'; // Agrega este enlace para ir a dashboard.php
            } else {
                // El usuario no ha iniciado sesión, muestra los botones "Iniciar sesión" y "Registrarse"
                echo '<a href="login.php"><button id="iniciar-sesion">Iniciar sesión</button></a>';
                echo '<a href="signup.php"><button id="registrarse">Registrarse</button></a>';
            }
            ?>
        </nav>
    </header>
    <section id="contactos">
        <h2>Contáctanos</h2>
        <p>Si tienes alguna pregunta o quieres comunicarte con nosotros, puedes hacerlo a través de los siguientes medios:</p>

        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="Imagenes/moto4.jpg" alt="Imagen 1">
                </div>
                <div class="swiper-slide">
                    <img src="ruta_a_tu_imagen_2.jpg" alt="Imagen 2">
                </div>
                <!-- Agrega más imágenes si es necesario -->
            </div>
            <!-- Agrega la paginación y los botones de navegación -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div class="info-contacto">
            <div class="item">
                <i class='bx bxl-facebook' style="color: black;"></i>
                <p> <a href="https://www.facebook.com/Motoclubsbogota/" style="color: black; font-weight: bold;">Moto cluB'S</a></p>
            </div>


            <div class="item">
                <i class='bx bxl-whatsapp' style="color: black;"></i>
                <p> <a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fapi.whatsapp.com%2Fsend%3Fphone%3D%252B573214590866%26data%3DARDHsTjkcwyRnZhocJiP9_KNWuAAVgOelQOYz8LfRR8Ocl27yDJetNv54Ldku2T5eYUQ3Nbtdo73NKf3kZgjgFWriNy1ScbuaQh_S9fvjgmXgCRTs4dwOJ4_kutzAEmkCS7svmg5j9egZFEIOPH7N33sKg%26source%3DFB_Page%26app%3Dfacebook%26entry_point%3Dpage_cta%26fbclid%3DIwAR06mN74HpLTvYjP6ADT1HqISJyxMZtIdt1Dp-4FkENMzJK4armwxvpqyws&h=AT2vWalmizsW0FksxWTmy-BWSFKbS97qJ__N_2K67RyAM2hCxUe1Z_9cFsNrOuwIr6zQX1N4hEMOTLSBxprdPaGp4recoD3NtYmZKZ3GeIDlbZloswtsJUD5jCqqKv7ydQvaOWHokyhpHYP2tpr8SQ" style="color: black; font-weight: bold; "> (+57)321 4590866 </a></p>
            </div>

            <div class="item">
                <i class='bx bx-map'></i>
                <p><a href="https://www.bing.com/search?pglt=41&q=78h19+Av+Cd+de+Villavicencio%2C+Bogot%C3%A1%2C+Colombia&cvid=0a74a846a5504190a8b3cc238b056ec9&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBBzM5NGowajGoAgCwAgA&FORM=ANNTA1&adppc=EDGEESS&PC=U531" style="color: black; font-weight: bold; "> 78h19 Av Cd de Villavicencio, Bogotá, Colombia</a></p>
        </div>
    </section>
</body>

</html>