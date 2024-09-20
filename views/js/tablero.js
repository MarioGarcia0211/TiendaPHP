$(document).ready(function () {

    graficaGanancias();
    graficaFacturas();
    graficaUsuario();
    graficaProducto();

    function graficaGanancias() {
        $.ajax({
            url: "ajaxTablero.php",
            method: "POST",
            data: { action: 'fechas' },
            success: function (resp) {
                var totalProductos = [];
                var colores = [];
                var data = JSON.parse(resp);
                var meta = 2000000000;
                var mitad = meta / 2;
                for (var i = 0; i < data.length; i++) {
                    totalProductos.push(data[i][1]);

                    if(data[i][1] >= meta){colores.push('rgb(50, 205, 50)')};

                    if(data[i][1] >= mitad && data[i][1] < meta){colores.push('rgb(255, 205, 86)')};

                    if(data[i][1] < mitad){colores.push('rgb(255, 99, 132)')};

                }

                const ctx = document.getElementById('barMes').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        datasets: [{
                            label: 'Ganancias',
                            data: totalProductos,
                            backgroundColor: colores,
                            borderWidth: 1
                        },
                        {
                            type: 'line',
                            label: 'Objetivo',
                            data: [meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta],
                            fill: false,
                            borderColor: 'rgb(54, 162, 235)'
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

    function graficaFacturas() {
        $.ajax({
            url: "ajaxTablero.php",
            method: "POST",
            data: { action: 'facturas' },
            success: function (resp) {
                var totalProductos = [];
                var colores = [];
                var data = JSON.parse(resp);
                var meta = 5000;
                var mitad = meta / 2;
                for (var i = 0; i < data.length; i++) {
                    totalProductos.push(data[i][1]);

                    if(data[i][1] >= meta){colores.push('rgb(50, 205, 50)')};

                    if(data[i][1] >= mitad && data[i][1] < meta){colores.push('rgb(255, 205, 86)')};

                    if(data[i][1] < mitad){colores.push('rgb(255, 99, 132)')};

                }

                const ctx = document.getElementById('facturaMes').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        datasets: [{
                            label: 'Ganancias',
                            data: totalProductos,
                            backgroundColor: colores,
                            borderWidth: 1
                        },
                        {
                            type: 'line',
                            label: 'Objetivo',
                            data: [meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta],
                            fill: false,
                            borderColor: 'rgb(54, 162, 235)'
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
            url: "ajaxTablero.php",
            method: "POST",
            data: { action: 'usuario' },
            success: function (resp) {
                var usuario = [];
                var totalProductos = [];
                var colores = [];
                var data = JSON.parse(resp);
                var meta = 4500;
                var mitad = meta / 2;
                for (var i = 0; i < data.length; i++) {
                    usuario.push(data[i][1]);
                    totalProductos.push(data[i][3]);

                    if(data[i][3] >= meta){colores.push('rgb(50, 205, 50)')};

                    if(data[i][3] >= mitad && data[i][3] < meta){colores.push('rgb(255, 205, 86)')};

                    if(data[i][3] < mitad){colores.push('rgb(255, 99, 132)')};

                }

                const ctx = document.getElementById('usuarioTotal').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: usuario,
                        datasets: [{
                            label: 'Facturas realizadas',
                            data: totalProductos,
                            backgroundColor: colores,
                            borderWidth: 1
                        },
                        {
                            type: 'line',
                            label: 'Objetivo',
                            data: [meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta],
                            fill: false,
                            borderColor: 'rgb(54, 162, 235)'
                        }]
                    },
                    options: {
                        indexAxis: 'y',
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

    function graficaProducto() {
        $.ajax({
            url: "ajaxTablero.php",
            method: "POST",
            data: { action: 'productos' },
            success: function (resp) {
                var usuario = [];
                var totalProductos = [];
                var colores = [];
                var data = JSON.parse(resp);
                var meta = 400;
                var mitad = meta / 2;
                for (var i = 0; i < data.length; i++) {
                    usuario.push(data[i][0]);
                    totalProductos.push(data[i][1]);

                    if(data[i][1] >= meta){colores.push('rgb(50, 205, 50)')};

                    if(data[i][1] >= mitad && data[i][1] < meta){colores.push('rgb(255, 205, 86)')};

                    if(data[i][1] < mitad){colores.push('rgb(255, 99, 132)')};

                }

                const ctx = document.getElementById('productoTotal').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: usuario,
                        datasets: [{
                            label: 'Cantidad de productos',
                            data: totalProductos,
                            backgroundColor: colores,
                            borderWidth: 1
                        },
                        {
                            type: 'line',
                            label: 'Objetivo',
                            data: [meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta, meta],
                            fill: false,
                            borderColor: 'rgb(54, 162, 235)'
                        }]
                    },
                    options: {
                        indexAxis: 'y',
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