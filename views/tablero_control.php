<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero de control</title>
    <?php include "includes/scripts.php"; ?>

    <style>
        .graficas {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <?php include "includes/navbar.php";
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="graficas.php">Datos generales</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="tablero_control.php">Tableros de control</a>
            </li>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Tableros de control</h1>
            </div>
        </nav>

        <!-- Datos -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4">
            <!-- Total de usuarios -->
            <div class="col">
                <?php
                $colorUsuario = "";
                $borderUsuario = "";
                $porcentajeUsuario = 0;
                $metaUsuario = 10;
                $mitadUsuario = $metaUsuario / 2;
                $colorPorcentajeUsuario = "";
                $query_usuarios = mysqli_query($conection, "SELECT COUNT(*) AS totalUsuarios FROM usuarios WHERE estado = 1");
                $result_usuarios = mysqli_num_rows($query_usuarios);
                if ($result_usuarios > 0) {
                    while ($usuarios = mysqli_fetch_array($query_usuarios)) {
                        $datos = $usuarios["totalUsuarios"];

                        if ($datos < $mitadUsuario) {
                            $colorUsuario = "text-danger";
                            $borderUsuario = "border-danger";
                        } elseif (($datos >= $mitadUsuario) && ($datos < $metaUsuario)) {
                            $colorUsuario = "text-warning";
                            $borderUsuario = "border-warning";
                        } else {
                            $colorUsuario = "text-success";
                            $borderUsuario = "border-success";
                        }

                        $porcentajeUsuario = ($datos*100) / $metaUsuario;

                        if ($porcentajeUsuario < 50) {
                            $colorPorcentajeUsuario = "bg-danger progress-bar-striped progress-bar-animated";
                        } elseif (($porcentajeUsuario >= 50) && ($porcentajeUsuario < 100)) {
                            $colorPorcentajeUsuario = "bg-warning progress-bar-striped progress-bar-animated";
                        } else {
                            $colorPorcentajeUsuario = "bg-success";
                        }

                        if($porcentajeUsuario > 100){
                            $porcentajeUsuario = 100;
                        }
                    }
                }
                ?>
                <div class="card <?php echo $borderUsuario; ?> chart">
                    <div class="card-header">Total de usuarios</div>

                    <div class="card-body text-center <?php echo $colorUsuario; ?>">
                        <h3><?php echo $datos; ?></h3>
                    </div>

                    <div class="card-footer">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar <?php echo $colorPorcentajeUsuario; ?> " style="width: <?php echo $porcentajeUsuario?>%"><?php echo $porcentajeUsuario; ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final total de usuarios -->

            <!-- Total de clientes -->
            <div class="col">
                <?php
                $colorCliente = "";
                $borderCliente = "";
                $porcentajeCliente = 0;
                $metaCliente = 40000;
                $mitadCliente = $metaCliente / 2;
                $colorPorcentajeCliente = "";
                $query_usuarios = mysqli_query($conection, "SELECT COUNT(*) AS totalCliente FROM clientes WHERE estado = 1");
                $result_usuarios = mysqli_num_rows($query_usuarios);
                if ($result_usuarios > 0) {
                    while ($usuarios = mysqli_fetch_array($query_usuarios)) {
                        $datosCli = $usuarios["totalCliente"];

                        if ($datosCli < $mitadCliente) {
                            $colorCliente = "text-danger";
                            $borderCliente = "border-danger";
                        } elseif (($datosCli >= $mitadCliente) && ($datosCli < $metaCliente)) {
                            $colorCliente = "text-warning";
                            $borderCliente = "border-warning";
                        } else {
                            $colorCliente = "text-success";
                            $borderCliente = "border-success";
                        }
                        $porcentajeCliente = round(($datosCli*100) / $metaCliente);

                        if ($porcentajeCliente < 50) {
                            $colorPorcentajeCliente = "bg-danger progress-bar-striped progress-bar-animated";
                        } elseif (($porcentajeCliente >= 50) && ($porcentajeCliente < 100)) {
                            $colorPorcentajeCliente = "bg-warning progress-bar-striped progress-bar-animated";
                        } else {
                            $colorPorcentajeCliente = "bg-success";
                        }

                        if($porcentajeCliente > 100){
                            $porcentajeCliente = 100;
                        }
                    }
                }
                ?>
                <div class="card <?php echo $borderCliente; ?> chart">
                    <div class="card-header">Total de clientes</div>

                    <div class="card-body text-center <?php echo $colorCliente; ?>">
                        <h3><?php echo $datosCli; ?></h3>
                    </div>

                    <div class="card-footer">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar <?php echo $colorPorcentajeCliente; ?> " style="width: <?php echo $porcentajeCliente?>%"><?php echo $porcentajeCliente; ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final total de clientes -->

            <!-- Total de proveedores -->
            <div class="col">
                <?php
                $colorProveedor = "";
                $borderProveedor = "";
                $porcentajeProveedor = 0;
                $metaProveedor = 30;
                $mitadProveedor = $metaProveedor / 2;
                $colorPorcentajeProveedor = "";
                $query_usuarios = mysqli_query($conection, "SELECT COUNT(*) AS totalCliente FROM proveedores WHERE estado = 1");
                $result_usuarios = mysqli_num_rows($query_usuarios);
                if ($result_usuarios > 0) {
                    while ($usuarios = mysqli_fetch_array($query_usuarios)) {
                        $datosCli = $usuarios["totalCliente"];

                        if ($datosCli < $mitadProveedor) {
                            $colorProveedor = "text-danger";
                            $borderProveedor = "border-danger";
                        } elseif (($datosCli >= $mitadProveedor) && ($datosCli < $metaProveedor)) {
                            $colorProveedor = "text-warning";
                            $borderCliente = "border-warning";
                        } else {
                            $colorProveedor = "text-success";
                            $borderProveedor = "border-success";
                        }

                        $porcentajeProveedor = round(($datosCli*100) / $metaProveedor);

                        if ($porcentajeProveedor < 50) {
                            $colorPorcentajeProveedor = "bg-danger progress-bar-striped progress-bar-animated";
                        } elseif (($porcentajeProveedor >= 50) && ($porcentajeProveedor < 100)) {
                            $colorPorcentajeProveedor = "bg-warning progress-bar-striped progress-bar-animated";
                        } else {
                            $colorPorcentajeProveedor = "bg-success";
                        }

                        if($porcentajeProveedor > 100){
                            $porcentajeProveedor = 100;
                        }
                    }
                }
                ?>
                <div class="card <?php echo $borderProveedor; ?> chart">
                    <div class="card-header">Total de proveedores</div>

                    <div class="card-body text-center <?php echo $colorProveedor; ?>">
                        <h3><?php echo $datosCli; ?></h3>
                    </div>

                    <div class="card-footer">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar <?php echo $colorPorcentajeProveedor; ?> " style="width: <?php echo $porcentajeProveedor?>%"><?php echo $porcentajeProveedor; ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final total de proveedores -->

            <!-- Total de ventas -->
            <div class="col">
                <?php
                $colorVentas = "";
                $borderVentas = "";
                $porcentajeVentas = 0;
                $metaVentas = 5000;
                $mitadVentas = $metaVentas / 2;
                $colorPorcentajeVentas = "";
                $query_usuarios = mysqli_query($conection, "SELECT COUNT(totalFactura) AS total FROM `facturas`");
                $result_usuarios = mysqli_num_rows($query_usuarios);
                if ($result_usuarios > 0) {
                    while ($usuarios = mysqli_fetch_array($query_usuarios)) {
                        $datosCli = $usuarios["total"];

                        if ($datosCli < $mitadVentas) {
                            $colorVentas = "text-danger";
                            $borderVentas = "border-danger";
                        } elseif (($datosCli >= $mitadVentas) && ($datosCli < $metaVentas)) {
                            $colorVentas = "text-warning";
                            $borderVentas = "border-warning";
                        } else {
                            $colorVentas = "text-success";
                            $borderVentas = "border-success";
                        }

                        $porcentajeVentas = round(($datosCli*100) / $metaVentas);

                        if ($porcentajeVentas < 50) {
                            $colorPorcentajeVentas = "bg-danger progress-bar-striped progress-bar-animated";
                        } elseif (($porcentajeVentas >= 50) && ($porcentajeVentas < 100)) {
                            $colorPorcentajeVentas = "bg-warning progress-bar-striped progress-bar-animated";
                        } else {
                            $colorPorcentajeVentas = "bg-success";
                        }

                        if($porcentajeVentas > 100){
                            $porcentajeVentas = 100;
                        }
                    }
                }
                ?>
                <div class="card <?php echo $borderVentas; ?> chart">
                    <div class="card-header">Total de ventas</div>

                    <div class="card-body text-center <?php echo $colorVentas; ?>">
                        <h3><?php echo $datosCli; ?></h3>
                    </div>

                    <div class="card-footer">
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar <?php echo $colorPorcentajeVentas; ?> " style="width: <?php echo $porcentajeVentas?>%"><?php echo $porcentajeVentas; ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Final total de ventas -->
        </div>
        <!-- Final datos -->

        <!-- Graficas -->
        <div class="graficas">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 g-4">
                <!-- Grafica de meses ganancias -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Ganancias por mes</div>
                        <div class="card-body">
                            <canvas id="barMes" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final grafica de meses ganancias -->

                <!-- Graficas de meses de facturas -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Facturas por mes</div>
                        <div class="card-body">
                            <canvas id="facturaMes" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final grafica de meses de facturas -->

                <!-- Grafica de facturas realizadas por usuario -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Facturas realizadas por usuario</div>
                        <div class="card-body">
                            <canvas id="usuarioTotal" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final de grafica de facturas realizadas por usuario -->

                <!-- Grafica de la cantidad de 4 productos  -->
                <div class="col">
                    <div class="card chart">
                        <div class="card-header">Cantidad de productos</div>
                        <div class="card-body">
                            <canvas id="productoTotal" height="200px"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Final de grafica de la cantidad de 4 productos -->
            </div>
        </div>
        <!-- Final graficas -->
    </div>
    <?php include "includes/footer.php"; ?>
    <script src="js/tablero.js"></script>

</body>

</html>