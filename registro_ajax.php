<?php
require 'conexion.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documentoID = $_POST["documentoID"];
    $nombre = $_POST["nombre"];
    $numero = $_POST["numero"];
    $email = $_POST["email"];
    $dirreccion = $_POST["dirreccion"];
    $password = $_POST["password"];
    $defaultRoleId = 3;

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["success"] = false;
        $response["message"] = "El correo electrónico no tiene un formato válido.";
    }
    elseif (!preg_match('/^\d{7,10}$/', $documentoID)) {
        $response["success"] = false;
        $response["message"] = "El documento de identificación debe tener entre 7 y 10 dígitos.";
    } 
    elseif (!preg_match('/^\d{10}$/', $numero)) {
        $response["success"] = false;
        $response["message"] = "El número de teléfono debe tener exactamente 10 dígitos.";
    } else {
     
        $verificarEmail = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultEmail = $conn->query($verificarEmail);

        if ($resultEmail->num_rows > 0) {
            $response["success"] = false;
            $response["message"] = "El correo electrónico ya está registrado. Por favor, elige otro.";
        } else {
        
            $verificarDocumentoID = "SELECT * FROM usuarios WHERE documentoID = '$documentoID'";
            $resultDocumentoID = $conn->query($verificarDocumentoID);

            if ($resultDocumentoID->num_rows > 0) {
                $response["success"] = false;
                $response["message"] = "El documento de identificación ya está registrado. Por favor, elige otro.";
            } else {
          
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insertQuery = "INSERT INTO usuarios (documentoID, nombre, email, numero, dirreccion, password, rol_idRol) VALUES ('$documentoID', '$nombre', '$email', '$numero', '$dirreccion', '$hashedPassword', '$defaultRoleId')";
                $insertResult = $conn->query($insertQuery);

                if ($insertResult) {
                    $response["success"] = true;
                    $response["message"] = "El usuario se ha registrado correctamente.";
                } else {
                    $response["success"] = false;
                    $response["message"] = "Hubo un problema al registrar el usuario.";
                }
            }
        }
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
