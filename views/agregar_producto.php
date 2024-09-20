<?php
include "../conexion.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    $idProducto = $_REQUEST['id'];
    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario quiere aumentar la cantidad del producto con el id $idProducto')");
    ?>

    <?php 
    if (!empty($_POST)) {
        $alert = "";
        if (empty($_POST['cantidad'])) {
    
            $alert = '<div class="alert alert-danger" role="alert">
                            Debe agregar la cantidad.
                        </div>';
            
        } if ($_POST['cantidad'] == 0 || $_POST['cantidad'] < 0) {
            $alert = '<div class="alert alert-danger" role="alert">
                            Debe agregar una cantidad que sea mayor a 0.
                        </div>';
        } 
        else {
            $cantidad = $_POST['cantidad'];
            $idProducto = $_REQUEST['id'];
    
    
            $query_inser = mysqli_query($conection, "INSERT INTO entradas(idProducto, cantidad) VALUES($idProducto, $cantidad)");
    
    
            if ($query_inser) {
                $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario ha agregado $cantidad a la cantidad del producto con el id $idProducto')");

                //Ejecutar procedimiento almacenado
                $query_upd = mysqli_query($conection, "CALL actualizar_cantidad_producto($cantidad, $idProducto)");
    
                $result = mysqli_num_rows($query_upd);
                if ($result) {
                    $alert = '<div class="alert alert-success" role="alert">
                    La cantidad del producto fue agregada correctamente.
                  </div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">
                    Error al agregar más productos.
                  </div>';
                }
            }
        }
    }
    ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_producto.php">Lista de productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_producto.php">Registrar producto</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">Agregar producto</a>
            </li>

        </ul>
        <h1>Agregar producto</h1>
        <form action="" method="post">

            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="form-group">
                <input class="form-control" name="idProducto" id="idProducto" type="hidden" value="<?php echo $_REQUEST['id'] ?>">
            </div>

            <div class="form-group col-md-4">
                <label class="form-label">Cantidad</label>
                <input class="form-control" type="number" name="cantidad" id="txtCantidad">
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="lista_producto.php" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
        </form>
    </div>

</body>

</html>