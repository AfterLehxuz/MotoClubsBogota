$(document).ready(function () {
    $("#buscarReserva").autocomplete({
        source: "reservadb_servicio.php",
        minLength: 4,
        select: function (event, ui) {
            console.log("Seleccionado:", ui.item.value);
            buscarReservas(ui.item.value);
        },
        response: function (event, ui) {

        }
    });
});

function buscarReservas(term) {
    $.ajax({
        type: "GET",
        url: "reservadb_servicio.php",
        data: { term: term },
        dataType: "json",
        success: function (response) {
            mostrarReservas(response);
        },
        error: function (xhr, status, error) {
            console.log("Error en la solicitud AJAX:", xhr.responseText);
            console.log("Status:", status);
            console.log("Error:", error);
        }
    });
}
function limpiarTabla() {
    $("#t_res").empty();
}

function mostrarReservas(reservas) {
    $("#buscarReserva").val("");
    var tbody = $("#t_res");
    tbody.empty();

    console.log("Reservas obtenidas:", reservas);

    $.each(reservas, function (index, servicio) {
        $.each(servicio.reservas, function (index, reserva) {
            var row = $("<tr>");

            var label = servicio.type === "servicio" ? servicio.label : servicio.value;

            row.append($("<td>").text(label));
            row.append($("<td>").text(reserva.descripcion));
            row.append($("<td>").text(reserva.fecha));
            row.append($("<td>").text(reserva.hora));

            var acciones = $("<td>");
            var btnEliminar = $("<button>").html("<span><i class='bx bx-trash'></i></span>").click(function () {
                eliminarReserva(reserva.idReserva);
            }).addClass("btn btn-danger");
            var btnEditar = $("<button>").html("<span><i class='bx bx-cart-alt'></i></span>").click(function () {
                var idReserva = reserva.idReserva;
                editarReserva(idReserva);
            }).addClass("btn btn-warning");
            var btnVender = $("<button>").html("<span><i class='bx bx-folder-open' ></i></span>").click(function () {
                venderReserva(reserva.idReserva);
            }).addClass("btn btn-success");

            acciones.append(btnEliminar, btnEditar, btnVender);
            row.append(acciones);

            tbody.append(row);
        });
    });
}
function editarReserva(idReserva) {

    $.ajax({
        type: "GET",
        url: "detalles_reserva.php",
        data: { idReserva: idReserva },
        dataType: "json",
        success: function (response) {
            if (response.success) {
                $("#nombreServicio").val(response.data.nombreServicio); // Ajuste aquí
                $("#descripcionServicio").val(response.data.descripcionServicio);
                $("#costo").val(response.data.costo);
                $("#descripcion").val(response.data.descripcion);
                $("#fecha").val(response.data.fecha);
                $("#hora").val(response.data.hora);
                console.log('Datos asignados al formulario:', response.data);

                window.location.href = "detalles.php?idReserva=" + idReserva + "&datos=" + encodeURIComponent(JSON.stringify(response.data));

            } else {
                console.error("Error al obtener detalles de la reserva.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", xhr.responseText);
            console.log("Status:", status);
            console.log("Error:", error);

        }
    });
}


function venderReserva(idReserva) {
    

}


function mostrarTodasReservas() {
    $.ajax({
        type: "GET",
        url: "todas_las_reservas.php",
        dataType: "json",
        success: function (response) {
            
            if (response) {
                var tbody = $("#t_tod");

                $.each(response, function (index, reserva) {

                    var row = $("<tr>");
                    row.append($("<td>").text(reserva.nombreServicio));
                    row.append($("<td>").text(reserva.descripcion));
                    row.append($("<td>").text(reserva.fecha));
                    row.append($("<td>").text(reserva.hora));

                    var acciones = $("<td>");
                    var btnEliminar = $("<button>").html("<span><i class='bx bx-trash'></i></span>").click(function () {
                        eliminarReserva(reserva.idReserva);
                    }).addClass("btn btn-danger");
                    var btnEditar = $("<button>").html("<span><i class='bx bx-cart-alt'></i></span>").click(function () {
                        editarReserva(reserva.idReserva);
                    }).addClass("btn btn-warning");
                    var btnVender = $("<button>").html("<span><i class='bx bx-folder-open'></i></span>").click(function () {
                        venderReserva(reserva.idReserva);
                    }).addClass("btn btn-success");

                    acciones.append(btnEliminar, btnEditar, btnVender);
                    row.append(acciones);

                    tbody.append(row);
                });
            } else {
                console.error("Error al obtener todas las reservas.");
            }
        },
        error: function (xhr, status, error) {
            console.log("Error en la solicitud AJAX:", xhr.responseText);
            console.log("Status:", status);
            console.log("Error:", error);
        }
    });
}

function eliminarReserva(idReserva) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "eliminar_reserva.php",
                data: { idReserva: idReserva },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire(
                            '¡Eliminado!',
                            'La reserva ha sido eliminada.',
                            'success');
                            location.reload();
                    } else {
                        Swal.fire(
                            'Error',
                            'Hubo un error al eliminar la reserva.',
                            'error'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", xhr.responseText);
                    console.log("Status:", status);
                    console.log("Error:", error);
                    Swal.fire(
                        'Error',
                        'Hubo un error en la solicitud AJAX.',
                        'error'
                    );
                }
            });
        }
    });
}

$(document).ready(function () {
    mostrarTodasReservas();
});


