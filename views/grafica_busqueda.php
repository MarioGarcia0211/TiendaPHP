<?php
include "../conexion.php";
include "./ajaxFecha.php";
$desde = strtolower($_REQUEST['desde']);
    if ((empty($desde))) {
        header('location: graficas.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficas</title>
    <?php include "includes/scripts.php"; ?>

    <style>
        .card-body {
            font-size: smaller;
        }

        .graficas {
            margin-top: 30px;
        }

        .lineChart {
            margin-top: 30px;
        }

        .datos2 {
            margin-top: 10px;
        }

        .chart {
            height: 100%;
        }

        .pieChart {
            margin-top: 30px;
        }

        .notItemOne>option:first-child {
            display: none;
        }
    </style>
</head>

<body>
    <?php include "includes/navbar.php";
    $email = $_SESSION['email'];
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="graficas.php">Datos generales</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="tablero_control.php">Tableros de control</a>
            </li>

        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Datos generales</h1>
                <form class="row gy-2 gx-3 align-items-center" role="search" action="grafica_busqueda.php" method="get">

                    <!-- Desde -->
                    <div class="col-auto">
                        <div class="input-group">
                            <div class="input-group-text">Año</div>
                            <select class="form-select notItemOne" name="desde" id="desde" aria-label="Default select example">
                                <option selected><?php echo $desde; ?></option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="">2023</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </nav>

        <!-- Datos 2 -->
        <div class="datos2 row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-4">

            <!-- Total ventas -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Total ventas</div>
                    <div class="card-body">
                        <div class="row row-cols-2">
                            <div class="col text-center">
                                <h5>Año</h5>
                                <?php
                                echo $desde;
                                ?>
                            </div>

                            <div class="col text-center">
                                <h5>Total</h5>
                                <?php
                                $query_facturas = mysqli_query($conection, "SELECT COUNT(*) as total from facturas_$desde");
                                $result_facturas = mysqli_num_rows($query_facturas);
                                if ($result_facturas > 0) {
                                    while ($facturas = mysqli_fetch_array($query_facturas)) {
                                        echo $facturas["total"];
                                    }
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final total ventas -->

            <!-- Dia con mayor ganancias -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Dia con mayor ganancia</div>
                    <div class="card-body">
                        <div class="row row-cols-2">
                            <div class="col text-center">
                                <h5>Fecha</h5>
                                <?php
                                $es = mysqli_query($conection, "SET lc_time_names = 'es_CO';");
                                $query_facturas = mysqli_query($conection, "SELECT DATE_FORMAT(fecha, '%d/%M/%Y') AS fecha, ganancia FROM `fecha_mayor_ganancia_$desde` ORDER BY `fecha_mayor_ganancia_$desde`.`ganancia` DESC LIMIT 1;");
                                $result_facturas = mysqli_num_rows($query_facturas);
                                if ($result_facturas > 0) {
                                    while ($facturas = mysqli_fetch_array($query_facturas)) {
                                        echo $facturas['fecha'];
                                ?>
                            </div>

                            <div class="col text-center">
                                <h5>Total</h5>
                        <?php
                                        echo '$' . ' ' . $facturas['ganancia'];
                                    }
                                }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final dia conganancias ventas -->

            <!-- Dia con menor ganancias -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Dia con menor ganancia</div>
                    <div class="card-body">
                        <div class="row row-cols-2">
                            <div class="col text-center">
                                <h5>Fecha</h5>
                                <?php
                                $es = mysqli_query($conection, "SET lc_time_names = 'es_CO';");
                                $query_facturas = mysqli_query($conection, "SELECT DATE_FORMAT(fecha, '%d/%M/%Y') AS fecha, ganancia FROM `fecha_menor_ganancia_$desde` ORDER BY `fecha_menor_ganancia_$desde`.`ganancia` ASC LIMIT 1;");
                                $result_facturas = mysqli_num_rows($query_facturas);
                                if ($result_facturas > 0) {
                                    while ($facturas = mysqli_fetch_array($query_facturas)) {
                                        echo $facturas['fecha'];
                                ?>
                            </div>

                            <div class="col text-center">
                                <h5>Total</h5>
                        <?php
                                        echo '$' . ' ' . $facturas['ganancia'];
                                    }
                                }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final dia con menor ganancias -->

            <!-- Usuario con mayor ventas realizadas -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Usuario con mayor ventas realizadas</div>
                    <div class="card-body">
                        <div class="row row-cols-2">
                            <div class="col text-center">
                                <h5>Usuario</h5>
                                <?php
                                $query_facturas = mysqli_query($conection, "SELECT * FROM usuario_venta_$desde ORDER BY `usuario_venta_$desde`.`totalVentas` DESC LIMIT 1");
                                $result_facturas = mysqli_num_rows($query_facturas);
                                if ($result_facturas > 0) {
                                    while ($facturas = mysqli_fetch_array($query_facturas)) {
                                        echo $facturas['nombreUsuario'] . ' ' . $facturas['apellidoUsuario'];
                                ?>
                            </div>

                            <div class="col text-center">
                                <h5>Total</h5>
                        <?php
                                        echo $facturas['totalVentas'];
                                    }
                                }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final usuario con mayor ventas realizadas -->

            <!-- Usuario con menor ventas registradas -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Usuario con menor ventas realizadas</div>
                    <div class="card-body">
                        <div class="row row-cols-2">
                            <div class="col text-center">
                                <h5>Usuario</h5>
                                <?php
                                $query_facturas = mysqli_query($conection, "SELECT * FROM usuario_venta_$desde ORDER BY `usuario_venta_$desde`.`totalVentas` ASC LIMIT 1");
                                $result_facturas = mysqli_num_rows($query_facturas);
                                if ($result_facturas > 0) {
                                    while ($facturas = mysqli_fetch_array($query_facturas)) {
                                        echo $facturas['nombreUsuario'] . ' ' . $facturas['apellidoUsuario'];
                                ?>
                            </div>

                            <div class="col text-center">
                                <h5>Total</h5>
                        <?php
                                        echo $facturas['totalVentas'];
                                    }
                                }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final suario con menor ventas realizadas -->
        </div>
        <!-- Final datos 2 -->

        <!-- Graficas en barras -->
        <div class="graficas">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-2 g-4">
                <!-- Grafica de fechas con mayor ganancias -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Fechas con mayor ganancias</div>
                        <div class="card-body">
                            <canvas id="barFMayor" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final grafica de fechas con mayor ganancias -->

                <!-- Graficas de fechas con menor ganancias -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Fechas con menor ganancias</div>
                        <div class="card-body">
                            <canvas id="barFMenor" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final grafica de fechas con menor ganancias -->
            </div>
        </div>
        <!-- Final graficas en barras -->

        <!-- Grafica grande -->
        <div class="lineChart">
            <div class="row row-cols-1 g-4">

                <!-- Grafica ganancias -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Total de ventas realizadas por los usuarios</div>
                        <div class="card-body">
                            <canvas id="ventasUsuario" height="400px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final grafica ganancias -->
            </div>
        </div>
        <!-- Final grafica grande -->

    </div>
    </div>

    </div>

    <?php include "includes/footer.php"; ?>

    <script type="text/javascript">
        fechaMayorGanancias();
        fechaMenorGanancias();
        ventasUsuario();

        function fechaMayorGanancias() {
            var fecha = [];
            var ganancias = [];
            var data = <?php $resultado = mayorGananciasPorFecha($desde); ?>;

            for (var i = 0; i < data.length; i++) {
                fecha.push(data[i][0]);
                ganancias.push(data[i][1]);
            }

            const ctx = document.getElementById('barFMayor').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fecha,
                    datasets: [{
                        label: 'Total de ganancias',
                        data: ganancias,
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

        function fechaMenorGanancias() {
            var fecha = [];
            var ganancias = [];
            var data = <?php $resultado = menorGananciasPorFecha($desde); ?>;

            for (var i = 0; i < data.length; i++) {
                fecha.push(data[i][0]);
                ganancias.push(data[i][1]);
            }

            const ctx = document.getElementById('barFMenor').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: fecha,
                    datasets: [{
                        label: 'Total de ganancias',
                        data: ganancias,
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

        function ventasUsuario() {
            var usuarios = [];
            var ventas = [];
            var data = <?php $resultado = ventasUsuarioAño($desde); ?>;

            for (var i = 0; i < data.length; i++) {
                usuarios.push(data[i][0]);
                ventas.push(data[i][2]);
            }

            const ctx = document.getElementById('ventasUsuario').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: usuarios,
                    datasets: [{
                        label: 'Total de ventas',
                        data: ventas,
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
    </script>
</body>

</html>