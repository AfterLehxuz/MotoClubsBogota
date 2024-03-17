document.addEventListener("DOMContentLoaded", function () {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "repuestos_ajax.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var productos = JSON.parse(xhr.responseText);
            mostrarProductos(productos);
        }
    };
    xhr.send();

    

});

function mostrarProductos(productos) {
    var contenedorProductos = document.getElementById("productos-recientes");

    productos.forEach(function (producto) {
        var productoHTML = '<div class="producto">';
        productoHTML += '<img src="' + producto.rutaImagen + '" alt="' + producto.nombre + '">';
        productoHTML += '<h2>' + producto.nombre + '</h2>';
        productoHTML += '<p>Descripción: ' + producto.descripcion + '</p>';
        productoHTML += '<p>Costo: $' + producto.costo + '</p>';
        productoHTML += '</div>';
        contenedorProductos.innerHTML += productoHTML;
    });
}

