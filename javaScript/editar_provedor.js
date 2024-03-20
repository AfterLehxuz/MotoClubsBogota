$(document).ready(function() {
    $('#editarProveedorForm').submit(function(e) {
        e.preventDefault();

        var idProveedor = $('#idProveedor').val();
        var codigoProveedor = $('#codigoProveedor').val();
        var nombre = $('#nombre').val();
        var email = $('#email').val();
        var telefono = $('#telefono').val();
        var direccion = $('#direccion').val();

        if (codigoProveedor === '' || nombre === '' || email === '' || telefono === '' || direccion === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son requeridos'
            });
            return;
        }
   
        if (telefono.length !== 10) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El número de teléfono debe tener 10 dígitos'
            });
            return;
        }

        $.ajax({
            url: 'actualizar_provedor.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'provedores.php';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            }
        });
    });
});
