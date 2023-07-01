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
    <link rel="shortcut icon" href="Estilos/imagenes/logo .png" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <header>
        <a href="#" class="logo"> <img src="Imagenes/Logo .png" alt="Icono de la empresa">Moto Club</a>
        <nav>
            <ul>
                <li id="inicio"><a href="#" >Inicio</a></li>
                <li><a href="#">Reservas</a></li>
                <li><a href="#">Repuestos</a></li>
                <li><a href="#">PQRS</a></li>
                <li><a href="#">Contactos</a></li>
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
    <div class="container">
		<h1 class="text-center">Libro de reclamaciones</h1>
		<form class="col-sm-6 col-sm-offset-3" action="reclamacion.php" method="POST">
			<div class="form-group">
				<label>Nombre *</label>
				<input type="text" class="form-control" placeholder="Ej. Cesar">
			</div>
			<div class="form-group">
				<label>Apellido *</label>
				<input type="text" class="form-control" placeholder="Ej. Aquino Maximiliano">
			</div>
			<div class="form-group">
				<label>Dirección *</label>
				<input type="text" class="form-control" placeholder="Ej. Av. Los Angeles 1025">
			</div>
			<div class="form-group">
				<label>Distrito *</label>
				<input type="text" class="form-control" placeholder="Ej. Villa El Salvador">
			</div>
			<div class="form-group">
				<label>Documento de Identidad*</label>
				<select class="form-control">
					<option>-Ninguno-</option>
					<option value="D.N.I.">D.N.I.</option>
					<option value="C.E.">C.E.</option>
					<option value="Menor de edad">Menor de edad</option>
				</select>
			</div>
			<div class="form-group">
				<label>N° doc. Identidad *</label>
				<input type="text" class="form-control" placeholder="Ej. 40125201">
			</div>
			<div class="form-group">
				<label>Correo electrónico *</label>
				<input type="email" class="form-control" placeholder="Ej. nombre@correo.com">
			</div>
			<div class="form-group">
				<label>Teléfono alternativo *</label>
				<input type="text" class="form-control" placeholder="Ej. 1 294-0008">
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-md-3">Papá Mamá *</label>
					<div class="col-md-9">
						<input type="text" class="form-control" placeholder="Ej. Luis">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Monto a reclamar (S/.)</label>
				<input type="text" class="form-control" placeholder="Ej. 200">
			</div>
			<label class="radio-inline">
				<input type="radio" name="tipo" checked> Producto
			</label>
			<label class="radio-inline">
				<input type="radio" name="tipo"> Servicio
			</label>
			<div class="form-group">
				<label>Descripcion</label>
				<textarea class="form-control" rows="5"></textarea>
			</div>
			<input type="submit" class="btn btn-block btn-lg btn-primary">
		</form>
		<p>&nbsp;</p>

	</div>
    <footer>
        <div class="contactos">

        </div>
        <div class="redes">

        </div>
    </footer>
</body>
</html>
