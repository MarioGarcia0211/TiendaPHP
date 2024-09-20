$(document).ready(function () {

    graficaFechasMayor();
    graficaFechasMenor();
    graficaUsuario();

    function graficaFechasMayor() {
        $.ajax({
            url: "ajax.php",
            method: "POST",
            data: { action: 'fechaMayor' },
            success: function (resp) {
                var nombreProductos = [];
                var totalProductos = [];
                var data = JSON.parse(resp);
                for (var i = 0; i < data.length; i++) {
                    nombreProductos.push(data[i][0]);
                    totalProductos.push(data[i][3]);
                }

                const ctx = document.getElementById('barFechaMayor').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: nombreProductos,
                        datasets: [{
                            label: 'Fechas',
                            data: totalProductos,
                            backgroundColor: [
                                'rgba(13, 110, 253, 0.2)',
                            ],
                            borderColor: [
                                'rgb(13, 110, 253)',

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

            }
        })
    }

    function graficaFechasMenor() {
        $.ajax({
            url: "ajax.php",
            method: "POST",
            data: { action: 'fechaMenor' },
            success: function (resp) {
                var nombreProductos = [];
                var totalProductos = [];
                var data = JSON.parse(resp);
                for (var i = 0; i < data.length; i++) {
                    nombreProductos.push(data[i][0]);
                    totalProductos.push(data[i][3]);
                }

                const ctx = document.getElementById('barFechaMenor').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: nombreProductos,
                        datasets: [{
                            label: 'Fechas',
                            data: totalProductos,
                            backgroundColor: [
                                'rgba(13, 110, 253, 0.2)',
                            ],
                            borderColor: [
                                'rgb(13, 110, 253)',

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

            }
        })
    }

    function graficaUsuario() {
        $.ajax({
            url: "ajax.php",
            method: "POST",
            data: { action: 'usuarios' },
            success: function (resp) {
                var nombreProductos = [];
                var totalProductos = [];
                var data = JSON.parse(resp);
                for (var i = 0; i < data.length; i++) {
                    nombreProductos.push(data[i][1]);
                    totalProductos.push(data[i][3]);
                }

                const ctx = document.getElementById('barUsuarios').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: nombreProductos,
                        datasets: [{
                            label: 'Ventas por usuario',
                            data: totalProductos,
                            backgroundColor: [
                                'rgba(13, 110, 253, 0.2)',
                            ],
                            borderColor: [
                                'rgb(13, 110, 253)',

                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

            }
        })
    }

    
});