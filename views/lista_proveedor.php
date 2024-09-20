<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de proveedores</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; 
        $email = $_SESSION['email'];
        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario esta navegando en la lista de los proveedores')");
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_proveedor.php">Lista de proveedores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_proveedor.php">Registrar proveedor</a>
            </li>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1 >Lista de proveedores</h1>
                <form class="d-flex" role="search" action="buscar_proveedor.php" method="get">
                <input class="form-control me-2" type="search" name="busqueda" id="busqueda" placeholder="Buscar" aria-label="Search">
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
                                    <th class="align-middle" scope="col" data-toggle="tooltip" title="Nombre del proveedor">Nombre del proveedor</th>
                                    <th class="align-middle" scope="col" data-toggle="tooltip" title="Nombre del contacto">Nombre del contacto</th>
                                    <th class="align-middle" scope="col" data-toggle="tooltip" title="Teléfono">Teléfono</th>
                                    <th class="align-middle" scope="col" data-toggle="tooltip" title="Dirección">Dirección</th>
                                    <th class="align-middle" scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion
                                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalUsuarios FROM proveedores WHERE proveedores.estado = 1");
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
                                $query = mysqli_query($conection, "SELECT proveedores.idProveedor, proveedores.nombreProveedor, proveedores.nombreContacto, proveedores.telefono, proveedores.direccion FROM proveedores WHERE estado = 1 ORDER BY `proveedores`.`idProveedor` ASC LIMIT $desde,$por_pagina");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr>
                                            <td class="align-middle"><?php echo $data["nombreProveedor"] ?></td>
                                            <td class="align-middle"><?php echo $data["nombreContacto"] ?></td>
                                            <td class="align-middle"><?php echo $data["telefono"] ?></td>
                                            <td class="align-middle"><?php echo $data["direccion"] ?></td>
                                            <td class="align-middle">
                                                <div class="d-grid gap-2 d-md-block">
                                                    <a href="editar_proveedor.php?id=<?php echo $data["idProveedor"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                                    <a href="eliminar_proveedor.php?id=<?php echo $data["idProveedor"] ?>" class="btn btn-danger btn-sm" type="button" title="Eliminar"><i class="bi bi-trash"></i></a>
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
</body>

</html>