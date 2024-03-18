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
    <link rel="stylesheet" href="Estilos/landing.css">
    <link rel="icon" type="image/x-icon" href="Imagenes/favicon.ico">
    <title>Document</title>
</head>

<body>
    <header>
    <a href="index.php" class="logo"> 
        <img src="Imagenes/Logo.png" alt="Icono de la empresa">Moto Club
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
            if (isset($_SESSION["nombre"]) && $_SESSION["nombre"]) {
                echo '<div class="foto">';
                echo '<span><i class="bx bx-user"></i></span>';
                echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
                echo '</div>';
                echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
                echo '<a href="dashboard.php"><button>Perfil</button></a>'; 
            } else {
                echo '<a href="login.php"><button>Iniciar sesión</button></a>';
                echo '<a href="signup.php"><button>Registrarse</button></a>';
            }
            ?>
        </nav>
    </header>
    <section class="general">
        <div class="Informacion">
            <H1>Proporcionamos la mejor estrategía<br>
                para el cuidado y mantenimiento de tu moto</H1>
            <a href="contactos.php">
               <button> DESCUBRE AQUÍ</button>
            </a>
        </div>
        <div class="informacion-detallada">
            <div class="informacion-detallada-contenido">
                <div class="informacion-detallada-contenido-foto">
                    <span><i class='bx bx-wrench'></i></span>
                </div>
                <div class="informacion-detallada-contenido-texto">
                    <h3>Herramientas</h3>
                    <p>El centro cuenta con las mejores herramientas para llevar a cabo
                        de la forma más profesional todos los trabajos.
                    </p>
                </div>
            </div>
            <div class="informacion-detallada-contenido">
                <div class="informacion-detallada-contenido-foto">
                    <span><i class='bx bx-shield-minus'></i></i></span>
                </div>
                <div class="informacion-detallada-contenido-texto">
                    <h3>Seguridad</h3>
                    <p>El centro cuenta con todas las normas, además de contar con espacios limpios
                        y aptos para el trabajo.
                    </p>
                </div>
            </div>
            <div class="informacion-detallada-contenido">
                <div class="informacion-detallada-contenido-foto">
                    <span><i class='bx bxs-user-check'></i></span>
                </div>
                <div class="informacion-detallada-contenido-texto">
                    <h3>Personal</h3>
                    <p>El centro cuenta con personas con muchos años de experiencia, técnicos y gente que tiene
                        la capacidad de brindar el mejor servicio posible.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="contactos">

        </div>
        <div class="redes">

        </div>
    </footer>
</body>

</html>