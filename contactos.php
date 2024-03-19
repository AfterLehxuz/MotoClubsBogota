<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <link rel="stylesheet" href="Estilos/contactos.css">
    <link rel="shortcut icon" href="Estilos/imagenes/logo.png" type="image/x-icon">
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Contactos</title>
    <style>
    .logo img {
        border-radius: 10%; /* Esto hace que la imagen sea redonda */
    }
</style>
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
                echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
                echo '<a href="dashboard.php"><button>Perfil</button></a>'; // Agrega este enlace para ir a dashboard.php
            } else {
                // El usuario no ha iniciado sesión, muestra los botones "Iniciar sesión" y "Registrarse"
                echo '<a href="login.php"><button>Iniciar sesión</button></a>';
                echo '<a href="signup.php"><button>Registrarse</button></a>';
            }

            ?>
        </nav>
    </header>
    <section id="contactos">
        <h2>Contáctanos</h2>
        <p>Si tienes alguna pregunta o quieres comunicarte con nosotros, puedes hacerlo a través de los siguientes
            medios:</p>
        <div class="info-contacto">
            <div class="item">

                <i class= 'bx bxl-facebook' style="color: black;"></i>
                
                <p> <a href="https://www.facebook.com/Motoclubsbogota/" style="color: black; font-weight: bold;">Moto cluB'S</a></p>
            </div>

            <div class="item">
                <i class='bx bxl-whatsapp' style="color: black;"></i>
                <p> <a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fapi.whatsapp.com%2Fsend%3Fphone%3D%252B573214590866%26data%3DARDHsTjkcwyRnZhocJiP9_KNWuAAVgOelQOYz8LfRR8Ocl27yDJetNv54Ldku2T5eYUQ3Nbtdo73NKf3kZgjgFWriNy1ScbuaQh_S9fvjgmXgCRTs4dwOJ4_kutzAEmkCS7svmg5j9egZFEIOPH7N33sKg%26source%3DFB_Page%26app%3Dfacebook%26entry_point%3Dpage_cta%26fbclid%3DIwAR06mN74HpLTvYjP6ADT1HqISJyxMZtIdt1Dp-4FkENMzJK4armwxvpqyws&h=AT2vWalmizsW0FksxWTmy-BWSFKbS97qJ__N_2K67RyAM2hCxUe1Z_9cFsNrOuwIr6zQX1N4hEMOTLSBxprdPaGp4recoD3NtYmZKZ3GeIDlbZloswtsJUD5jCqqKv7ydQvaOWHokyhpHYP2tpr8SQ" style="color: black; font-weight: bold; "> (+57)321 4590866 </a></p>
            </div>

            <div class="item">
                <i class='bx bx-map' style="color: black;"></i>
                <p> <a href="https://www.bing.com/search?pglt=41&q=78h19+Av+Cd+de+Villavicencio%2C+Bogot%C3%A1%2C+Colombia&cvid=0a74a846a5504190a8b3cc238b056ec9&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBBzM5NGowajGoAgCwAgA&FORM=ANNTA1&adppc=EDGEESS&PC=U531" style="color: black; font-weight: bold; "> 78h19 Av Cd de Villavicencio, Bogotá, Colombia</a></p> </p>
            </div>

        </div>

        <form action="enviar.php" method="post">
            <h3>Formulario de contacto</h3>
            <input type="text" name="nombre" placeholder="Tu nombre" required>
            <input type="email" name="correo" placeholder="Tu correo electrónico" required>
            <textarea name="mensaje" placeholder="Tu mensaje" required></textarea>
            <button type="submit"" >Enviar mensaje</button>
        </form>
    </section>


    <footer>
    </footer>
</body>

</html>