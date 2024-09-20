<?php
$rand = rand(1000, 9999);
include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; 
    $emailUsuario = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario esta editando un cliente')");
    ?>

    <?php
    if (!empty($_POST)) {
        $alert = "";
        if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['tipoDocumento']) || empty($_POST['numeroDocumento']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['captcha'])) {

            $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
                            </div>';
        } else {

            if ($_POST['captcha'] != $_POST['codigo']) {
                $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el codigo.
                  </div>';
            } else {
                $idCliente = $_POST['idCliente'];
                $nombreCliente = $_POST['nombre'];
                $apellidoCliente = $_POST['apellido'];
                $tipoDocumento = $_POST['tipoDocumento'];
                $numeroDocumento = $_POST['numeroDocumento'];
                $telefono = $_POST['telefono'];
                $direccion = $_POST['direccion'];
                $id_usuario = $_POST['id_usuario'];

                $query = mysqli_query($conection, "SELECT * FROM clientes WHERE (numeroDocumento = '$numeroDocumento' AND idCliente != '$idCliente')");

                $result = mysqli_fetch_array($query);

                if ($result > 0) {
                    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario no ha podido actualizar al cliente con el id $idCliente porque habia colocado un numero de documento que ya esta registrado: numero del documento -> $numeroDocumento')");
                    $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El número del documento ya existe.
                      </div>';
                } else {

                    $sql_update = mysqli_query($conection, "UPDATE clientes SET nombre = '$nombreCliente', apellido = '$apellidoCliente', tipoDocumento = '$tipoDocumento', numeroDocumento = '$numeroDocumento', telefono = '$telefono', direccion = '$direccion', id_usuario = '$id_usuario' WHERE idCliente = '$idCliente'");

                    if ($sql_update) {
                        $idCliente = $_GET['id'];
                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario ha actualizado al cliente con el id $idCliente con los siguientes datos: nombre -> $nombreCliente, apellido -> $apellidoCliente, tipoDocumento -> $tipoDocumento, numeroDocumento -> $numeroDocumento, telefono -> $telefono, direccion -> $direccion')");
                        $alert = '<div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i> Cliente actualizado correctamente.
                          </div>';
                          
                    } else {
                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario le ha salido un error actualizar al cliente con el id $idCliente')");

                        $alert = '<div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar el cliente.
                          </div>';
                    }
                }
            }
        }
    }

    //Mostrar datos del usuario

    if (empty($_GET['id'])) {
        header('Location: lista_cliente.php');
    }

    $iduser = $_GET['id'];

    $sql = mysqli_query($conection, "SELECT clientes.idCliente, clientes.nombre, clientes.apellido, clientes.tipoDocumento AS idTipoDocumento, tipodocumento.tipoDocumento AS tipoDocumento, clientes.numeroDocumento, clientes.telefono, clientes.direccion, clientes.id_usuario FROM clientes INNER JOIN tipodocumento ON clientes.tipoDocumento = tipodocumento.idTipoDocumento WHERE idCliente = $iduser");

    $result_sql = mysqli_num_rows($sql);

    if ($result_sql == 0) {
        header('Location: lista_usuario.php');
    } else {

        $optionDoc = '';
        while ($data = mysqli_fetch_array($sql)) {

            $iduser = $data['idCliente'];
            $name = $data['nombre'];
            $apellido = $data['apellido'];
            $idTipoDocumento = $data['idTipoDocumento'];
            $tipoDocumento = $data['tipoDocumento'];
            $numeroDocumento = $data['numeroDocumento'];
            $telefono = $data['telefono'];
            $direccion = $data['direccion'];
            $id_usuario = $data['id_usuario'];

            if ($idTipoDocumento == 1) {
                $optionDoc = '<option value="' . $idTipoDocumento . '" selected>' . $tipoDocumento . '</option>';
            } else if ($idTipoDocumento == 2) {
                $optionDoc = '<option value="' . $idTipoDocumento . '" selected>' . $tipoDocumento . '</option>';
            } else if ($idTipoDocumento == 3) {
                $optionDoc = '<option value="' . $idTipoDocumento . '" selected>' . $tipoDocumento . '</option>';
            }
        }
    }
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_cliente.php">Lista de clientes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_cliente.php">Registrar cliente</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">Editar cliente</a>
            </li>
        </ul>

        <h1>Editar Cliente</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id -->
                <input class="form-control" type="hidden" name="idCliente" id="idCliente" value="<?php echo $iduser; ?>">
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

                <!-- Tipo documento -->

                <?php

                include "../conexion.php";
                $query_tipo = mysqli_query($conection, "SELECT * FROM tipodocumento");
                $result_tipo = mysqli_num_rows($query_tipo);
                ?>

                <div class="form-group col-md-6">
                    <label class="form-label">Tipo del documento</label>
                    <select class="form-select notItemOne" name="tipoDocumento" id="tipoDocumento">
                        <?php
                        echo $optionDoc;
                        if ($result_tipo > 0) {
                            while ($tipo = mysqli_fetch_array($query_tipo)) {
                        ?>
                                <option value="<?php echo $tipo["idTipoDocumento"]; ?>"><?php echo $tipo["tipoDocumento"] ?></option>

                        <?php
                            }
                        }
                        ?>


                    </select>
                </div>
                <!-- Final Tipo documento -->

                <!-- Numero del documento -->
                <div class="form-group col-md-6">
                    <label class="form-label">Número del documento</label>
                    <input class="form-control" placeholder="Escribirlo sin punto y sin comas." type="number" name="numeroDocumento" id="numeroDocumento" value="<?php echo $numeroDocumento; ?>">
                </div>
                <!-- Final numero del documento -->

                <!-- Numero telefonico -->
                <div class="form-group col-md-6">
                    <label class="form-label">Número telefonico</label>
                    <input class="form-control" type="number" name="telefono" id="telefono" value="<?php echo $telefono; ?>">
                </div>
                <!-- Final numero telefonico -->

                <!-- Dirección -->
                <div class="form-group col-md-6">
                    <label class="form-label">Dirección</label>
                    <input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>">
                </div>
                <!-- Final Dirección -->

                <!-- Captcha -->
                <div class="form-group col-md-6">
                    <label class="form-label">Captcha</label>
                    <input type="text" class="form-control" name="captcha" id="captcha">
                </div>

                <div class="form-group col-md-6">
                    <label class="form-label">Código del captcha</label>
                    <input type="text" class="form-control text-center" name="codigo" id="codigo" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%); color:white;" value="<?php echo $rand; ?>" readonly>
                </div>
                <!-- Final captcha -->

                <!-- ID del creador -->
                <input class="form-control" placeholder="ID del creador" type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>">
                <!-- Final ID del creador -->

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