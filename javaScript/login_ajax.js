$(document).ready(function() {
    $('form').submit(function(e) {
        e.preventDefault(); // Evitar el envío del formulario por defecto

        // Obtener los datos del formulario
        var email = $('input[name="email"]').val();
        var password = $('input[name="password"]').val();

        // Realizar la petición AJAX
        $.ajax({
            type: 'POST',
            url: 'login_ajax.php',
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                // Mostrar mensajes de acuerdo a la respuesta del servidor
                Swal.fire({
                    icon: response.includes('éxito') ? "success" : "error",
                    title: "Bienvenido",
                    text: response,
                    customClass: "alert-animation",
                    didClose: () => {
                        
                        if (response.includes('éxito')) {
                            window.location.href = 'index.php';
                        }
                    }
                });
            }
        });
    });
});
