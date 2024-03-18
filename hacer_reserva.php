<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="javaScript/reservas.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/reservas.css">
    <title>Reservas</title>
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
    <div class="reservas">
        <h1>Hacer una Reserva</h2>
            <div class="servicios">
                <label for="servicio">Elige un servicio</label>
                <select id="servicio">
                </select>
                <label for="precio">Costo</label>
                <input type="text" id="precio" name="precio">
                <label for="sobre">Sobre el servicio:</label>
                <input type="text" id="sobre" name="sobre">
                <input  type="hidden" id="idServicio">
            </div>
            <h2>Datos de la reserva</h2>
            <div class="div-reserva">

                <form id="reservaForm">
                    
                    <div class="form-group">
                        <label for="descripcion">Descripción del problema:</label>
                        <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" required>
                    </div>
                    <div class="form-group">
                        <label for="hora">Hora:</label>
                        <input type="time" id="hora" name="hora" required>
                    </div>
                    <?php
                    if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
                        // El usuario ha iniciado sesión, muestra el botón de enviar
                        echo '<button type="button" name="submit" id="enviarBtn">Enviar</button>';
                    } else {
                        // El usuario no ha iniciado sesión, muestra un mensaje de inicio de sesión requerido
                        echo '<p>Debes iniciar sesión para poder enviar una PQR.</p>';
                    }
                    ?>
                    <?php if (!empty($mensaje)): ?>
                        <p>
                            <?php echo $mensaje; ?>
                        </p>
                    <?php endif; ?>
                </form>
            </div>
    </div>

</body>

</html>