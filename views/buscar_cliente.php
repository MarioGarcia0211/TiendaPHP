<?php
include "../conexion.php";

$busqueda = strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)) {
        header('location: lista_cliente.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de clientes</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_cliente.php">Lista de clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_cliente.php">Registrar cliente</a>
            </li>
        </ul>

        <nav class="navbar">
        <div class="container-fluid">
            <h1 >Lista de clientes</h1>
            <form class="d-flex" role="search" action="buscar_cliente.php" method="get">
                <input class="form-control me-2" type="search" name="busqueda" id="busqueda" placeholder="Buscar" aria-label="Search" value="<?php echo $busqueda; ?>">
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
                                    <th scope="col" data-toggle="tooltip" title="Nombre">Nombre</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido">Apellido</th>
                                    <th scope="col" data-toggle="tooltip" title="Tipo de documento">Tipo de documento</th>
                                    <th scope="col" data-toggle="tooltip" title="Número del documento">Número del documento</th>
                                    <th scope="col" data-toggle="tooltip" title="Teléfono">Teléfono</th>
                                    <th scope="col" data-toggle="tooltip" title="Dirección">Dirección</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                
                                $query = mysqli_query($conection, "SELECT clientes.idCliente, clientes.nombre, clientes.apellido, clientes.tipoDocumento, clientes.numeroDocumento, clientes.telefono, clientes.direccion, tipoDocumento.tipoDocumento FROM clientes INNER JOIN tipoDocumento ON clientes.tipoDocumento = tipoDocumento.idTipoDocumento WHERE (clientes.nombre LIKE '%$busqueda%' OR clientes.apellido LIKE '%$busqueda%' OR clientes.numeroDocumento LIKE '$busqueda' OR  clientes.telefono LIKE '$busqueda' OR  clientes.direccion LIKE '$busqueda') AND estado = 1 ORDER BY `clientes`.`idCliente` ASC");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr>
                                            <td><?php echo $data["nombre"] ?></td>
                                            <td><?php echo $data["apellido"] ?></td>
                                            <td><?php echo $data["tipoDocumento"] ?></td>
                                            <td><?php echo $data["numeroDocumento"] ?></td>
                                            <td><?php echo $data["telefono"] ?></td>
                                            <td><?php echo $data["direccion"] ?></td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-block">
                                                    <a href="editar_cliente.php?id=<?php echo $data["idCliente"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>

                                                    <?php if($_SESSION['rol'] == '1' || '2'){  ?>
                                                    <a href="eliminar_cliente.php?id=<?php echo $data["idCliente"] ?>" class="btn btn-danger btn-sm" type="button" title="Eliminar"><i class="bi bi-trash"></i></a>
                                                    <?php } ?>
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
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>