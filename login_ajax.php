<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validar campos y realizar operaciones necesarias
    if (!empty($email) && !empty($password)) {
        // Verificar si el correo electrónico existe en la base de datos
        $verificarEmail = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultEmail = $conn->query($verificarEmail);

        if ($resultEmail->num_rows > 0) {
            // Obtener la información del usuario
            $row = $resultEmail->fetch_assoc();
            $hashedPassword = $row["password"];

            if (password_verify($password, $hashedPassword)) {
              
                session_start();
                $_SESSION["rol"] = $row["idUsuarios"];
                $_SESSION["rol_idRol"] = $row["rol_idRol"];
                $_SESSION["nombre"] = $row["nombre"];
                echo "éxito, " . $row["nombre"];
                exit();
            } else {
                echo "Contraseña incorrecta. Inténtalo de nuevo."; 
            }
        } else {
            echo "Correo electrónico no registrado. Regístrate para crear una cuenta."; 
        }
    } else {
        echo "Por favor, completa todos los campos."; 
    }
}

$conn->close();

 