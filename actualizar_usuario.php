<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["idUsuario"]) && isset($_POST["documentoID"]) && isset($_POST["nombre"]) && isset($_POST["email"]) && isset($_POST["numero"]) && isset($_POST["dirreccion"])) {
        $idUsuario = $_POST["idUsuario"];
        $documentoID = $_POST["documentoID"];
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $numero = $_POST["numero"];
        $dirreccion = $_POST["dirreccion"];

        if (strlen($documentoID) < 7 || strlen($documentoID) > 10) {
            $response = array(
                "success" => false,
                "message" => "El documento debe tener entre 7 y 10 dígitos."
            );
        } elseif (strlen($numero) != 10) { 
            $response = array(
                "success" => false,
                "message" => "El número debe tener exactamente 10 dígitos."
            );
        } else {
            $query = "SELECT * FROM usuarios WHERE documentoID = '$documentoID' AND idUsuarios != $idUsuario";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $response = array(
                    "success" => false,
                    "message" => "El documento ya está en uso por otro usuario."
                );
            } else {
                $query = "SELECT email FROM usuarios WHERE idUsuarios = $idUsuario";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $correoActual = $row['email'];

                if ($email != $correoActual) {
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
                            $updateQuery = "UPDATE usuarios SET documentoID = '$documentoID', nombre = '$nombre', email = '$email', numero = '$numero', dirreccion = '$dirreccion' WHERE idUsuarios = $idUsuario";
                            $updateResult = mysqli_query($conn, $updateQuery);

                            if ($updateResult) {
                                $response = array(
                                    "success" => true,
                                    "message" => "Los datos se han actualizado correctamente."
                                );
                            } else {
                                $response = array(
                                    "success" => false,
                                    "message" => "Hubo un problema al actualizar los datos del usuario."
                                );
                            }
                        }
                    }
                } else {
                    $updateQuery = "UPDATE usuarios SET documentoID = '$documentoID', nombre = '$nombre', numero = '$numero', dirreccion = '$dirreccion' WHERE idUsuarios = $idUsuario";
                    $updateResult = mysqli_query($conn, $updateQuery);

                    if ($updateResult) {
                        $response = array(
                            "success" => true,
                            "message" => "Los datos se han actualizado correctamente."
                        );
                    } else {
                        $response = array(
                            "success" => false,
                            "message" => "Hubo un problema al actualizar los datos del usuario."
                        );
                    }
                }
            }
        }
    } else {
        $response = array(
            "success" => false,
            "message" => "No se recibieron todos los datos necesarios."
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array(
        "success" => false,
        "message" => "Método de solicitud no válido."
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>