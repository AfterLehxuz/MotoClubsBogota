var serviciosAgregados = [];
var productosAgregados = [];
$(document).ready(function () {

    $("#buscarProducto").autocomplete({
        source: function (request, response) {

            $.ajax({
                url: "buscar_producto.php",
                method: "GET",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                 
                    var productosDisponibles = data.filter(function (producto) {
                        return producto.cantidad > 0;
                    });

                  
                    if (productosDisponibles.length > 0) {
                        response(productosDisponibles);
                    } else {
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Stock Insuficiente',
                            text: 'No hay productos disponibles en stock.'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", xhr, status, error);
                }
            });
        },
        maxLength: 6,
        select: function (event, ui) {
            agregarProductoATabla(ui.item);
            $(this).val('');
            return false;
        }
    })


        .autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.nombre + "</div>")
                .appendTo(ul);
        };

        $("#buscarReserva").autocomplete({
            source: function (request, response) {
                var tipoBusqueda = isNaN(request.term) ? 'nombre' : 'documento';
    
                $.ajax({
                    url: "buscar_reserva_venta.php",
                    method: "GET",
                    dataType: "json",
                    data: {
                        term: request.term,
                        tipoBusqueda: tipoBusqueda
                    },
                    success: function (data) {
                        if (data && data.length > 0) {
                            response(data);
                        } else {
                            response([]);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", xhr, status, error);
                        response([]);
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
                agregarReservaATabla(ui.item.nombreServicio, ui.item.precio, ui.item.idServicio);
            }
        }).autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.nombreServicio + "</div>")
                .appendTo(ul);
        }

        function agregarReservaATabla(nombreServicio, precio, idServicio) {
            if (serviciosAgregados.includes(idServicio)) {
                
                Swal.fire({
                    icon: 'error',
                    title: 'Servicio Repetido',
                    text: 'El servicio ya ha sido agregado.'
                });
                return;
            }
    
            var newRow = '<tr>' +
                '<td class="idServicio" hidden>' + idServicio + '</td>' +
                '<td>' + nombreServicio + '</td>' +
                '<td class="precio">' + precio + '</td>' +
                '<td><i class="bx bxs-trash btnEliminar"></i></td>' +
                '</tr>';
    
            $("#t_serv").append(newRow);
            calcularCambio();
    
            serviciosAgregados.push(idServicio); 
        }
    
    $("#buscarUsuario").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "buscar_usuario.php",
                method: "GET",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    if (data.length === 0) {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Sin resultados',
                            text: 'No se encontraron resultados. Por favor, intente con un término de búsqueda diferente.'
                        }).then(function () {

                            $("#idUsuarios").val('');
                            $("#documentoID").val('');
                            $("#nombre").val('');
                            $("#numero").val('');
                            $("#dirreccion").val('');
                            $("#registrar").show();
                        });
                    } else {

                        response(data);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", xhr, status, error);
                }
            });
        },
        maxLength: 6,
        select: function (event, ui) {
            console.log(ui.item);
            $("#idUsuarios").val(ui.item.idUsuarios);
            $("#documentoID").val(ui.item.documentoID);
            $("#nombre").val(ui.item.nombre);
            $("#numero").val(ui.item.numero);
            $("#dirreccion").val(ui.item.dirreccion);

            $("#registrar").hide();
            $(this).val(ui.item.value);
            return false;
        }
    })
        .autocomplete("instance")._renderItem = function (ul, item) {
            return $("<li>")
                .append("<div>" + item.documentoID + "</div>")
                .appendTo(ul);
        }

        function agregarProductoATabla(producto) {
            // Verificar si el producto ya está en la lista
            if (productosAgregados.includes(producto.idProducto)) {
                // Mostrar un mensaje de error con SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Producto Repetido',
                    text: 'El producto ya ha sido agregado.'
                });
                return;
            }
    
            var cantidad = 1;
            var subtotal = cantidad * producto.costo;
    
            console.log("Cantidad disponible:", producto.cantidad);
            console.log("Cantidad ingresada:", cantidad);
    
            if (cantidad <= 0) {
                alert("La cantidad ingresada no es válida. Por favor, ingrese una cantidad mayor a 0.");
                console.log("La cantidad ingresada no es válida.");
                return;
            }
    
            if (producto.cantidad <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Stock Insuficiente',
                    text: 'El stock de este producto es insuficiente. No se puede agregar a la venta.'
                });
                return;
            }
    
            var newRow = '<tr>' +
                '<td class="idProducto" style="display: none;">' + producto.idProducto + '</td>' +
                '<td>' + producto.codigo_producto + '</td>' +
                '<td>' + producto.nombre + '</td>' +
                '<td class="cantidadDisponible">' + producto.cantidad + '</td>' + // Agregar una clase para identificar fácilmente esta celda
                '<td><input type="number" class="inputCantidad" name="cantidad" value="' + cantidad + '" min="1" max="' + producto.cantidad + '"></td>' +
                '<td>' + producto.descripcion + '</td>' +
                '<td>' + producto.costo + '</td>' +
                '<td class="subtotal">' + subtotal + '</td>' +
                '<td><i class="bx bxs-trash btnEliminar"></i></td>' +
                '</tr>';
    
            $("#t_ven").append(newRow);
    
            $(".inputCantidad").on("input", function () {
                calcularSubtotal($(this));
                calcularCambio();
            });
    
            $(".inputCantidad").on("change", function () {
                var cantidadIngresada = parseInt($(this).val());
                var cantidadDisponible = parseInt($(this).attr("max"));
    
                if (isNaN(cantidadIngresada) || cantidadIngresada < 1 || cantidadIngresada > cantidadDisponible) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cantidad Inválida',
                        text: 'Por favor, ingrese una cantidad válida mayor que 0 y menor o igual a ' + cantidadDisponible + '.'
                    });
                    $(this).val(1);
                }
    
                var row = $(this).closest('tr');
                var cantidadDisponibleCell = row.find('.cantidadDisponible');
                cantidadDisponibleCell.text(cantidadDisponible - cantidadIngresada);
    
                calcularCambio();
            });
    
            
            productosAgregados.push(producto.idProducto);
    
            calcularCambio();
        }
    
        

    $("#t_serv").on("click", ".btnEliminar", function () {
        $(this).closest("tr").remove();
        calcularCambio();
    });

    $("#t_ven").on("click", ".btnEliminar", function () {
        $(this).closest("tr").remove();
        calcularCambio();
    });

    function calcularSubtotal(inputCantidad) {
        var cantidad = parseFloat(inputCantidad.val()) || 0;
        var precioUnitario = parseFloat(inputCantidad.closest("tr").find("td:eq(6)").text()) || 0;

        var subtotal = cantidad * precioUnitario;

        inputCantidad.closest("tr").find("td.subtotal").text(subtotal.toFixed(2));
    }

    function calcularCambio() {
        var subtotalProductos = 0;
        $(".subtotal").each(function () {
            subtotalProductos += parseFloat($(this).text()) || 0;
        });

        var subtotalReservas = 0;
        $(".precio").each(function () {
            subtotalReservas += parseFloat($(this).text()) || 0;
        });

        var subtotalReservas = 0;
        $(".precio").each(function () {
            subtotalReservas += parseFloat($(this).text()) || 0;
        });

        var total = subtotalProductos + subtotalReservas;
        var efectivo = parseFloat($("#efectivo_recibido").val()) || 0;

        var cambio = (efectivo >= total) ? (efectivo - total) : 0;


        $("#total").val(total.toFixed(2));
        $("#cambio").val(cambio.toFixed(2));
    }



    $("#efectivo_recibido").on("input", function () {
        calcularCambio();
    })



    $("#btnGuardarDatos").on("click", function () {
        var idUsuario = $("#idUsuarios").val();
        var idProductos = [];
        var cantidades = [];
        var idServicios = [];
        var precioServicio = [];
        var cambio = $("#cambio").val();
        var total = parseFloat($("#total").val());
        var dineroRecibido = parseFloat($("#efectivo_recibido").val());



        if (dineroRecibido < total) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El dinero recibido no puede ser menor que el total de la venta.'
            });
            return;
        }


        $("#t_serv .precio").each(function () {
            precioServicio.push($(this).text());
        });

        $("#t_serv .idServicio").each(function () {
            idServicios.push($(this).text());
        });

        $("#t_ven .idProducto").each(function () {
            idProductos.push($(this).text());
        });

        $("#t_ven .inputCantidad").each(function () {
            cantidades.push($(this).val());
        });

        console.log("Id usuario", idUsuario);
        console.log("Id producto", idProductos);
        console.log("cambio", cambio);
        console.log("total", total);
        console.log("dinero Recibido", dineroRecibido);
        console.log("cantidades: ", cantidades);
        console.log("nombre del servicio:", idServicios);
        console.log("precio del servicio:", precioServicio);

        if (!idUsuario || !cambio || !total || !dineroRecibido) {
            Swal.fire({
                icon: 'warning',
                title: 'Formulario Incompleto',
                text: 'Por favor, complete todos los campos obligatorios antes de guardar.'
            });
            return;
        }


        if ((idProductos.length === 0 && idServicios.length === 0) ||
            (idProductos.length > 0 && cantidades.length === 0) ||
            (idServicios.length > 0 && precioServicio.length === 0)) {
            Swal.fire({
                icon: 'warning',
                title: 'Detalles Incompletos',
                text: 'Por favor, complete los detalles de productos o servicios antes de guardar.'
            });
            return;
        }

        Swal.fire({
            title: 'Confirmar Venta',
            text: '¿Está seguro de que desea guardar la venta?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "guardar_venta.php",
                    method: "POST",
                    data: {
                        idUsuario: idUsuario,
                        idProductos: JSON.stringify(idProductos),
                        cantidades: JSON.stringify(cantidades),
                        cambio: cambio,
                        total: total,
                        dineroRecibido: dineroRecibido,
                        idServicios: JSON.stringify(idServicios),
                        precioServicio: JSON.stringify(precioServicio),

                    },
                    success: function (response) {
                        try {
                            var jsonResponse = JSON.parse(response);

                            if (jsonResponse && jsonResponse.idVenta) {
                                var idVenta = jsonResponse.idVenta;

                                if (idVenta) {
                                    console.log(response)
                                    limpiarDatos();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Venta Guardada',
                                        text: 'La venta se ha guardado exitosamente.'
                                    });

                                    window.open("generar_recibos.php?idVenta=" + idVenta, "_blank");
                                } else {
                                    console.log(response)
                                    console.error("ID de venta no válido en la respuesta:", jsonResponse);
                                }
                            } else {
                                console.log(response)
                                console.error("Respuesta no válida:", response);
                            }
                        } catch (error) {
                            console.error("Error al procesar la respuesta JSON:", error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", xhr, status, error);
                    }
                });
            }
        });
    });


    function limpiarDatos() {
        $("#idUsuarios").val('');
        $("#documentoID").val('');
        $("#nombre").val('');
        $("#numero").val('');
        $("#dirreccion").val('');
        $("#t_ven").empty();
        $("#t_serv").empty();
        $("#total").val('');
        $("#efectivo_recibido").val('');
        $("#cambio").val('');
        $("#buscarUsuario").val('');
        $("#buscarProducto").val('');
        $("#buscarUsuario").val('');

        productosAgregados = [];
        serviciosAgregados = [];
    }
});