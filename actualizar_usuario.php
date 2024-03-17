<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documentoID = $_POST["documentoID"];
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $numero = $_POST["numero"];
    $dirreccion = $_POST["dirreccion"];
    $password = $_POST["password"];
    $defaultRoleId = 4;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array(
            "success" => false,
            "message" => "El formato del correo electrónico es incorrecto."
        );
    } else {
        $query = "SELECT * FROM usuarios WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $response = array(
                "success" => false,
                "message" => "El correo electrónico ya está en uso por otro usuario."
            );
        } else {
            $query = "SELECT * FROM usuarios WHERE documentoID = '$documentoID'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $response = array(
                    "success" => false,
                    "message" => "El documento ID ya está en uso por otro usuario."
                );
            } else {
             
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $insertQuery = "INSERT INTO usuarios (documentoID, nombre, email, numero, dirreccion, password, rol_idRol) VALUES ('$documentoID', '$nombre', '$email', '$numero', '$dirreccion', '$hashedPassword', '$defaultRoleId')";
                $insertResult = mysqli_query($conn, $insertQuery);

                if ($insertResult) {
                    $response = array(
                        "success" => true,
                        "message" => "El usuario se ha registrado correctamente."
                    );
                } else {
                    $response = array(
                        "success" => false,
                        "message" => "Hubo un problema al registrar el usuario."
                    );
                }
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

