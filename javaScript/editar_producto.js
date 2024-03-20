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
    
    $("#newProveedor").autocomplete({
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
        maxLength: 5, 
        select: function (event, ui) {
            $("#newProveedor").val(ui.item.Nombre); 
            $("#newProveedorId").val(ui.item.Nip);
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
