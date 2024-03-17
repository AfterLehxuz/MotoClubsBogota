$(document).ready(function () {
    $("#reservaForm").submit(function (event) {
        event.preventDefault();

        var tipo = $("#servicio").val();
        var descripcion = $("#descripcion").val();

        if (tipo && descripcion) {
            console.log("Datos a enviar:", $("#reservaForm").serialize());

            $.ajax({
                type: "POST",
                url: "pqrs_ajax.php",
                data: $("#reservaForm").serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // Éxito
                        Swal.fire({
                            icon: "success",
                            title: "Éxito",
                            text: response.mensaje,
                        });

                        // Vaciar campos del formulario
                        $("#reservaForm")[0].reset();
                    } else {
                        // Error
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.mensaje,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error en la solicitud AJAX:", xhr.responseText);
                    console.log("Status:", status);
                    console.log("Error:", error);
                }
            });
        } else {
            Swal.fire({
                icon: "warning",
                title: "Faltan datos",
                text: "Por favor, complete los campos antes de enviar la PQRS.",
            });
        }
    });
});
