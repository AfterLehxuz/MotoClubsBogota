$(document).ready(function() {
    $('#guardarPerfilForm').submit(function(e) {
        e.preventDefault();

        var codigoProveedor = $('#Codigo_Proveedor').val();
        var nombre = $('#nombre').val();
        var email = $('#email').val();
        var numero = $('#numero').val();
        var dirreccion = $('#dirreccion').val();

        if (codigoProveedor === '' || nombre === '' || email === '' || numero === '' || dirreccion === '') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son requeridos'
            });
            return;
        }

        if (numero.length !== 10) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El número de teléfono debe tener 10 dígitos'
            });
            return;
        }

        $.ajax({
            url: 'registrar_proveedores.php',
            method: 'POST',
            data: $('#guardarPerfilForm').serialize(),
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'provedores.php';
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
