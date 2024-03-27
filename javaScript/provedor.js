$(document).ready(function() {
    $("#buscarProvedor").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "buscar_proveedores.php",
                method: "GET",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            var proveedor = ui.item;
            agregarProveedorATabla(proveedor);
            $("#buscarProvedor").val(""); 
            return false; 
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>")
            .append("<div>" + item.Codigo_Proveedor + " - " + item.Nombre + "</div>")
            .appendTo(ul);
    };
    
    function agregarProveedorATabla(proveedor) {
        var codigoProveedor = proveedor.Codigo_Proveedor;
        var nombreProveedor = proveedor.Nombre;
        
        var telefonoProveedor = proveedor.Telefono;
        var direccionProveedor = proveedor.Direccion;
        var emailProveedor = proveedor.Email;
    
       
        var fila = '<tr>' +
            '<td>' + codigoProveedor + '</td>' +
            '<td>' + nombreProveedor + '</td>' +
            '<td>' + telefonoProveedor + '</td>' +
            '<td>' + direccionProveedor + '</td>' +
            '<td>' + emailProveedor + '</td>' +
            '<td> <button class="btn btn-danger btnEliminarProvedor" data-id="' + proveedor.Nip + '">Eliminar</button> <button class="btn btn-success btnEditarProvedor" data-id="' + proveedor.Nip + '">Editar</button>' +  
            '</tr>';
    
        $("#t_ventas_hist tbody").append(fila);
    }
    
   
    function cargarProveedores() {
        $.ajax({
            url: 'proveedores.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#t_pro').empty();
                response.forEach(function(proveedor) {
                    $('#t_pro').append('<tr>' +
                        '<td hidden>' + proveedor.Nip + '</td>' +
                        '<td>' + proveedor.Codigo_Proveedor + '</td>' +
                        '<td>' + proveedor.Nombre + '</td>' +
                        '<td>' + proveedor.Telefono + '</td>' +
                        '<td>' + proveedor.Direccion + '</td>' +
                        '<td>' + proveedor.Email + '</td>' +
                        '<td> <button class="btn btn-danger btnEliminarProvedor" data-id="' + proveedor.Nip + '">Eliminar</button> <button class="btn btn-success btnEditarProvedor" data-id="' + proveedor.Nip + '">Editar</button>' +
                        '</tr>');
                });
            }
        });
    }

    cargarProveedores();

    $(document).on('click', '.btnEliminarProvedor', function() {
        var proveedorId = $(this).data('id');

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'eliminar_provedor.php',
                    method: 'POST',
                    data: { proveedorId: proveedorId },
                    success: function(response) {
                        cargarProveedores();
                        Swal.fire(
                            'Eliminado',
                            'El proveedor ha sido eliminado correctamente',
                            'success'
                        );
                    }
                });
            }
        });
    });

    $(document).on("click", ".btnEditarProvedor", function () {
        var Nip = $(this).data("id");
        window.location.href = 'editar_provedor.php?id=' + Nip;
    });


});