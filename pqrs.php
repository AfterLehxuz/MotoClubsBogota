<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/pqrs.css">
    <link rel="shortcut icon" href="Estilos/imagenes/logo .png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="javaScript/pqrs_ajax.js"></script>
    <link rel="icon" type="image/x-icon" href="Imagenes/Logo(1).ico">
    <title>PQRS</title>
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
            session_start();

            if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
                // El usuario ha iniciado sesión, muestra su nombre en su lugar
                echo '<div class="foto">';
                echo '<span><i class="bx bx-user"></i></span>';
                echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
                echo '</div>';
                echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
                echo '<a href="dashboard.php"><button>Perfil</button></a>';
            } else {
                // El usuario no ha iniciado sesión, muestra los botones "Iniciar sesión" y "Registrarse"
                echo '<a href="login.php"><button>Iniciar sesión</button></a>';
                echo '<a href="signup.php"><button>Registrarse</button></a>';
            }
            ?>
        </nav>
    </header>
    <div class="reservas">

        <h1>PQRS</h1>

        <div class="div-reserva">
            <img src="Imagenes/PQRS.jpg" alt="">
            <form id="reservaForm" method="POST">
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <select id="servicio" name="servicio">
                        <option value="Peticion" id="Peticion">Petición</option>
                        <option value="Queja" id="Queja">Queja</option>
                        <option value="Reclamo" id="Reclamo">Reclamo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="4"></textarea>
                </div>
                <?php
                if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
                    echo '<button type="submit" name="submit" id="enviarBtn">Enviar</button>';
                } else {
                    echo '<p>Debes iniciar sesión para poder enviar una PQR.</p>';
                }
                ?>
            </form>
        </div>
    </div>

    <footer>
        <div class="contactos"></div>
        <div class="redes"></div>
    </footer>
</body>

</html>