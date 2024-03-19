<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Reservas</title>

    <link rel="stylesheet" href="Estilos/reserva_slide.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />

    <link rel="stylesheet" href="Estilos/slick-theme.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="javaScript/slider.js"></script>
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
    <section class="general">
        <div class="slider-container">
            <div class="slider-item">
                <img src="Imagenes/moto1.jpg" alt="Imagen 1">
                <h2>Mantenimiento general</h2>
                <p>Potencia la durabilidad y el rendimiento de tu moto con nuestro servicio de Mantenimiento General. Desde ajustes precisos hasta revisiones exhaustivas, cuidamos cada detalle para asegurar que tu moto esté siempre en su mejor forma. Confía en nosotros para mantenerla lista para la carretera.
                ¡Haz que cada viaje sea suave y emocionante con nuestro servicio de Mantenimiento General para motos!</p>
                <a href="hacer_reserva.php"><button>Reservar</button></a>
            </div>
            <div class="slider-item">
                <img src="Imagenes/moto4.jpg" alt="Imagen 2">
                <h2>Sincronizacion</h2>
                <p>Experimenta la máxima armonía en cada paseo con nuestro servicio de Sincronización para motos. Ajustamos cada componente con precisión para optimizar el rendimiento del motor, garantizando una conducción suave y eficiente. Confía en nosotros para sincronizar tu moto y disfruta de la potencia en perfecta sintonía.
                Haz que cada viaje sea una experiencia excepcional con nuestro servicio de Sincronización para motos.</p>
                <a href="hacer_reserva.php"><button>Reservar</button></a>
            </div>
            <div class="slider-item">
                <img src="Imagenes/moto5.jpeg" alt="Imagen 2">
                <h2>Reparacion de motor</h2>
                <p>Devuelve la potencia y la confiabilidad a tu moto con nuestro servicio experto de Reparación de Motor.</p>
                <a href="hacer_reserva.php"><button>Reservar</button></a>
            </div>
        </div>

    </section>
    <footer>
    </footer>
</body>

</html>