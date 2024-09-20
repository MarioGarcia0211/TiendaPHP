<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de productos</title>
    <?php include "includes/scripts.php"; ?>

</head>

<body>
    <?php include "includes/navbar.php"; 
        $email = $_SESSION['email'];
        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario esta navegando en la lista de los productos')");
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_producto.php">Lista de productos</a>
            </li>

            <?php if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '2') {
            ?>
                <li class="nav-item">
                    <a class="nav-link" href="registrar_producto.php">Registrar producto</a>
                </li>

            <?php } ?>
        </ul>

        <nav class="navbar">
            <div class="container-fluid">
                <h1>Lista de productos</h1>

                <form class="d-flex" role="search" action="buscar_producto.php" method="get">
                <input class="form-control me-2" type="search" name="busqueda" id="busqueda" placeholder="Nombre del producto" aria-label="Search">
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
                                <th scope="col" data-toggle="tooltip" title="Código">Código</th>
                                    <th scope="col" data-toggle="tooltip" title="Descripcion">Descripcion</th>
                                    <th scope="col" data-toggle="tooltip" title="Apellido">Proveedor</th>
                                    <th scope="col" data-toggle="tooltip" title="Email">Existencia</th>
                                    <th scope="col" data-toggle="tooltip" title="nombreProveedor">Precio</th>
                                    <th scope="col" data-toggle="tooltip" title="nombreProveedor">Imagen</th>
                                    <?php if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '2') {
                                    ?>
                                        <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion
                                $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS totalUsuarios FROM productos WHERE productos.estado = 1");
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
                                $query = mysqli_query($conection, "SELECT productos.idProducto, productos.descripcion, proveedores.nombreProveedor, productos.existencia, productos.precio, productos.foto FROM productos INNER JOIN proveedores ON productos.idProveedor = proveedores.idProveedor WHERE productos.estado = 1 LIMIT $desde,$por_pagina");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {

                                        if ($data['foto'] != 'img_producto.png') {
                                            $foto = 'images/uploads/' . $data['foto'];
                                        }
                                ?>

                                        <tr class="hola">
                                        <td class="align-middle"><?php echo $data["idProducto"] ?></td>
                                            <td class="align-middle"><?php echo $data["descripcion"] ?></td>
                                            <td class="align-middle"><?php echo $data["nombreProveedor"] ?></td>
                                            <td class="align-middle"><?php echo $data["existencia"] ?></td>
                                            <td class="align-middle"><?php echo $data["precio"] ?></td>
                                            <td><img class="foto-tabla" src="<?php echo $foto; ?>" width="150px"></td>

                                            <?php if ($_SESSION['rol'] == '1' || $_SESSION['rol'] == '2') {
                                            ?>
                                                <td class="align-middle">
                                                    <div class="d-grid gap-2 d-md-block">
                                                        <a href="agregar_producto.php?id=<?php echo $data["idProducto"] ?>" class="btn btn-success btn-sm" type="button" title="Agregar"><i class="bi bi-plus"></i></a>

                                                        <a href="editar_producto.php?id=<?php echo $data["idProducto"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>

                                                        <?php if ($_SESSION['rol'] == '1' || '2') { ?>
                                                            <a href="eliminar_producto.php?id=<?php echo $data["idProducto"] ?>" class="btn btn-danger btn-sm" type="button" title="Eliminar"><i class="bi bi-trash"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            <?php } ?>
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