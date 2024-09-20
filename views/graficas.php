<?php
include "../conexion.php";


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
    </style>
</head>

<body>
    <?php include "includes/navbar.php";
    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario esta navegando en las graficas')");
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
                    <!-- Año -->
                    <div class="col-auto">
                        <div class="input-group">
                            <div class="input-group-text">Año</div>
                            <select class="form-select" name="desde" id="desde" aria-label="Search" aria-label="Default select example">
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option selected value="">2023</option>
                            </select>
                        </div>
                    </div>
                    <!-- Año -->

                    <div class="col-auto">
                        <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </nav>

        <!-- Datos -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
            <!-- Total de usuarios -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Total de usuarios</div>
                    <div class="card-body text-center">
                        <?php
                        $query_usuarios = mysqli_query($conection, "SELECT COUNT(*) AS totalUsuarios FROM usuarios WHERE estado = 1");
                        $result_usuarios = mysqli_num_rows($query_usuarios);
                        if ($result_usuarios > 0) {
                            while ($usuarios = mysqli_fetch_array($query_usuarios)) {
                                echo $usuarios["totalUsuarios"];
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Final total de usuarios -->

            <!-- Total de clientes -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Total de clientes</div>
                    <div class="card-body text-center">
                        <?php
                        $query_clientes = mysqli_query($conection, "SELECT COUNT(*) AS totalClientes FROM clientes");
                        $result_clientes = mysqli_num_rows($query_clientes);
                        if ($result_clientes > 0) {
                            while ($clientes = mysqli_fetch_array($query_clientes)) {
                                echo $clientes["totalClientes"];
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Final total de clientes -->

            <!-- Total de proveedores -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Total de proveedores</div>
                    <div class="card-body text-center">
                        <?php
                        $query_proveedores = mysqli_query($conection, "SELECT COUNT(*) AS totalProveedores FROM proveedores");
                        $result_proveedores = mysqli_num_rows($query_proveedores);
                        if ($result_proveedores > 0) {
                            while ($proveedores = mysqli_fetch_array($query_proveedores)) {
                                echo $proveedores["totalProveedores"];
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Final de total de proveedores -->

            <!-- Total de productos -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Total de productos</div>
                    <div class="card-body text-center">
                        <?php
                        $query_productos = mysqli_query($conection, "SELECT sum(existencia) as total FROM productos");
                        $result_productos = mysqli_num_rows($query_productos);
                        if ($result_productos > 0) {
                            while ($productos = mysqli_fetch_array($query_productos)) {
                                echo $productos["total"];
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- Final de total de productos -->

            <!-- Total de ventas -->
            <div class="col">
                <div class="card chart">
                    <div class="card-header">Total de ventas</div>
                    <div class="card-body text-center">
                        <?php
                        $query_facturas = mysqli_query($conection, "SELECT count(*) as total FROM facturas");
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
            <!-- Final de total de ventas -->
        </div>
        <!-- Final datos -->

        <!-- Datos 2 -->
        <div class="datos2 row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4 g-4">

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
                                $query_facturas = mysqli_query($conection, "SELECT DATE_FORMAT(facturas.fecha, '%d/%M/%Y') AS fecha, SUM(totalFactura) AS ganancia FROM facturas GROUP BY DATE_FORMAT(facturas.fecha, '%d/%M/%Y') ORDER BY `ganancia` DESC LIMIT 1;");
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
                                $query_facturas = mysqli_query($conection, "SELECT DATE_FORMAT(facturas.fecha, '%d/%M/%Y') AS fecha, SUM(totalFactura) AS ganancia FROM facturas GROUP BY DATE_FORMAT(facturas.fecha, '%d/%M/%Y') ORDER BY `ganancia` ASC LIMIT 1;");
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
                                $query_facturas = mysqli_query($conection, "SELECT facturas.idUsuario, usuarios.nombre AS nombreVendedor, usuarios.apellido AS apellidoVendedor, COUNT(*) AS totalVentas FROM `facturas` INNER JOIN usuarios ON facturas.idUsuario = usuarios.idUsuario GROUP BY idUsuario  
                                ORDER BY `totalVentas` DESC LIMIT 1;");
                                $result_facturas = mysqli_num_rows($query_facturas);
                                if ($result_facturas > 0) {
                                    while ($facturas = mysqli_fetch_array($query_facturas)) {
                                        echo $facturas['nombreVendedor'] . ' ' . $facturas['apellidoVendedor'];
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
                                $query_facturas = mysqli_query($conection, "SELECT facturas.idUsuario, usuarios.nombre AS nombreVendedor, usuarios.apellido AS apellidoVendedor, COUNT(*) AS totalVentas FROM `facturas` INNER JOIN usuarios ON facturas.idUsuario = usuarios.idUsuario GROUP BY idUsuario  
                                ORDER BY `totalVentas` ASC LIMIT 1;");
                                $result_facturas = mysqli_num_rows($query_facturas);
                                if ($result_facturas > 0) {
                                    while ($facturas = mysqli_fetch_array($query_facturas)) {
                                        echo $facturas['nombreVendedor'] . ' ' . $facturas['apellidoVendedor'];
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
                            <canvas id="barFechaMayor" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final grafica de fechas con mayor ganancias -->

                <!-- Graficas de fechas con menor ganancias -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Fechas con menor ganancias</div>
                        <div class="card-body">
                            <canvas id="barFechaMenor" height="200px"></canvas>
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
                            <canvas id="barUsuarios" height="400px"></canvas>
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
    <script src="js/graficas.js"></script>
</body>

</html>