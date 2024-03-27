$(document).ready(function () {
    $("#agregarProductoForm").submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "agregar_producto.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                var respuesta = JSON.parse(data);

                if (respuesta.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: respuesta.mensaje
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: respuesta.mensaje
                    }).then(function () {
                        // Puedes redirigir a otra página o realizar acciones adicionales después del éxito.
                        window.location.href = "Inventario.php";
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud AJAX.'
                });
            }
        });
    });
});
