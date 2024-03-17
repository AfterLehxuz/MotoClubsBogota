$(document).ready(function () {
    $('#btnRegistrar').click(function () {
        var documentoID = $('input[name="documentoID"]').val();
        var nombre = $('input[name="nombre"]').val();
        var numero = $('input[name="numero"]').val();
        var email = $('input[name="email"]').val();
        var dirreccion = $('input[name="dirreccion"]').val();
        var password = $('input[name="password"]').val();

        console.log("Datos a enviar:", documentoID, nombre, numero, email, dirreccion, password);

        $.ajax({
            type: 'POST',
            url: 'registro_ajax.php',
            data: {
                documentoID: documentoID,
                nombre: nombre,
                numero: numero,
                email: email,
                dirreccion: dirreccion,
                password: password
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Mensaje del servidor",
                        text: response.message,
                        customClass: "alert-animation"
                    });
                    
                    
                    $('input[name="documentoID"]').val('');
                    $('input[name="nombre"]').val('');
                    $('input[name="numero"]').val('');
                    $('input[name="email"]').val('');
                    $('input[name="dirreccion"]').val('');
                    $('input[name="password"]').val('');
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Mensaje del servidor",
                        text: response.message,
                        customClass: "alert-animation"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log("Error en la solicitud:", error);
                Swal.fire({
                    icon: "error",
                    title: "Mensaje del servidor",
                    text: "Hubo un error al procesar la solicitud.",
                    customClass: "alert-animation"
                });
            }
        });
    });
});
