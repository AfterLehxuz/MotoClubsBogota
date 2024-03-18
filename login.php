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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <script src="javaScript/login_ajax.js"></script>
    <title>Iniciar Sesión</title>
</head>

<body>
    <header>
        <a href="index.php" class="logo"> <img src="Imagenes/Logo.png" alt="Icono de la empresa">Moto Clubs Bogota</a>
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
                <h1>Iniciar Sesión</h1>

                <form method="POST">
                    <div class="input">
                        <span><i class='bx bx-envelope'></i></span>
                        <input type="email" name="email" placeholder="Correo electrónico">
                    </div>
                    <div class="input">
                        <span><i class='bx bx-lock-open-alt'></i></span>
                        <input type="password" name="password" placeholder="Contraseña">
                    </div>
                    <div class="recordar">
                        <label for="recuerdame"><input type="checkbox" id="recuerdame"> Recuérdame</label>
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </div>
                    <button type="submit" id="btnLogin">Iniciar sesión</button>

                    <div class="registrar">
                        <p>¿No tienes cuenta? <a href="signup.php">Regístrate</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>