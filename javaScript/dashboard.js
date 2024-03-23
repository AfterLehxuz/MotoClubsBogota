$(document).ready(function () {
    $.ajax({
        url: 'dashboard_ajax.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Crear un gráfico de barras con Chart.js
            var ctx = document.getElementById('grafico').getContext('2d');
            var grafico = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Usuarios Registrados', 'Reservas', 'Ventas', 'PQRS'],
                    datasets: [{
                        label: 'Cantidad',
                        data: [data.usuarios, data.reservas, data.ventas, data.pqrs],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener los totales: ' + error);
        }
    });
});