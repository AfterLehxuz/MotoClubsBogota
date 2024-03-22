<?php
session_start();


if (isset($_SESSION["rol"])) {
    header("Location: index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="javaScript/registro_ajax.js"></script>
    <link rel="stylesheet" href="Estilos/signup.css">
    <link rel="stylesheet" href="Estilos/swal.fire.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>Regístrate</title>
    <style>
    .logo img {
        border-radius: 10%; /* Esto hace que la imagen sea redonda */
    }
</style>
</head>

<body>
    <header>
        <a href="index.php" class="logo"> <img src="Imagenes/Logo.png" alt="Icono de la empresa">MOTO ClUBS BOGOTÁ</a>
        <nav>
            <ul>
                <li id="inicio"><a href="index.php">Inicio</a></li>
                <li><a href="reserva.php">Reservas</a></li>
                <li><a href="repuestos.php">Repuestos</a></li>
                <li><a href="pqrs.php">PQRS</a></li>
                <li><a href="contactos.php">Contactos</a></li>
            </ul>
            <a href="login.php"><button class>Iniciar sesión</button></a>
        </nav>
    </header>
    <div class="iniciar-secion">
        <div class="iniciar-secion_inicio">
            <h1>Regístrate</h1>
            <form id="registroForm">
                <div class="input">
                    <span><i class='bx bx-id-card'></i></span>
                    <input type="number" name="documentoID" placeholder="Documento de identificación "  style="font-weight: bold; color: black;">
                </div>
                <div class="input">
                    <span><i class='bx bx-user'></i></span>
                    <input type="text" name="nombre" placeholder="Nombre completo" style="font-weight: bold; color: black;">
                </div>
                <div class="input">
                    <span><i class='bx bx-phone'></i></span>
                    <input type="number" name="numero" placeholder="Número" style="font-weight: bold; color: black;" >
                </div>

                <div class="input">
                    <span><i class='bx bx-envelope '></i></span>
                    <input type="email" name="email" placeholder="Correo electrónico" style="font-weight: bold; color: black;">
                </div>
                <div class="input">
                    <span><i class='bx bx-home'></i></span>
                    <input type="text" name="dirreccion" placeholder="Dirreción" style="font-weight: bold; color: black;">
                </div>
                <div class="input">
                    <span><i class='bx bx-lock-alt'></i></span>
                    <input type="password" name="password" placeholder="Contraseña" style="font-weight: bold; color: black;"    >
                </div>

                <button type="button" id="btnRegistrar">REGISTRATE</button>
                <div class="registrar">
                <p style="color: black;">¿Ya tienes una cuenta? <a href="login.php" style="color: red;">Inicia sesión</a></p>

                </div>

            </form>
        </div>
    </div>
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