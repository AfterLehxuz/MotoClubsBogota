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
    <div class="iniciar-secion">
            <div class="iniciar-secion_inicio">
                <h1>inicia sesión</h1>

                <form method="POST">
                <div class="input">
    <span><i class='bx bx-envelope'></i></span>
    <input type="email" name="email" placeholder="Correo electrónico" style="font-weight: bold;">
</div>
                    <div class="input">
                        <span><i class='bx bx-lock-alt'></i></span>
                        <input type="password" name="password" placeholder="Contraseña" style="font-weight: bold;">
                    </div>
                    
                    <button type="submit" id="btnLogin">Iniciar sesión</button>

                    <div class="registrar">
                    <p><span>¿No tienes cuenta? <a href="signup.php" style="color: red;">Regístrate</a></span></p>
                    </div>
                </form>
            </div>
        </div>
        <div class="image-container">
            <img src="Imagenes/Logo.png" alt="Imagen de ejemplo">
        </div>
    </section>

</body>

</html>