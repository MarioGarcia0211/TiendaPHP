<?php 

    include "../conexion.php";

    if (!empty($_POST)) {

        if($_POST['idUsuario'] == 1){
            header("location: lista_usuario.php");
            exit;
        }
        $idUsuario = $_POST['idUsuario'];

        // $query_delete = mysqli_query($conection, "DELETE FROM usuarios WHERE idUsuario = $idUsuario");

        $query_delete = mysqli_query($conection, "UPDATE usuarios SET estado = 0 WHERE idUsuario = $idUsuario");

        if($query_delete){
            $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('mario@gmail.com', 'Este usuario ha eliminado al usuario con el id $idUsuario')");
            header("location: lista_usuario.php");

        }else {
            $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('mario@gmail.com', 'Este usuario le ha salido un error al intentar eliminar al usuario con id $idUsuario')");
            echo "Error al eliminar.";
        }
    }

    if(empty ($_REQUEST['id']) || $_REQUEST['id'] == 1){
        header("location: lista_usuario.php");

    }else {
        # code...
        

        $idUsuario = $_REQUEST['id'];

        $query = mysqli_query($conection, "SELECT usuarios.nombre, usuarios.apellido, usuarios.email, roles.rol FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol WHERE usuarios.idUsuario = $idUsuario");

        $result = mysqli_num_rows($query);

        if ($result > 0) {
            while ($data = mysqli_fetch_array($query)) {
                $nombre = $data['nombre'];
                $apellido = $data['apellido'];
                $email = $data['email'];
                $rol = $data['rol'];
            }
        } else {
            header("location: lista_usuario.php");
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar usuario</title>
    <?php include "includes/scripts.php"; ?>
</head>
<body>
    <?php include "includes/navbar.php"; 
    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario quiere eliminar a otro usuario')");
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
                <a class="nav-link active">Eliminar usuario</a>
            </li>
        </ul>

        <h1>Eliminar Usuario</h1>

        <div>
            <p>¿Estas seguro que quieres eliminar este usuario?</p>
        </div>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id -->
                <input class="form-control" type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario; ?>">
                <!-- final id -->

                <!-- Nombre -->
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre</label>
                    <input class="form-control" type="text" disabled name="nombre" id="nombre" value="<?php echo $nombre; ?>">
                </div>
                <!-- Final nombre -->

                <!-- Apellido -->
                <div class="form-group col-md-6">
                    <label class="form-label">Apellido</label>
                    <input class="form-control" type="text" name="apellido" disabled id="apellido" value="<?php echo $apellido; ?>">
                </div>
                <!-- Final apellido -->  

                <!-- Email -->
                <div class="form-group col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" disabled id="email" value="<?php echo $email; ?>">
                </div>
                <!-- Final email -->               

                <!-- Rol -->
                <div class="form-group col-md-6">
                    <label class="form-label">Rol</label>
                    <input class="form-control" type="text" name="rol" disabled id="rol" value="<?php echo $rol; ?>">
                </div>
                <!-- Final rol -->

                <!-- botones -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="lista_usuario.php" class="btn btn-primary">Cancelar</a>
                    <button type="submit" class="btn btn-danger">Aceptar</button>
                </div>
                <!-- Final botones -->
            </div>
        </form>

        
    </div>

    <?php include "includes/footer.php"; ?> 
    
</body>
</html>