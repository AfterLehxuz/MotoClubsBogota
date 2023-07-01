<?php
 require 'conexion.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

require 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contra"];

    if (!empty($correo) && !empty($contrasena)) {
        $consulta = "SELECT * FROM usuarios WHERE email = '$correo'";
        $result = $conn->query($consulta);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row["password"];

            if (password_verify($contrasena, $hashedPassword)) {
                $_SESSION["loggedin"] = true;
            
                // Consulta para obtener el nombre del usuario
                $nombreConsulta = "SELECT nombre FROM usuarios WHERE email = '$correo'";
                $nombreResultado = $conn->query($nombreConsulta);
            
                if ($nombreResultado->num_rows == 1) {
                    $nombreRow = $nombreResultado->fetch_assoc();
                    $_SESSION["nombre"] = $nombreRow["nombre"]; 
                    header("Location: index.php");
                exit();
                }
            } else {
                $mensaje = "La contraseña es incorrecta.";
            }
        } else {
            $mensaje = "El correo electrónico no está registrado.";
        }
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/login.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="index.php" class="logo"> <img src="Logo .png" alt="Icono de la empresa">Moto Club</a>
        <nav>
            <ul>
                <li id="inicio"><a href="index.php" >Inicio</a></li>
                <li><a href="#">Reservas</a></li>
                <li><a href="#">Repuestos</a></li>
                <li><a href="#">PQRS</a></li>
                <li><a href="#">Contactos</a></li>
            </ul>
            <?php if (isset($_SESSION['usuario'])): ?>
                <div class="usuario-logged-in">
                    <span><i class='bx bx-user'></i></span>
                    <span><?php echo $_SESSION['usuario']; ?></span>
                </div>
            <?php else: ?>
                <a href="signup.php"><button>Registro</button></a>
            <?php endif; ?>
        </nav>
    </header>
    
    <div class="iniciar-secion"> 
        <div class="iniciar-secion_inicio">
            <h1>inicia sesión</h1>
            <?php if (!empty($mensaje)): ?>
              
                    <p><?php echo $mensaje; ?></p>
                
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="input">
                    <span><i class='bx bx-envelope'></i></span>
                    <input type="email" name="correo" placeholder="Correo electronico">
                </div>
                <div class="input">
                    <span><i class='bx bx-lock-alt' ></i></span>
                    <input type="password" name="contra" placeholder="Contraseña">
                </div>
                <div class="recordar">
                    <label for="recuerdame"><input type="checkbox" id="recuerdame"> Recuerdame</label>
                    <a href="#">¿Olvidaste tu contraseña?</a>
                </div>
                <button>Iniciar sesión</button>
                
                <div class="registrar">
                    <p>¿No tienes cuenta? <a href="signup.php">Registrate</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
