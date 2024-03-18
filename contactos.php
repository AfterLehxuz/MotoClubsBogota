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
                <i class='bx bx-envelope'></i>
                <p>correo@motoclub.com</p>
            </div>
            <div class="item">
                <i class='bx bx-phone'></i>
                <p>(+57) 1 234 5678</p>
            </div>
            <div class="item">
                <i class='bx bx-map'></i>
                <p>Cra. 12 # 34-56, Bogotá, Colombia</p>
            </div>
        </div>
        <form action="enviar.php" method="post">
            <h3>Formulario de contacto</h3>
            <input type="text" name="nombre" placeholder="Tu nombre" required>
            <input type="email" name="correo" placeholder="Tu correo electrónico" required>
            <textarea name="mensaje" placeholder="Tu mensaje" required></textarea>
            <button type="submit">Enviar mensaje</button>
        </form>
    </section>


    <footer>
    </footer>
</body>

</html>