$(document).ready(function () {
  var procesando = false;

  $("#buscarProducto").autocomplete({
    source: function (request, response) {
      if (!procesando) {
        $.ajax({
          type: "POST",
          url: "inventario_ajax.php",
          dataType: "json",
          data: {
            buscarProducto: request.term,
          },
          success: function (data) {
            var productos = $.map(data, function (item) {
              return {
                label: item.nombre,
                nombre: item.nombre,
                codigo_producto: item.codigo_producto,
                costo: item.costo,
                provedor: item.nombreProveedor,
                descripcion: item.descripcion,
                cantidad: item.cantidad,
                rutaImagen: item.rutaImagen,
              };
            });

            response(productos);
          },
          error: function (xhr, status, error) {
            console.error(
              "Error en la solicitud AJAX: " + status + " - " + error
            );
          },
        });
      }
    },
    minLength: 2,
    messages: {
      noResults: "",
      results: function () {},
    },
    select: function (event, ui) {
      mostrarDetallesProducto(ui.item);
    },
  });

  function mostrarDetallesProducto(producto) {
    $("#buscarProducto").autocomplete("disable");
    $("#buscarProducto").prop("disabled", true);

    $(".producto-encontrado tbody").append(
      "<tr>" +
        "<td>" +
        producto.codigo_producto +
        "</td>" +
        "<td>" +
        producto.costo +
        "</td>" +
        "<td>" +
        producto.descripcion +
        "</td>" +
        "<td>" +
        producto.nombre +
        "</td>" +
        "<td>" +
        producto.provedor +
        "</td>" +
        "<td><input type='number' id='inputCantidad' value='1' min='1'></td>" +
        "<td><img src='" +
        producto.rutaImagen +
        "' alt='Imagen' style='width:50px;height:50px;'></td>" +
        "<td>" +
        "<button class='btn btn-primary' id='btnAgregarStock'><span><i class='bx bx-archive-in'></i></span></button>" +
        "<button class='btn btn-danger' id='btnCancelar'><span><i class='bx bx-trash' ></i></span></button>" +
        "</td>" +
        "</tr>"
    );

    $("#btnAgregarStock").on("click", function () {
      var cantidadNueva = $("#inputCantidad").val();

      if (!isNaN(cantidadNueva) && cantidadNueva > 0) {
        Swal.fire({
          title: "¿Estás seguro?",
          text: "¿Quieres añadir el stock con la cantidad ingresada?",
          icon: "question",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Sí, añadir stock",
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "actualizar_stock.php",
              data: {
                codigo_producto: producto.codigo_producto,
                cantidadNueva: cantidadNueva,
              },
              success: function (response) {
                console.log(response);
                if (response.status === "success") {
                  Swal.fire(
                    "¡Éxito!",
                    "Stock actualizado exitosamente.",
                    "success"
                  );

                  $(".producto-encontrado tbody").empty();
                  $("#buscarProducto").val("");

                  $("#buscarProducto").autocomplete("enable");
                  $("#buscarProducto").prop("disabled", false);

                  cargarTodosLosProductos();
                } else {
                  Swal.fire("Error", "Error al actualizar el stock.", "error");
                }
              },
              error: function (xhr, status, error) {
                console.error(
                  "Error en la solicitud AJAX: " + status + " - " + error
                );
              },
            });
          }
        });
      } else {
        Swal.fire("Error", "Ingrese una cantidad válida.", "error");
      }
    });

    $("#btnCancelar").on("click", function () {
      Swal.fire({
        title: "¿Estás seguro?",
        text: "Los cambios no se guardarán. ¿Quieres continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          $(".producto-encontrado tbody").empty();
          $("#buscarProducto").val("");

          $("#buscarProducto").autocomplete("enable");
          $("#buscarProducto").prop("disabled", false);
        }
      });
    });
  }
  function cargarTodosLosProductos() {
    $.ajax({
      type: "POST",
      url: "cargar_productos.php",
      dataType: "json",
      success: function (data) {
        $("#t_pro").empty(); // Limpiar la tabla antes de agregar nuevos datos
        if (data.length > 0) {
          // Verificar si hay datos disponibles
          $.each(data, function (index, producto) {
            $("#t_pro").append(
              "<tr>" +
                "<td>" +
                producto.codigo_producto +
                "</td>" +
                "<td>" +
                producto.costo +
                "</td>" +
                "<td>" +
                producto.descripcion +
                "</td>" +
                "<td>" +
                producto.nombre +
                "</td>" +
                "<td>" +
                producto.cantidad +
                "</td>" +
                "<td>" +
                producto.proveedor_nombre +
                "</td>" +
                "<td><img src='" +
                producto.rutaImagen +
                "' alt='Imagen' style='width:50px;height:50px;'></td>" +
                "<td>" +
                producto.eliminarBoton +
                producto.editarBoton +
                "</td>" +
                "</tr>"
            );
          });
          if (!$.fn.DataTable.isDataTable("#tablaProductos")) {
            $("#tablaProductos").DataTable({
              language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ registros",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo:
                  "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                sInfoEmpty:
                  "Mostrando registros del 0 al 0 de un total de 0 registros",
                sInfoFiltered: "(filtrado de un total de MAX registros)",
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
              lengthMenu: [10, 25, 50, 100],
            });
          }
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX: " + status + " - " + error);
        console.log(xhr.responseText);
      },
    });
  }

  $(document).on("click", "#editar-producto", function () {
    var idProducto = $(this).data("id");
    window.location.href = "editar_producto.php?id=" + idProducto;
  });

  $(document).ready(function () {
    cargarTodosLosProductos();
  });

  $(document).on("click", "#eliminar-producto", function () {
    var idProducto = $(this).data("id");

    Swal.fire({
      title: "¿Estás seguro?",
      text: "Esta acción eliminará el producto. ¿Quieres continuar?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, eliminar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "eliminar_producto.php",
          data: {
            idProducto: idProducto,
          },
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              Swal.fire(
                "¡Éxito!",
                "Producto eliminado exitosamente.",
                "success"
              );

              cargarTodosLosProductos();
            } else {
              Swal.fire("Error", "Error al eliminar el producto.", "error");
            }
          },
          error: function (xhr, status, error) {
            console.error(
              "Error en la solicitud AJAX: " + status + " - " + error
            );
          },
        });
      }
    });
  });
});
