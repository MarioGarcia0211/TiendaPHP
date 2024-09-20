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
    <title>Editar proveedor</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
        $iduser = $_GET['id']; 
        $emailUsuario = $_SESSION['email'];
        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario esta editando al proveedor con el id $iduser')");
    ?>

    <?php
    if (!empty($_POST)) {
        $alert = "";
        if (empty($_POST['nombreProveedor']) || empty($_POST['nombreContacto']) ||  empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['captcha'])) {

            $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
              </div>';
        } else {

            if ($_POST['captcha'] != $_POST['codigo']) {
                $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el codigo.
                  </div>';
            } else {
                $idProveedor = $_POST['idProveedor'];
                $nombreProveedor = $_POST['nombreProveedor'];
                $nombreContacto = $_POST['nombreContacto'];
                $telefono = $_POST['telefono'];
                $direccion = $_POST['direccion'];

                $result = 0;


                $query = mysqli_query($conection, "SELECT * FROM proveedores WHERE (nombreProveedor = '$nombreProveedor' AND idproveedor != '$idProveedor')");

                $result = mysqli_fetch_array($query);


                if ($result > 0) {
                    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario no ha podido actualizar al proveedor con el id $idProveedor porque habia colocado el nombre de un proveedor ya registrado: nombre del proveedor -> $nombreProveedor')");

                    $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El proveedor ya existe.
                  </div>';
                } else {

                    $sql_update = mysqli_query($conection, "UPDATE proveedores SET nombreProveedor = '$nombreProveedor', nombreContacto = '$nombreContacto', telefono = '$telefono', direccion = '$direccion' WHERE idProveedor = '$idProveedor'");

                    if ($sql_update) {
                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario ha actualizado al proveedor con el id $idProveedor con los siguientes datos: nombreProveedor -> $nombreProveedor, nombreContacto -> $nombreContacto, telefono -> $telefono, direccion -> $direccion')");

                        $alert = '<div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i> Proveedor actualizado correctamente.
                      </div>';
                    } else {
                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario le ha salido un error actualizar al proveedor con el id $idProveedor')");

                        $alert = '<div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar el proveedor.
                      </div>';
                    }
                }
            }
        }
    }

    //Mostrar datos

    if (empty($_GET['id'])) {
        header('Location: lista_proveedor.php');
    }

    $iduser = $_GET['id'];

    $sql = mysqli_query($conection, "SELECT proveedores.idProveedor, proveedores.nombreProveedor, proveedores.nombreContacto, proveedores.telefono, proveedores.direccion FROM proveedores WHERE idProveedor = $iduser");

    $result_sql = mysqli_num_rows($sql);

    if ($result_sql == 0) {
        header('Location: lista_proveedor.php');
    } else {

        while ($data = mysqli_fetch_array($sql)) {

            $iduser = $data['idProveedor'];
            $nombreProveedor = $data['nombreProveedor'];
            $nombreContacto = $data['nombreContacto'];
            $telefono = $data['telefono'];
            $direccion = $data['direccion'];
        }
    }
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_proveedor.php">Lista de proveedores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_proveedor.php">Registrar proveedor</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active">Editar proveedor</a>
            </li>
        </ul>

        <h1>Editar proveedor</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">
                <!-- Id -->
                <input class="form-control" type="hidden" name="idProveedor" id="idProveedor" value="<?php echo $iduser; ?>">
                <!-- final id -->

                <!-- Nombre del proveedor -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del proveedor</label>
                    <input class="form-control" type="text" name="nombreProveedor" id="nombreProveedor" value="<?php echo $nombreProveedor; ?>">
                </div>
                <!-- Final nombre del proveedor -->

                <!-- Nombre del contacto -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del contacto</label>
                    <input class="form-control" type="text" name="nombreContacto" id="nombreContacto" value="<?php echo $nombreContacto; ?>">
                </div>
                <!-- Final Nombre del contacto -->


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

                <!-- boton registar -->
                <div class="d-grid justify-content-md-center">
                    <button type="submit" class="btn btn-primary">Editar Proveedor</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

</body>

</html>