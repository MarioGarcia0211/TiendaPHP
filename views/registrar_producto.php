<?php
$rand = rand(1000, 9999);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar producto</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php";
    include "../conexion.php";
    $emailUsuario = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario esta agregando un producto')");
    ?>

    <?php
    if (!empty($_POST)) {
        $alert = "";


        if (empty($_POST['descripcion']) || empty($_POST['idProveedor']) || empty($_POST['existencia']) || empty(['precio']) || empty(['foto']) || empty($_POST['captcha'])) {

            $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
              </div>';
        } else {

            if ($_POST['captcha'] != $_POST['codigo']) {
                $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el codigo.
                  </div>';
            } else {

                $descripcion = $_POST['descripcion'];
                $idProveedor = $_POST['idProveedor'];
                $existencia = $_POST['existencia'];
                $precio = $_POST['precio'];

                $foto = $_FILES['foto'];
                $nombreFoto = $foto['name'];
                $type = $foto['type'];
                $url_temp = $foto['tmp_name'];
                $size = $foto['size'];

                $imgProducto = 'image_producto.png';

                if ($nombreFoto != '') {
                    $destino = 'images/uploads/';
                    $img_nombre = 'img_' . md5(date('d-m-Y H:m:s'));
                    $imgProducto = $img_nombre . '.png';
                    $src = $destino . $imgProducto;
                }


                $query = mysqli_query($conection, "SELECT * FROM productos WHERE descripcion = '$descripcion'");

                $result = mysqli_fetch_array($query);

                if ($result > 0) {
                    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario no ha podido registrar un producto porque habia colocado la descripcion de un producto ya registrado: descripcion -> $descripcion')");

                    $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El producto ya existe.
                  </div>';
                } else {
                    $query_insert = mysqli_query($conection, "INSERT INTO productos(descripcion, idProveedor, existencia, precio, foto) VALUES('$descripcion', '$idProveedor', '$existencia', '$precio', '$imgProducto')");

                    if ($query_insert) {

                        if ($nombreFoto != '') {
                            move_uploaded_file($url_temp, $src);
                        }

                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario ha registrado un producto con los siguientes datos: descripcion -> $descripcion, idProveedor -> $idProveedor, existencia -> $existencia, precio -> $precio, foto -> $imgProducto')");

                        $alert = '<div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle-fill"></i> Producto registrado correctamente.
                      </div>';
                    } else {

                        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario le ha salido un error al intentar registrar un producto')");

                        $alert = '<div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i> Error al crear el producto.
                      </div>';
                    }
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
                <a class="nav-link active" href="registrar_producto.php">Registrar producto</a>
            </li>
        </ul>
        <h1>Registrar producto</h1>

        <form class="registerUser" action="" method="post" enctype="multipart/form-data">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">
                <!-- Descripcion del producto -->
                <div class="form-group col-md-6">
                    <label class="form-label">Descripción del producto</label>
                    <input class="form-control" type="text" name="descripcion" id="descripcion">
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
                    <select class="form-select" name="idProveedor" id="idProveedor">
                        <option selected disabled>Elige el proveedor</option>
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
                    <input class="form-control" type="number" name="existencia" id="existencia">
                </div>
                <!-- Final Existencia -->

                <!-- Precio -->
                <div class="form-group col-md-6">
                    <label class="form-label">Precio</label>
                    <input class="form-control" type="number" name="precio" id="precio">
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
                    <img class="form-control" id="imagenPrevisualizacion">
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
                    <button type="submit" class="btn btn-primary">Crear producto</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <script src="js/funtion.js"></script>

</body>

</html>