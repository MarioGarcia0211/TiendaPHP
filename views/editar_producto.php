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
    <title>Editar producto</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    $idProducto = $_REQUEST['id'];
    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario esta editando el producto con el id $idProducto')");
    ?>

    <?php
    if (!empty($_POST)) {
        $alert = "";

        if (empty($_POST['descripcion']) || empty($_POST['idProveedor']) || empty(['precio']) || empty(['foto']) || empty(['idProducto']) || empty($_POST['captcha'])) {

            $alert = '<div class="alert alert-danger" role="alert">
                Todos los campos son obligatorios.
              </div>';
        } else {

            if ($_POST['captcha'] != $_POST['codigo']) {
                $alert = '<div class="alert alert-danger" role="alert">
                    El captcha no coincide con el codigo.
                  </div>';
            } else {

                $idProducto = $_POST['idProducto'];
                $descripcion = $_POST['descripcion'];
                $idProveedor = $_POST['idProveedor'];
                $precio = $_POST['precio'];
                $img_actual = $_POST['foto_actual'];

                $foto = $_FILES['foto'];
                $nombreFoto = $foto['name'];
                $type = $foto['type'];
                $url_temp = $foto['tmp_name'];
                $size = $foto['size'];

                $upd = 'image_producto.png';

                if ($nombreFoto != '') {
                    $destino = 'images/uploads/';
                    $img_nombre = 'img_' . md5(date('d-m-Y H:m:s'));
                    $imgProducto = $img_nombre . '.png';
                    $src = $destino . $imgProducto;
                } else {
                    $img_nombre = $img_actual;
                    $imgProducto = $img_actual;
                }


                $query = mysqli_query($conection, "SELECT * FROM productos WHERE descripcion = '$descripcion' AND idProveedor != '$idProveedor'");

                $result = mysqli_fetch_array($query);

                if ($result > 0) {
                    $alert = '<div class="alert alert-danger" role="alert">
                    El producto ya existe.
                  </div>';
                } else {
                    $query_insert = mysqli_query($conection, "UPDATE productos SET descripcion = '$descripcion', idProveedor = $idProveedor, precio = $precio, foto = '$imgProducto' WHERE idProducto = $idProducto");

                    if ($query_insert) {

                        if ($nombreFoto != '') {
                            move_uploaded_file($url_temp, $src);
                        }

                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario ha editando el producto con el id $idProducto' con los siguientes datos: descripcion -> $descripcion, idProveedor -> $idProveedor, precio -> $precio, foto -> $imgProducto')");
                        $alert = '<div class="alert alert-success" role="alert">
                        Producto actualizado correctamente.
                      </div>';
                    } else {
                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario le salio un error al editar el producto con el id $idProducto')");
                        $alert = '<div class="alert alert-danger" role="alert">
                        Error al actualizar el producto.
                      </div>';
                    }
                }
            }
        }
    }

    //VALIDAR PRODUCTO
    if (empty($_REQUEST['id'])) {
        header("location: lista_producto.php");
    } else {
        # code...
        $idProducto = $_REQUEST['id'];
        if (!is_numeric($idProducto)) {
            header("location: lista_producto.php");
        }

        $query_producto = mysqli_query($conection, "SELECT productos.idProducto, productos.descripcion, productos.idProveedor, proveedores.nombreProveedor, productos.existencia, productos.precio, productos.foto FROM productos INNER JOIN proveedores ON productos.idProveedor = proveedores.idProveedor WHERE productos.idProducto = $idProducto AND productos.estado = 1");
        $result_product = mysqli_num_rows($query_producto);

        $foto = '';

        if ($result_product > 0) {
            $data_producto = mysqli_fetch_assoc($query_producto);

            if ($data_producto['foto'] != 'img_producto.png') {
                $foto = '<img class="form-control" id="imagenPrevisualizacion" src="images/uploads/' . $data_producto['foto'] . '">';
            }
        } else {
            header("location: lista_producto.php");
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
                <a class="nav-link active">Editar producto</a>
            </li>

        </ul>
        <h1>Editar producto</h1>

        <form class="registerUser" action="" method="post" enctype="multipart/form-data">
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
                        if ($result_rol > 0) {
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
                    <button type="submit" class="btn btn-primary">Editar producto</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <script src="js/funtion.js"></script>

</body>

</html>