<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de ventas</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_venta.php">Lista de ventas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_venta.php">Registrar venta</a>
            </li>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Lista de ventas</h1>

                <!-- Busqueda normal -->
                <!-- <form class="d-flex" role="search" action="buscar_venta.php" method="get">
                    <input class="form-control me-2" type="date" name="busqueda" id="busqueda" placeholder="N° de factura" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                </form> -->
            </div>
        </nav>

        <div class="card border">
            <div class="card-body">
                <div class="contenido-tabla">
                    <div class="table-responsive">
                        <table class="table table-bordered table-fixed table-striped">
                            <thead class="cabecera text-center">
                                <tr>
                                    <th scope="col">Fecha / Hora</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Vendedor</th>
                                    <th scope="col">Total factura</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion
                                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalClientes FROM facturas WHERE facturas.estado != 10");
                                $result_register = mysqli_fetch_array($sql_registe);
                                $total_registro = $result_register['totalClientes'];

                                $por_pagina = 5;

                                if (empty($_GET['pagina'])) {
                                    $pagina = 1;
                                } else {
                                    $pagina = $_GET['pagina'];
                                }

                                $desde = ($pagina - 1) * $por_pagina;
                                $total_por_paginas = ceil($total_registro / $por_pagina) + 1;
                                $es = mysqli_query($conection, "SET lc_time_names = 'es_CO';");
                                $query = mysqli_query($conection, "SELECT facturas.idFactura, DATE_FORMAT(facturas.fecha, '%d/%M/%Y %l:%i:%s %p') AS fecha, facturas.idUsuario, facturas.idCliente,facturas.totalFactura, facturas.estado, usuarios.nombre as vendedor, clientes.nombre as cliente 
                                                                    FROM facturas 
                                                                    INNER JOIN clientes ON facturas.idCliente = clientes.idCliente
                                                                    INNER JOIN usuarios ON facturas.idUsuario = usuarios.idUsuario 
                                                                    WHERE facturas.estado != 10 ORDER BY `facturas`.`fecha` DESC 
                                                                    LIMIT $desde,$por_pagina ");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr>
                                            <!-- <td class="align-middle"><?php echo $data["idFactura"] ?></td> -->
                                            <td class="align-middle"><?php echo $data["fecha"] ?></td>
                                            <td class="align-middle"><?php echo $data["cliente"] ?></td>
                                            <td class="align-middle"><?php echo $data["vendedor"] ?></td>
                                            <td class="align-middle"><?php echo $data["totalFactura"] ?></td>
                                            <td class="align-middle">
                                                <div class="d-grid gap-2 d-md-block">
                                                    <button class="btn btn-primary btn-sm view_factura" cl="<?php echo $data["idCliente"] ?>" f="<?php echo $data["idFactura"] ?>"><i class="bi bi-eye"></i></button>
                                                </div>
                                            </td>
                                        </tr>

                                <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">

                            <?php
                            if ($pagina != 1) {


                            ?>

                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                                </li>
                            <?php
                            }
                            

                            if ($pagina != $total_por_paginas - 1) {


                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="?pagina=<?php echo $pagina + 1; ?>">Siguiente</a>
                                </li>

                            <?php
                            }
                            ?>
                        </ul>
                    </nav>
                    <ul class="pagination justify-content-end">

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php include "includes/footer.php"; ?>
    <script src="js/traerId.js"></script>
</body>

</html>