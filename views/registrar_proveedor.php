<?php
include "../conexion.php";
$rand = rand(1000, 9999);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar proveedor</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; 
    $emailUsuario = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario esta registrando un proveedor')");
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
    
                
            $nombreProveedor = $_POST['nombreProveedor'];
            $nombreContacto = $_POST['nombreContacto'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
    
            $result = 0;
    
    
            $query = mysqli_query($conection, "SELECT * FROM proveedores WHERE nombreProveedor = '$nombreProveedor'");
    
            $result = mysqli_fetch_array($query);   
            
    
            if ($result > 0) {
                $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario no ha podido registrar al proveedor porque habia colocado el nombre de un proveedor ya registrado: nombre del proveedor -> $nombreProveedor')");

                $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> El proveedor ya existe.
              </div>';
            } else {
                
                $insert = mysqli_query($conection, "INSERT INTO proveedores (nombreProveedor, nombreContacto, telefono, direccion) VALUES ('$nombreProveedor', '$nombreContacto', '$telefono', '$direccion')");
    
                if ($insert) {
                    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario ha registrado al proveedor con los siguientes datos: nombreProveedor -> $nombreProveedor, nombreContacto -> $nombreContacto, telefono -> $telefono, direccion -> $direccion')");

                    $alert = '<div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill"></i> Proveedor registrado correctamente.
                  </div>';

                } else {
                    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$emailUsuario', 'Este usuario le ha salido un error registrar al proveedor')");

                    $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> Error al registrar el proveedor.
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
                <a class="nav-link " aria-current="page" href="lista_proveedor.php">Lista de proveedores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="registrar_proveedor.php">Registrar proveedor</a>
            </li>
        </ul>
        <h1>Registrar proveedor</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">
                <!-- Nombre del proveedor -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del proveedor</label>
                    <input class="form-control" type="text" name="nombreProveedor" id="nombreProveedor">
                </div>
                <!-- Final nombre del proveedor -->

                <!-- Nombre del contacto -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del contacto</label>
                    <input class="form-control" type="text" name="nombreContacto" id="nombreContacto">
                </div>
                <!-- Final Nombre del contacto -->


                <!-- Numero telefonico -->
                <div class="form-group col-md-6">
                    <label class="form-label">Número telefonico</label>
                    <input class="form-control" type="number" name="telefono" id="telefono">
                </div>
                <!-- Final numero telefonico -->

                <!-- Dirección -->
                <div class="form-group col-md-6">
                    <label class="form-label">Dirección</label>
                    <input class="form-control" type="text" name="direccion" id="direccion">
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
                    <button type="submit" class="btn btn-primary">Crear Proveedor</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>

</body>

</html>