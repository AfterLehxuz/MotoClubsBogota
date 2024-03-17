$(document).ready(function () {
    function cargarOpcionesServicio() {
        $.ajax({
            type: 'GET',
            url: 'opciones_servicio.php',
            dataType: 'json',
            success: function (response) {
                console.log('Respuesta de la solicitud AJAX:', response);
                if (response.success) {
                    $('#servicio').empty();

                    response.data.forEach(function (opcion) {
                        $('#servicio').append('<option value="' + opcion + '">' + opcion + '</option>');
                        console.log('Nombre del servicio obtenido:', opcion);
                    });
                } else {
                    console.error('Error al cargar opciones de servicio:', response.mensaje);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud Ajax:', status, error);
            }
        });
    }

    cargarOpcionesServicio();

  
    $('#servicio').change(function () {
        var servicioSeleccionado = $(this).val();

     
        $.ajax({
            type: 'POST',
            url: 'reservas_ajax.php',
            data: { servicioSeleccionado: servicioSeleccionado },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                
                    $('#precio').val(response.data.precio);
                    $('#sobre').val(response.data.descripcionServicio);
                    $('#idServicio').val(response.data.idServicio);
                } else {
                    console.error('Error al obtener información del servicio:', response.mensaje);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la solicitud Ajax:', status, error);
            }
        });
    });

    $('#enviarBtn').click(function () {
        var descripcion = $('#descripcion').val();
        var fecha = $('#fecha').val();
        var hora = $('#hora').val();
        var idServicio = $('#idServicio').val();

        if (idServicio && descripcion && fecha && hora) {
        var validacionHora = validarHora(hora);
        if (!validacionHora.success) {
            Swal.fire({
                icon: 'warning',
                title: 'Hora inválida',
                text: validacionHora.mensaje,
            });
            return; 
        }

            $.ajax({
                type: 'POST',
                url: 'guardar_reserva.php',
                data: {
                    descripcion: descripcion,
                    fecha: fecha,
                    hora: hora,
                    idServicio: idServicio
                },
                dataType: 'json',
                success: function (response) {
                    console.log(response); 
                    if (response.success) {
                        // Mostrar SweetAlert2 de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Reserva guardada con éxito',
                            text: response.mensaje,
                        });

                        $('#descripcion').val('');
                        $('#fecha').val('');
                        $('#hora').val('');
                        $('#servicio').val('');
                        $('#precio').val('');
                        $('#sobre').val('');
                        $('#idServicio').val('');
                    } else {
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al guardar la reserva',
                            text: response.mensaje,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error en la solicitud Ajax:', status, error);
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Faltan datos',
                text: 'Por favor, complete todos los campos y elija un servicio antes de enviar la reserva.',
            });
        }
    });

    function validarHora(hora) {

        if (hora < '06:00' || hora > '18:00') {
            return { success: false, mensaje: 'La hora debe estar en el rango de 6 AM a 6 PM.' };
        }


        return { success: true, mensaje: '' };
    }
});
