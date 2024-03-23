$(document).ready(function () {
    cargarReportes();
});

function cargarReportes() {
    $.ajax({
        url: "obtener_reportes.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
            mostrarReportes(data);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar los reportes:", error);
        }
    });
}

function mostrarReportes(reportes) {
    $("#t_rep").empty(); 
    reportes.forEach(function (reporte) {
        var fila = "<tr>" +
            "<td>" + reporte.fechaVenta + "</td>" +
            "<td>" + reporte.nombreUsuario + "</td>" +
            "<td>" + reporte.dineroRecibido + "</td>" +
            "<td>" + reporte.cambio + "</td>" +
            "<td>" + reporte.total + "</td>" +
            "<td><button type='button' class='btn btn-outline-danger btn-generar-pdf' data-id='" + reporte.idVenta + "'>PDF<span><i class='bi bi-file-pdf'></span></button></td>" +
            "</tr>";
        $("#t_rep").append(fila); 
    });

    $('#tablaReportes').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros", // Cambio aquí
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "pagingType": "full_numbers",
        "lengthMenu": [10, 25, 50, 100] // Agregar este parámetro para mostrar las opciones
    }); 
    $(".btn-generar-pdf").click(function() {
        var idVenta = $(this).data("id");
        generarPDF(idVenta);
    });

    $(".btn-generar-excel").click(function() {
        var idVenta = $(this).data("id");
        generarExcel(idVenta);
    });
}

function generarPDF(idVenta) {
   
    window.open("generar_recibos.php?idVenta=" + idVenta, "_blank");
}


function generarExcel(idVenta) {
    window.open("generar_excel.php?idVenta=" + idVenta, "_blank");
}


function generarPDFPeriodo(periodo) {
    window.open("generar_reportes.php?periodo=" + periodo, "_blank");
}

