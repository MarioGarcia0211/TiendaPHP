<?php
include "../conexion.php";
if (!empty($_POST)) {
    
    $idProducto = $_POST['idProducto'];

        // $query_delete = mysqli_query($conection, "DELETE FROM usuarios WHERE idProveedor = $idProveedor");

        $query_delete = mysqli_query($conection, "UPDATE productos SET estado = 0 WHERE idProducto = $idProducto");

        if($query_delete){
            header("location: lista_producto.php");

        }else {
            echo "Error al eliminar.";
        }

}

//VALIDAR PRODUCTO
if(empty($_REQUEST['id'])){
    header("location: lista_producto.php");

}else {
    # code...
    $idProducto = $_REQUEST['id'];
    if(!is_numeric($idProducto)){
        header("location: lista_producto.php");
    }

    $query_producto = mysqli_query($conection, "SELECT productos.idProducto, productos.descripcion, productos.idProveedor, proveedores.nombreProveedor, productos.existencia, productos.precio, productos.foto FROM productos INNER JOIN proveedores ON productos.idProveedor = proveedores.idProveedor WHERE productos.idProducto = $idProducto AND productos.estado = 1");
    $result_product = mysqli_num_rows($query_producto);

    $foto = '';

    if($result_product > 0){
        $data_producto = mysqli_fetch_assoc($query_producto);

        if($data_producto['foto'] != 'img_producto.png'){
            $foto = '<img class="form-control" id="imagenPrevisualizacion" src="images/uploads/'.$data_producto['foto'].'">';
        }

    }else {
        header("location: lista_producto.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar producto</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; ?>

    <div class="contenedor">
    <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="lista_producto.php">Lista de productos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registrar_producto.php">Registrar producto</a>
            </li>

            <li class="nav-item">
                <a class="nav-link active">Eliminar producto</a>
            </li>

        </ul>
        <h1>Eliminar producto</h1>

        <form class="registerUser"  action="" method="post" enctype="multipart/form-data">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <input type="hidden" name="idProducto" value="<?php echo $data_producto['idProducto'] ?>">
                <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $data_producto['foto'] ?>">
                <input type="hidden" name="foto_remo" id="foto_remo" value="<?php echo $data_producto['foto'] ?>">

                <!-- Descripcion del producto -->
                <div class="form-group col-md-6">
                    <label class="form-label">Descripción del producto</label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion" value="<?php echo $data_producto['descripcion']; ?>">
                </div>
                <!-- Final Descripcion del producto -->

                <!-- Proveedores -->
                <?php

                    include "../conexion.php";
                    $query_rol = mysqli_query($conection, "SELECT * FROM proveedores");
                    $result_rol = mysqli_num_rows($query_rol);
                ?>

                <div class="form-group col-md-6">
                    <label class="form-label">Proveedores</label>
                    <select class="form-select notItemOne" name="idProveedor" id="idProveedor">
                        <option value="<?php echo $data_producto['idProveedor']; ?>"><?php echo $data_producto['nombreProveedor']; ?></option>
                        <?php 
                            if($result_rol > 0){
                                while ($rol = mysqli_fetch_array($query_rol)) {
                        ?>
                                <option value="<?php echo $rol["idProveedor"]; ?>"><?php echo $rol["nombreProveedor"] ?></option>

                        <?php 
                                }
                            }
                        ?>
                            
                        
                    </select>
                </div>
                <!-- Final proveedores -->

                <!-- Existencia -->
                <div class="form-group col-md-6">
                    <label class="form-label">Cantidad</label>
                    <input class="form-control" type="number" name="existencia" id="existencia" disabled value="<?php echo $data_producto['existencia']; ?>">
                </div>
                <!-- Final Existencia -->

                <!-- Precio -->
                <div class="form-group col-md-6">
                    <label class="form-label">Precio</label>
                    <input class="form-control" type="number" name="precio" id="precio" value="<?php echo $data_producto['precio']; ?>">
                </div>
                <!-- Final Precio -->

                <!-- Foto -->
                <div class="form-group col-md-6">
                    <label class="form-label">Imagen</label>
                    <input class="form-control" type="file" name="foto" id="foto">
                </div>
                <!-- Final Foto -->

                <!-- Ver -->
                <div class="form-group col-md-2">
                    <label class="form-label">Ver imagen</label>
                    <?php echo $foto; ?>
                </div>
                <!-- Fin ver -->

                <!-- boton registar -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="lista_producto.php" class="btn btn-primary">Cancelar</a>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </div>
            <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <script src="js/funtion.js"></script>

</body>

</html>