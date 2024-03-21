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
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Moto Clud's Bogotá</title>
    <style>
        .logo img {
            border-radius: 10%; /* Esto hace que la imagen sea redonda */
        }

      
    </style>
</head>

<body>
    <header>
    <a href="index.php" class="logo"> 
        <img src="Imagenes/Logo.png" alt="Icono de la empresa">MOTO ClUB'S BOGOTÁ
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
        <div class="info-contacto">
            <div class="item">
                <i class='bx bxl-facebook'></i>
                <p><a href="https://www.facebook.com/Motoclubsbogota/" style="color: white;font-weight: bold;">Moto cluB'S</a></p>
            </div>
            <div class="item">
                <i class=' bx bx-map'></i>
                <p><a href="https://www.bing.com/search?pglt=41&q=78h19+Av+Cd+de+Villavicencio%2C+Bogot%C3%A1%2C+Colombia&cvid=0a74a846a5504190a8b3cc238b056ec9&gs_lcrp=EgZjaHJvbWUyBggAEEUYOdIBBzM5NGowajGoAgCwAgA&FORM=ANNTA1&adppc=EDGEESS&PC=U531" style="color: white;font-weight: bold;">78h19 Av Cd de Villavicencio, Bogotá, Colombia</a></p>
            </div>
                <div class="item">
                    <i class='bx bxl-whatsapp'></i>
                    <p><a href="https://l.facebook.com/l.php?u=https%3A%2F%2Fapi.whatsapp.com%2Fsend%3Fphone%3D%252B573214590866%26data%3DARDHsTjkcwyRnZhocJiP9_KNWuAAVgOelQOYz8LfRR8Ocl27yDJetNv54Ldku2T5eYUQ3Nbtdo73NKf3kZgjgFWriNy1ScbuaQh_S9fvjgmXgCRTs4dwOJ4_kutzAEmkCS7svmg5j9egZFEIOPH7N33sKg%26source%3DFB_Page%26app%3Dfacebook%26entry_point%3Dpage_cta%26fbclid%3DIwAR06mN74HpLTvYjP6ADT1HqISJyxMZtIdt1Dp-4FkENMzJK4armwxvpqyws&h=AT2vWalmizsW0FksxWTmy-BWSFKbS97qJ__N_2K67RyAM2hCxUe1Z_9cFsNrOuwIr6zQX1N4hEMOTLSBxprdPaGp4recoD3NtYmZKZ3GeIDlbZloswtsJUD5jCqqKv7ydQvaOWHokyhpHYP2tpr8SQ" style="color: white;font-weight: bold;">(+57)321 4590866 </a></p>
                </div>
        </div>
    </footer>
</body>

</html>