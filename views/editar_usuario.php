<?php
include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    //log
    $emailUsuario = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario esta editando un usuario')");
    ?>

    <?php

    $rand = rand(1000, 9999);
    if (!empty($_POST)) {
        $alert = "";
        if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['email']) || empty($_POST['rol']) || empty($_POST['captcha'])) {

            $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
                    </div>';
        } else {
            if ($_POST['captcha'] != $_POST['codigo']) {
                $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el codigo.
          </div>';
            } else {
                $idUsuario = $_POST['idUsuario'];
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $email = $_POST['email'];
                $clave = md5($_POST['clave']);
                $rol = $_POST['rol'];

                $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE (email = '$email' AND idUsuario != '$idUsuario')");

                $result = mysqli_fetch_array($query);

                if ($result > 0) {
                    //log
                    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario no ha podido actualizar al usuario con el id $iduser porque habia colocado un email que ya esta registrado: email -> $email')");
                    $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El email ya existe.
              </div>';
                } else {

                    if (empty($_POST['clave'])) {

                        $sql_update = mysqli_query($conection, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', idRol = '$rol' WHERE idUsuario = '$idUsuario'");
                    } else {
                        $sql_update = mysqli_query($conection, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', clave = '$clave', idRol = '$rol' WHERE idUsuario = '$idUsuario'");
                    }



                    if ($sql_update) {
                        //log
                        $iduser = $_GET['id'];
                        $emailUsuario = $_SESSION['email'];
                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario ha actualizado al usuario con el id $iduser con los siguientes datos: nombre -> $nombre, apellido -> $apellido, email -> $email, idRol -> $rol')");
                        $alert = '<div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i> Usuario actualizado correctamente.
                  </div>';
                    } else {
                        //log
                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario le ha salido un error al actualizar al usuario con el id $iduser')");
                        $alert = '<div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar el usuario.
                  </div>';
                    }
                }
            }
        }
    }



    //Mostrar datos del usuario

    if (empty($_GET['id'])) {
        header('Location: lista_usuario.php');
    }

    $iduser = $_GET['id'];

    $sql = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idRol AS idRol, roles.rol AS rol FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol WHERE idUsuario = $iduser");

    $result_sql = mysqli_num_rows($sql);

    if ($result_sql == 0) {
        header('Location: lista_usuario.php');
    } else {

        $optionRol = '';
        while ($data = mysqli_fetch_array($sql)) {

            $iduser = $data['idUsuario'];
            $name = $data['nombre'];
            $apellido = $data['apellido'];
            $email = $data['email'];
            $idRol = $data['idRol'];
            $rol = $data['rol'];

            if ($idRol == 1) {
                $optionRol = '<option value="' . $idRol . '" selected>' . $rol . '</option>';
            } else if ($idRol == 2) {
                $optionRol = '<option value="' . $idRol . '" selected>' . $rol . '</option>';
            } else if ($idRol == 3) {
                $optionRol = '<option value="' . $idRol . '" selected>' . $rol . '</option>';
            }
        }
    }
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_usuario.php">Lista de usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_usuario.php">Registrar usuario</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">Editar usuario</a>
            </li>
        </ul>

        <h1>Editar usuario</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id -->
                <input class="form-control" type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $iduser; ?>">
                <!-- final id -->

                <!-- Nombre -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $name; ?>">
                </div>
                <!-- Final nombre -->

                <!-- Apellido -->
                <div class="form-group col-md-6">
                    <label class="form-label">Apellido</label>
                    <input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $apellido; ?>">
                </div>
                <!-- Final apellido -->

                <!-- Email -->
                <div class="form-group col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>">
                </div>
                <!-- Final email -->

                <!-- Contraseña -->
                <div class="form-group col-md-6">
                    <label class="form-label">Contraseña</label>
                    <input class="form-control" type="password" name="clave" id="clave">
                </div>
                <!-- Final contraseña -->



                <!-- Rol -->

                <?php

                include "../conexion.php";
                if ($_SESSION['rol'] == 1) {
                    $query_rol = mysqli_query($conection, "SELECT * FROM roles");
                    $result_rol = mysqli_num_rows($query_rol);
                } else {
                    $query_rol = mysqli_query($conection, "SELECT * FROM roles WHERE idRol != 1");
                    $result_rol = mysqli_num_rows($query_rol);
                }
                ?>

                <div class="form-group col-md-6">
                    <label class="form-label">Rol</label>
                    <select class="form-select notItemOne" name="rol" id="rol">
                        <?php
                        echo $optionRol;
                        if ($result_rol > 0) {
                            while ($rol = mysqli_fetch_array($query_rol)) {
                        ?>
                                <option value="<?php echo $rol["idRol"]; ?>"><?php echo $rol["rol"] ?></option>

                        <?php
                            }
                        }
                        ?>


                    </select>
                </div>
                <!-- Final rol -->

                <!-- Captcha -->
                <div class="form-group col-md-3 col-sm-6">
                    <label class="form-label">Captcha</label>
                    <input type="text" class="form-control" name="captcha" id="captcha">
                </div>

                <div class="form-group col-md-3 col-sm-6">
                    <label class="form-label">Código del captcha</label>
                    <input type="text" class="form-control text-center" name="codigo" id="codigo" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%); color:white;" value="<?php echo $rand; ?>" readonly>
                </div>
                <!-- Final captcha -->

                <!-- boton registar -->
                <div class="d-grid justify-content-md-center">
                    <button type="submit" class="btn btn-primary">Editar Usuario</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>