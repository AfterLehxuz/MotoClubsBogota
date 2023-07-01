<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Estilos/dashboard.css">
    <title>Document</title>
</head>
<body>
    <aside>
        <a href="dashboard.php" class="log"><img src="Logo .png" alt="logo">Moto Club</a>
        <ul>
             <li><a href="perfil.php"><span><i class='bx bx-face'></i></span>Perfil</a></li>
            <li><a href="inventario.php"><span><i class='bx bxs-cabinet'></i></span>Inventario</a></li>
            <li><a href="#"><span><i class='bx bx-check-double'></i></span>Reservas</a></li>
            <li><a href="pqrsdb.php"><span><i class='bx bx-question-mark'></i></span>PQRS</a></li>
            <li><a href="clientes.php"><span><i class='bx bx-briefcase' ></i></span>clientes</a></li>
        </ul>
    </aside>
    <div class="contenido">
        <header>
            <div class="contenido-buscar">
                <span><i class='bx bx-search-alt-2' ></i></span>
                <input type="search" placeholder="Buscar">
            </div>
            <div class="contenido-perfil">
                <span><i class='bx bx-bell'></i></span>
                <span><i class='bx bx-message-dots'></i></span>
                
                <?php
                session_start();
             if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
                echo '<div class="foto">';             
                echo '<span class="nombre-usuario">' . $_SESSION["nombre"] . '</span>';
                echo '</div>';
                echo '<a href="logout.php"><button>Cerrar sesión</button></a>';
              }
              ?>
            </div>
        </header>
        <div class="reservas">
            <div class="reservas-inicio">
                <h1>RESERVAS</h1>
            </div>
        </div>
    </div>
</body>
</html>