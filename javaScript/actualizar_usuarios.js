
$(document).ready(function() {
    $("#editarPerfilForm").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

    
        $.ajax({
            url: 'actualizar_usuario.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                   
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Los datos se han actualizado correctamente.'
                    }).then((result) => {
                        
                        window.location.href = "clientes.php";
                    });
                } else {
              
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
              
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.'
                });
                console.error(xhr.responseText);
            }
        });
    });

   
    $("#cancelarEdicion").on("click", function() {
        Swal.fire({
            title: '¿Seguro que quieres cancelar la edición?',
            text: 'Los cambios no se guardarán.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "clientes.php";
            }
        });
    });
});

