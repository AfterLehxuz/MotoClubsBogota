$(document).ready(function () {
  cargarPQRS();

<<<<<<< HEAD
    function cargarPQRS() {
        $.ajax({
            url: "pqrsdb_ajax.php",
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#t_pqrs").empty();

                $.each(data, function (index, pqrs) {
                    console.log('id: ' + pqrs.rolUsuario)
                    var newRow = '<tr>' +
                        '<td>' + pqrs.tipo + '</td>' +
                        '<td>' + pqrs.descripcion + '</td>' +
                        '<td>' + pqrs.fecha + '</td>' +
                        '<td>' + pqrs.estado + '</td>' +
                        '<td>' + pqrs.nombre_usuario + '</td>';

                    if (pqrs.rolUsuario == 1) {
                        if (pqrs.resuelta && pqrs.resuelta != 1) {
                            newRow += '<td>En espera...</span></td>';
                            newRow += '<td>' +
                                '<button class="btn btn-danger" data-id="' + pqrs.idPQRS + '" id="btnEliminarPQRS">Eliminar</button>' +
                                '<button class="btn btn-success" data-id="' + pqrs.idPQRS + '" id="btnResolverPQRS">Resolver</button>' +
                                '</td>';
                        } else {
                            newRow += '<td>' + pqrs.respuesta + '</td>';
                            newRow += '<td><button class="btn btn-danger" data-id="' + pqrs.idPQRS + '" id="btnEliminarPQRS">Eliminar</button></td>';
                        }
                    } else {
                        if (pqrs.resuelta && pqrs.resuelta != 1) {
                            newRow += '<td> En espera </td>';
                            newRow += '<td><button class="btn btn-danger" data-id="' + pqrs.idPQRS + '" id="btnEliminarPQRS">Eliminar</button></td>';
                        } else {
                            newRow += '<td>' + pqrs.respuesta + '</td>';
                            newRow += '<td><button class="btn btn-danger" data-id="' + pqrs.idPQRS + '" id="btnEliminarPQRS">Eliminar</button></td>';
                        }
                    }

                    newRow += '</tr>';

                    $("#t_pqrs").append(newRow);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error en la solicitud AJAX:", xhr, status, error);
            }
        });
=======
  function cargarPQRS() {
    if ($.fn.DataTable.isDataTable("#tablaPQRS")) {
      $("#tablaPQRS").DataTable().destroy();
>>>>>>> 39ad5428f4ef247e8c4570a63538b3902e5fc65f
    }
    $.ajax({
      url: "pqrsdb_ajax.php",
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#t_pqrs").empty();

        $.each(data, function (index, pqrs) {
          console.log("id: " + pqrs.rolUsuario);
          var newRow =
            "<tr>" +
            "<td>" +
            pqrs.tipo +
            "</td>" +
            "<td>" +
            pqrs.descripcion +
            "</td>" +
            "<td>" +
            pqrs.fecha +
            "</td>" +
            "<td>" +
            pqrs.estado +
            "</td>" +
            "<td>" +
            pqrs.nombre_usuario +
            "</td>";

          if (pqrs.rolUsuario == 1) {
            if (pqrs.resuelta && pqrs.resuelta != 1) {
              newRow += "<td>En espera...</span></td>";
              newRow +=
                "<td>" +
                '<button class="btn btn-danger" data-id="' +
                pqrs.idPQRS +
                '" id="btnEliminarPQRS">Eliminar</button>' +
                '<button class="btn btn-success" data-id="' +
                pqrs.idPQRS +
                '" id="btnResolverPQRS">Resolver</button>' +
                "</td>";
            } else {
              newRow += "<td>" + pqrs.respuesta + "</td>";
              newRow +=
                '<td><button class="btn btn-danger" data-id="' +
                pqrs.idPQRS +
                '" id="btnEliminarPQRS">Eliminar</button></td>';
            }
          } else {
            if (pqrs.resuelta && pqrs.resuelta != 1) {
              newRow += "<td> En espera </td>";
              newRow +=
                '<td><button class="btn btn-danger" data-id="' +
                pqrs.idPQRS +
                '" id="btnEliminarPQRS">Eliminar</button></td>';
            } else {
              newRow += "<td>" + pqrs.respuesta + "</td>";
              newRow +=
                '<td><button class="btn btn-danger" data-id="' +
                pqrs.idPQRS +
                '" id="btnEliminarPQRS">Eliminar</button></td>';
            }
          }

          newRow += "</tr>";

          $("#t_pqrs").append(newRow);
        });

        $("#tablaPQRS").DataTable({
          language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros", // Cambio aquí
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo:
              "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros <button id='btnIrPQRS' class='btn btn-info'>Ir a PQRS</button>",
            sInfoEmpty:
              "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
              sFirst: "Primero",
              sLast: "Último",
              sNext: "Siguiente",
              sPrevious: "Anterior",
            },
            oAria: {
              sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
              sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
            },
          },
          pagingType: "full_numbers",
          lengthMenu: [10, 25, 50, 100], // Agregar este parámetro para mostrar las opciones
        });
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", xhr, status, error);
      },
    });
  }

  $(document).on("click", "#btnIrPQRS", function () {
    window.location.href = "pqrs.php";
  });

  $(document).on("click", "#btnEliminarPQRS", function () {
    var idPQRS = $(this).data("id");

    Swal.fire({
      title: "¿Estás seguro?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminarlo",
    }).then((result) => {
      if (result.isConfirmed) {
        eliminarPQRS(idPQRS);
      }
    });
  });

  function eliminarPQRS(idPQRS) {
    $.ajax({
      type: "POST",
      url: "eliminar_pqrs.php",
      data: { idPQRS: idPQRS },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          cargarPQRS();
          Swal.fire("¡Eliminado!", "La PQRS ha sido eliminada.", "success");
        } else {
          Swal.fire("Error", "Hubo un error al eliminar la PQRS.", "error");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", xhr.responseText);
        Swal.fire("Error", "Hubo un error en la solicitud AJAX.", "error");
      },
    });
  }
  $(document).on("click", "#btnResolverPQRS", function () {
    var idPQRS = $(this).data("id");
    console.log("id: " + idPQRS);
    Swal.fire({
      title: "Responder PQRS",
      input: "textarea",
      inputLabel: "Respuesta",
      showCancelButton: true,
      confirmButtonText: "Enviar respuesta",
      cancelButtonText: "Cancelar",
      showLoaderOnConfirm: true,
      preConfirm: function (respuesta) {
        return $.ajax({
          type: "POST",
          url: "resolver_pqrs.php",
          data: { idPQRS: idPQRS, respuesta: respuesta },
          dataType: "json",
        });
      },
      allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
      if (result.value.success) {
        cargarPQRS();
        Swal.fire(
          "¡Resuelta!",
          "La PQRS ha sido resuelta correctamente.",
          "success"
        );
      } else {
        Swal.fire("Error", "Hubo un error al resolver la PQRS.", "error");
      }
    });
  });
});
