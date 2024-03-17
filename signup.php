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
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Document</title>
</head>

<body>
    <header>
        <a href="index.php" class="logo"> <img src="Imagenes/Logo.png" alt="Icono de la empresa">Moto Club</a>
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
            <h1>Registrate</h1>
            <form id="registroForm">
                <div class="input">
                    <span><i class='bx bx-envelope'></i></span>
                    <input type="number" name="documentoID" placeholder="Documento de identificación" min="0">
                </div>
                <div class="input">
                    <span><i class='bx bx-envelope'></i></span>
                    <input type="text" name="nombre" placeholder="Nombre completo">
                </div>
                <div class="input">
                    <span><i class='bx bx-phone'></i></span>
                    <input type="number" name="numero" placeholder="Número">
                </div>
                <div class="input">
                    <span><i class='bx bx-envelope'></i></span>
                    <input type="email" name="email" placeholder="Correo electrónico">
                </div>
                <div class="input">
                    <span><i class='bx bx-lock-alt'></i></span>
                    <input type="text" name="dirreccion" placeholder="Dirreción">
                </div>
                <div class="input">
                    <span><i class='bx bx-lock-alt'></i></span>
                    <input type="password" name="password" placeholder="Contraseña">
                </div>

                <button type="button" id="btnRegistrar">REGISTRATE</button>
                <div class="registrar">
                    <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
                </div>

            </form>
        </div>
    </div>
</body>

</html>