$(document).ready(function() {

    $.ajax({
        url: 'dashboard_ajax.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
    
            $('#total_usuarios').text('Total de Usuarios Registrados: ' + data.usuarios);
            $('#total_reservas').text('Total de Reservas: ' + data.reservas);
            $('#total_ventas').text('Total de Ventas: ' + data.ventas);
            $('#total_pqrs').text('Total de PQRS: ' + data.pqrs);
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener los totales: ' + error);
        }
    });
});