<?php 

    include "../conexion.php";

    if (!empty($_POST)) {

        $idCliente = $_POST['idCliente'];

        // $query_delete = mysqli_query($conection, "DELETE FROM usuarios WHERE idCliente = $idCliente");

        $query_delete = mysqli_query($conection, "UPDATE clientes SET estado = 0 WHERE idCliente = $idCliente");

        if($query_delete){
            $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('mario@gmail.com', 'Este usuario ha eliminado al cliente con el id $idCliente')");
            header("location: lista_cliente.php");

        }else {
            $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('mario@gmail.com', 'Este usuario le ha salido un error al intentar eliminar al cliente con el id $idCliente')");
            echo "Error al eliminar.";
        }
    }

    if(empty ($_REQUEST['id'])){
        header("location: lista_cliente.php");

    }else {
        # code...
        

        $idCliente = $_REQUEST['id'];

        $query = mysqli_query($conection, "SELECT clientes.nombre, clientes.apellido, tipodocumento.tipoDocumento, clientes.numeroDocumento, clientes.telefono, clientes.direccion, clientes.id_usuario FROM clientes INNER JOIN tipodocumento ON clientes.tipoDocumento = tipodocumento.idTipoDocumento WHERE clientes.idCliente = $idCliente");

        $result = mysqli_num_rows($query);

        if ($result > 0) {
            while ($data = mysqli_fetch_array($query)) {
                $nombreCliente = $data['nombre'];
                $apellidoCliente = $data['apellido'];
                $tipoDocumento = $data['tipoDocumento'];
                $numeroDocumento = $data['numeroDocumento'];
                $telefono = $data['telefono'];
                $direccion = $data['direccion'];
                $id_usuario = $data['id_usuario'];

            }
        } else {
            header("location: lista_cliente.php");
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar cliente</title>
    <?php include "includes/scripts.php"; ?>
</head>
<body>
    <?php include "includes/navbar.php"; 
    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario quiere eliminar un cliente')");
    ?>
    
    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_cliente.php">Lista de cliente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_cliente.php">Registrar cliente</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">Eliminar cliente</a>
            </li>
        </ul>

        <h1>Eliminar cliente</h1>

        <div>
            <p>¿Estas seguro que quieres eliminar este cliente?</p>
        </div>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id -->
                <input class="form-control" type="hidden" name="idCliente" id="idCliente" value="<?php echo $idCliente; ?>">
                <!-- final id -->

                <!-- Nombre -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre</label>
                    <input class="form-control" type="text" disabled name="nombre" id="nombre" value="<?php echo $nombreCliente; ?>">
                </div>
                <!-- Final nombre -->

                <!-- Apellido -->
                <div class="form-group col-md-6">
                    <label class="form-label">Apellido</label>
                    <input class="form-control" type="text" name="apellido" disabled id="apellido" value="<?php echo $apellidoCliente; ?>">
                </div>
                <!-- Final apellido -->
                
                <!-- Tipo documento -->
                <div class="form-group col-md-6">
                    <label class="form-label">Tipo de documento</label>
                    <input class="form-control" type="text" name="tipoDocumento" disabled id="tipoDocumento" value="<?php echo $tipoDocumento; ?>">
                </div>
                <!-- Final Tipo documento -->  

                <!-- Numero del documento -->
                <div class="form-group col-md-6">
                    <label class="form-label">Número del documento</label>
                    <input class="form-control" placeholder="Escribirlo sin punto y sin comas." disabled type="number" name="numeroDocumento" id="numeroDocumento" value="<?php echo $numeroDocumento; ?>">
                </div>
                <!-- Final numero del documento -->

                <!-- Numero telefonico -->
                <div class="form-group col-md-6">
                    <label class="form-label">Número telefonico</label>
                    <input class="form-control" type="text" name="telefono" id="telefono" disabled value="<?php echo $telefono; ?>">
                </div>
                <!-- Final numero telefonico -->

                <!-- Dirección -->
                <div class="form-group col-md-6">
                    <label class="form-label">Dirección</label>
                    <input class="form-control" type="text" name="direccion" id="direccion" disabled value="<?php echo $direccion; ?>">
                </div>
                <!-- Final Dirección -->

                <!-- ID del creador -->
                <input class="form-control" placeholder="ID del creador" type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario; ?>">
                <!-- Final ID del creador -->

                <!-- botones -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="lista_cliente.php" class="btn btn-primary">Cancelar</a>
                    <button type="submit" class="btn btn-danger">Aceptar</button>
                </div>
                <!-- Final botones -->
            </div>
        </form>

        
    </div>

    <?php include "includes/footer.php"; ?> 
    
</body>
</html>