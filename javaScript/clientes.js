$(document).ready(function () {
    cargarUsuarios();

    $(document).on("click", "#btnEliminarUsuario", function () {
        var idUsuario = $(this).data("id");
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!, todos los datos relacionados con el usuario serán eliminados también',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarUsuario(idUsuario);
            }
        });
    });

    $(document).on("click", "#btnCambiarRol", function () {
        var idUsuario = $(this).data("id");
        Swal.fire({
            title: 'Seleccionar nuevo rol',
            input: 'select',
            inputOptions: {
                '1': 'Administrador',
                '2': 'Empleado',
                '3': 'Usuario',
                '4': 'Tecnico'
            },
            inputPlaceholder: 'Selecciona un rol',
            showCancelButton: true,
            confirmButtonText: 'Cambiar',
            showLoaderOnConfirm: true,
            preConfirm: function (nuevoRol) {
                return $.ajax({
                    type: 'POST',
                    url: 'asignarRol.php',
                    data: { idUsuario: idUsuario, nuevoRol: nuevoRol },
                    dataType: 'json'
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.success) {
                    cargarUsuarios();
                    Swal.fire(
                        '¡Rol cambiado!',
                        'El rol del usuario ha sido cambiado exitosamente.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error',
                        'Hubo un error al cambiar el rol del usuario.',
                        'error'
                    );
                }
            }
        });
    });
});

function cargarUsuarios() {
    $.ajax({
        url: 'clientes_ajax.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#t_inf').empty();

            $.each(data, function (index, usuario) {
                $('#t_inf').append('<tr>' +
                    '<td>' + usuario.documentoID + '</td>' +
                    '<td>' + usuario.nombre + '</td>' +
                    '<td>' + usuario.email + '</td>' +
                    '<td>' + usuario.numero + '</td>' +
                    '<td>' + usuario.dirreccion + '</td>' +
                    '<td>' + usuario.rol_idRol + '</td>' +
                    '<td><a href="editar.php?id=' + usuario.idUsuarios + '"><button class="btn btn-primary">Editar</button></a> | <button class="btn btn-danger" data-id="' + usuario.idUsuarios + '" id="btnEliminarUsuario">Eliminar</button> | <button class="btn btn-secondary" data-id="' + usuario.idUsuarios + '" id="btnCambiarRol">Rol</button></td>' +
                    '</tr>');
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function eliminarUsuario(idUsuario) {
    $.ajax({
        type: 'POST',
        url: 'eliminar.php',
        data: { idUsuario: idUsuario },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                Swal.fire(
                    '¡Eliminado!',
                    'El usuario ha sido eliminado.',
                    'success'
                );
                cargarUsuarios();
            } else {
                Swal.fire(
                    'Error',
                    'Hubo un error al eliminar el usuario.',
                    'error'
                );
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", xhr.responseText);
            Swal.fire(
                'Error',
                'Hubo un error en la solicitud AJAX.',
                'error'
            );
        }
    });
}
