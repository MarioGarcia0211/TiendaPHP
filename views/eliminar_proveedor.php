<?php 

    include "../conexion.php";

    if (!empty($_POST)) {

        $idProveedor = $_POST['idProveedor'];

        // $query_delete = mysqli_query($conection, "DELETE FROM usuarios WHERE idProveedor = $idProveedor");

        $query_delete = mysqli_query($conection, "UPDATE proveedores SET estado = 0 WHERE idProveedor = $idProveedor");

        if($query_delete){
            $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('mario@gmail.com', 'Este usuario ha eliminado al proveedor con el id $idProveedor')");
            header("location: lista_proveedor.php");

        }else {
            $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('mario@gmail.com', 'Este usuario le ha salido un error al intentar eliminar al proveedor con el id $idProveedor')");
            echo "Error al eliminar.";
        }
    }

    if(empty ($_REQUEST['id'])){
        header("location: lista_proveedor.php");

    }else {
        # code...
        

        $idProveedor = $_REQUEST['id'];

        $query = mysqli_query($conection, "SELECT proveedores.idProveedor, proveedores.nombreProveedor, proveedores.nombreContacto, proveedores.telefono, proveedores.direccion FROM proveedores WHERE proveedores.idProveedor = $idProveedor");

        $result = mysqli_num_rows($query);

        if ($result > 0) {
            while ($data = mysqli_fetch_array($query)) {
                $nombreProveedor = $data['nombreProveedor'];
                $nombreContacto = $data['nombreContacto'];
                $telefono = $data['telefono'];
                $direccion = $data['direccion'];

            }
        } else {
            header("location: lista_proveedor.php");
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar proveedor</title>
    <?php include "includes/scripts.php"; ?>
</head>
<body>
    <?php include "includes/navbar.php"; ?>
    
    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_proveedor.php">Lista de proveedores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_proveedor.php">Registrar proveedor</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">Eliminar proveedor</a>
            </li>
        </ul>

        <h1>Eliminar proveedor</h1>

        <div>
            <p>¿Estas seguro que quieres eliminar este proveedor?</p>
        </div>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id -->
                <input class="form-control" type="hidden" name="idProveedor" id="idProveedor" value="<?php echo $idProveedor; ?>">
                <!-- final id -->

                <!-- Nombre del proveedor -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del proveedor</label>
                    <input class="form-control" type="text" name="nombreProveedor" disabled id="nombreProveedor" value="<?php echo $nombreProveedor; ?>">
                </div>
                <!-- Final nombre del proveedor -->

                <!-- Nombre del contacto -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del contacto</label>
                    <input class="form-control" type="text" name="nombreContacto" disabled id="nombreContacto" value="<?php echo $nombreContacto; ?>">
                </div>
                <!-- Final Nombre del contacto -->


                <!-- Numero telefonico -->
                <div class="form-group col-md-6">
                    <label class="form-label">Número telefonico</label>
                    <input class="form-control" type="number" name="telefono" disabled id="telefono" value="<?php echo $telefono; ?>">
                </div>
                <!-- Final numero telefonico -->

                <!-- Dirección -->
                <div class="form-group col-md-6">
                    <label class="form-label">Dirección</label>
                    <input class="form-control" type="text" disabled name="direccion" id="direccion" value="<?php echo $direccion; ?>">
                </div>
                <!-- Final Dirección -->

                <!-- botones -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="lista_proveedor.php" class="btn btn-primary">Cancelar</a>
                    <button type="submit" class="btn btn-danger">Aceptar</button>
                </div>
                <!-- Final botones -->
            </div>
        </form>

        
    </div>

    <?php include "includes/footer.php"; ?> 
    
</body>
</html>