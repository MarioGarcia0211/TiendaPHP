<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trazabilidad de navegación</title>
    <?php include "includes/scripts.php"; ?>

</head>

<body>
    <?php include "includes/navbar.php";
    $busqueda = strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)) {
        header('location: trazabilidad_navegacion.php');
    }
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="trazabilidad.php">Trazabilidad del login</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active" href="trazabilidad_navegacion.php">Trazabilidad de navegación</a>
            </li>

        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Trazabilidad de la navegación</h1>
                <form class="d-flex" role="search" action="buscar_trazabilidad_navegacion.php" method="get">
                    <input class="form-control me-2" type="date" name="busqueda" id="busqueda" placeholder="Buscar" aria-label="Search" value="<?php echo $busqueda; ?>">
                    <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </nav>


        <div class="card border">
            <div class="card-body">
                <div class="contenido-tabla">
                    <div class="table-responsive">
                        <table class="table table-bordered table-fixed table-striped">
                            <thead class="cabecera text-center">
                                <tr>

                                    <th scope="col" data-toggle="tooltip" title="Email">Email</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido">Descripción</th>
                                    <th scope="col" data-toggle="tooltip" title="Email">Fecha</th>

                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion
                                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalUsuarios FROM log_navegacion WHERE (fecha LIKE '%$busqueda%')");
                                $result_register = mysqli_fetch_array($sql_registe);
                                $total_registro = $result_register['totalUsuarios'];

                                $por_pagina = 5;

                                if (empty($_GET['pagina'])) {
                                    $pagina = 1;
                                } else {
                                    $pagina = $_GET['pagina'];
                                }

                                $desde = ($pagina - 1) * $por_pagina;
                                $total_por_paginas = ceil($total_registro / $por_pagina) + 1;
                                $query = mysqli_query($conection, "SELECT * FROM log_navegacion WHERE (fecha LIKE '%$busqueda%') ORDER BY `log_navegacion`.`idLogNavegacion` DESC LIMIT $desde,$por_pagina");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr class="hola">

                                            <td class="align-middle"><?php echo $data["email"] ?></td>
                                            <td class="align-middle"><?php echo $data["descripcion"] ?></td>
                                            <td class="align-middle"><?php echo $data["fecha"] ?></td>
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
                                    <a class="page-link" href="?busqueda=<?php echo $busqueda;?>&pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                                </li>
                            <?php
                            }

                            if ($pagina != $total_por_paginas - 1) {
                            ?>
                                <li class="page-item">
                                    <a class="page-link" href="?busqueda=<?php echo $busqueda;?>&pagina=<?php echo $pagina + 1; ?>">Siguiente</a>
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