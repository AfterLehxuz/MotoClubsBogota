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

    $("#proveedor").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "buscar_proveedores.php",
                method: "GET",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        maxLength: 2,
        select: function (event, ui) {
            $("#proveedor").val(ui.item.Nombre); 
            $("#proveedorId").val(ui.item.Nip); 
            return false;
        },
        response: function (event, ui) {
            if (!ui.content.length) {
                Swal.fire({
                    icon: 'error',
                    title: 'Proveedor no encontrado',
                    text: 'El proveedor que buscas no existe.',
                    showCancelButton: true,
                    confirmButtonText: 'Ir a proveedores',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'provedores.php';
                    }
                });
            }
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append("<div>" + item.Nombre + "</div>") 
            .appendTo(ul);
    };
});
