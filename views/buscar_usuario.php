<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuarios</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    $busqueda = strtolower($_REQUEST['busqueda']);
    if (empty($busqueda)) {
        header('location: lista_usuario.php');
    }

    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario buscó $busqueda en la lista de los usuarios')");
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="lista_usuario.php">Lista de usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_usuario.php">Registrar usuario</a>
            </li>
        </ul>

        <nav class="navbar">
            <h1>Lista de usuarios</h1>

            <form class="d-flex" role="search" action="buscar_usuario.php" method="get">
                <input class="form-control me-2" type="search" name="busqueda" id="busqueda" placeholder="Buscar" aria-label="Search" value="<?php echo $busqueda; ?>">
                <button class="btn btn-outline-success" type="submit"><i class="bi bi-search"></i></button>
            </form>
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
                                    <th scope="col" data-toggle="tooltip" title="Email">Email</th>
                                    <th scope="col" data-toggle="tooltip" title="Rol">Rol</th>
                                    <th scope="col" data-toggle="tooltip" title="Acciones">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                //Paginacion

                                $rol = '';
                                if ($busqueda == 'administrador') {
                                    $rol = "OR idRol LIKE '%1%'";
                                } elseif ($busqueda == 'supervisor') {
                                    $rol = "OR idRol LIKE '%2%'";
                                } elseif ($busqueda == 'vendedor') {
                                    $rol = "OR idRol LIKE '%3%'";
                                }

                                $query = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idRol, roles.rol FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol 
                                WHERE (usuarios.nombre LIKE '%$busqueda%' OR usuarios.apellido LIKE '%$busqueda%' OR usuarios.email LIKE '%$busqueda%' OR roles.rol LIKE '%$busqueda%') AND
                                estado = 1 ORDER BY `usuarios`.`idUsuario` ASC");

                                $result = mysqli_num_rows($query);

                                if ($result > 0) {
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>

                                        <tr>
                                            <td><?php echo $data["nombre"] ?></td>
                                            <td><?php echo $data["apellido"] ?></td>
                                            <td><?php echo $data["email"] ?></td>
                                            <td><?php echo $data["rol"] ?></td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-block">
                                                    <a href="editar_usuario.php?id=<?php echo $data["idUsuario"] ?>" class="btn btn-primary btn-sm" type="button" title="Editar"><i class="bi bi-pencil-square"></i></a>

                                                    <?php if ($data["idRol"] != 1) { ?>
                                                        <a href="eliminar_usuario.php?id=<?php echo $data["idUsuario"] ?>" class="btn btn-danger btn-sm" type="button" title="Eliminar"><i class="bi bi-trash"></i></a>
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