$(document).ready(function () {
    $("#editarProductoForm").submit(function (event) {
        event.preventDefault();

        var formData = new FormData($(this)[0]);

        $.ajax({
            url: 'actualizar_producto.php', 
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                try {
                    var response = JSON.parse(data);
                    
                    if (response.status === "success") {
                        Swal.fire({
                            title: 'Éxito',
                            text: response.mensaje,
                            icon: 'success',
                        }).then(function () {
                            window.location.href = 'Inventario.php';
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.mensaje,
                            icon: 'error',
                        });
                    }
                } catch (error) {
                    console.error("Error al analizar JSON: ", error);
                }
            },
            error: function (data) {
                Swal.fire({
                    title: 'Error',
                    text: 'Error al actualizar el producto',
                    icon: 'error',
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});
