$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "informacion_perfil.php",
        success: function (data) {
            console.log(data);
            $('.perfil-table').append(`
                <tr>
                    <td>Documento:</td>
                    <td>${data.documentoID}</td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td>${data.nombre}</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>${data.email}</td>
                </tr>
                <tr>
                    <td>Teléfono:</td>
                    <td>${data.numero}</td>
                </tr>
                <tr>
                    <td>Dirección:</td>
                    <td>${data.dirreccion}</td>
                </tr>
            `);
        },
        error: function (xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
            alert("Error en la solicitud AJAX. Consulta la consola para más detalles.");
        }
    });
});
