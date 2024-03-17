$(document).ready(function () {
    var originalEmail; 

    $.ajax({
        type: "GET",
        url: "obtener_perfil.php",
        dataType: "json",
        success: function (data) {
           

            $("#idUsuarios").val(data.idUsuarios);
            $("#documentoID").val(data.documentoID);
            $("#nombre").val(data.nombre);
            $("#numero").val(data.numero);
            $("#email").val(data.email);
            originalEmail = data.email; 
            $("#dirreccion").val(data.dirreccion);
        },
        error: function () {
            alert("Error al obtener la información del usuario.");
        }
    });

    var idUsuarios = $("#idUsuarios").val();

    $("#editarPerfilForm").submit(function (event) {
        event.preventDefault();

        if (validarFormulario()) {
            Swal.fire({
                title: '¿Confirmar actualización?',
                text: 'Esta acción actualizará tus datos. ¿Estás seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = $(this).serialize();

                    console.log("Datos del formulario:", formData);

                    $.ajax({
                        type: "POST",
                        url: "update_ajax_perfil.php",
                        data: formData,
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: data.message,
                                    confirmButtonText: 'Confirmar',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "perfil.php";
                                    }
                                });
                            } else {
                                $("#email").val(originalEmail);
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.message,
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.error(jqXHR.responseText);
                            alert("Error en la solicitud AJAX. Consulta la consola para más detalles.");
                        }
                    });
                }
            });
        }
    });

    $("#cancelarEdicion").on("click", function () {
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
                window.location.href = "perfil.php";
            }
        });
    });

    function validarFormulario() {
        var documentoID = $("#documentoID").val();
        var nombre = $("#nombre").val();
        var numero = $("#numero").val();
        var email = $("#email").val();
        var dirreccion = $("#dirreccion").val();

        // Validar restricciones
        if (documentoID === "" || nombre === "" || numero === "" || email === "" || dirreccion === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'Todos los campos son obligatorios.',
            });
            return false;
        }

        if (numero.length < 1 || numero.length > 10 || isNaN(numero)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El número debe ser un valor numérico entre 1 y 10 dígitos.',
            });
            return false;
        }

        if (!/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El correo electrónico no tiene un formato válido.',
            });
            return false;
        }

        var documentoActual = $("#documentoID").val();

        if (documentoID !== documentoActual && !/^\d+$/.test(documentoID)) {
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'El documento debe ser un valor numérico.',
            });
            return false;
        }

       
        return true;
    }
});
