$(document).ready(function () {
    $("#register-form").submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "recuperar_gmail.php",
            data: formData,
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    alert(data.message);
                    // Aquí puedes redirigir al usuario a una página de éxito o realizar otra acción
                } else {
                    alert(data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(jqXHR.responseText);
                alert("Error en la solicitud AJAX. Consulta la consola para más detalles.");
            }
        });
    });
});
