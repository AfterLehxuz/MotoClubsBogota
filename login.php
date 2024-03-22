<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <script src="javaScript/login_ajax.js"></script>
    <title>Iniciar Sesión</title>
    <style>
        .logo img {
            border-radius: 10%;
            /* Esto hace que la imagen sea redonda */
        }      
    </style>
</head>

<body>
    <header>
        <a href="index.php" class="logo"> <img src="Imagenes/Logo.png" alt="Icono de la empresa">MOTO ClUB'S
            BOGOTÁ</a>
        <nav>
            <ul>
                <li id="inicio"><a href="index.php">Inicio</a></li>
                <li><a href="reserva.php">Reservas</a></li>
                <li><a href="repuestos.php">Repuestos</a></li>
                <li><a href="pqrs.php">PQRS</a></li>
                <li><a href="contactos.php">Contactos</a></li>
            </ul>
            <a href="signup.php"><button class>Registrate</button></a>
        </nav>
    </header>
    <section class="fondo">
        <div class="container">
            <div class="image-container">
                <img src="Imagenes/Logo.png" alt="Imagen de ejemplo">
            </div>
            <div class="iniciar-sesion">
                <div class="iniciar-sesion_inicio">
                    <h1>Iniciar Sesión</h1>

                    <form method="POST">
                        <div class="input">
                            <span><i class='bx bx-envelope'></i></span>
                            <input type="email" name="email" placeholder="Correo electrónico" style="font-weight: bold; color: black;">
                        </div>
                        <div class="input">
                            <span><i class='bx bx-lock-open-alt'></i></span>
                            <input type="password" name="password" placeholder="Contraseña" style="font-weight: bold; color: black;">
                        </div>
                        <div class="recordar">
                            <label for="recuerdame"><input type="checkbox" id="recuerdame"> Recuérdame</label>
                            <a href="#"></a>
                        </div>
                        <button type="submit" id="btnLogin" style="background-color: black; color: white;">Iniciar sesión</button>
                        <div class="registrar">
                            <p>¿No tienes cuenta? <a href="signup.php">Regístrate</a></p>
                        </div>
                    </form>
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
