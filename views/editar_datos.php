<?php
include "../conexion.php";
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['email'])) {

        $alert = '<div class="alert alert-danger" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i> Todos los campos son obligatorios.
                    </div>';
    } else {

        $idUsuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $clave = md5($_POST['clave']);

        $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE (email = '$email' AND idUsuario != '$idUsuario')");

        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> El email ya existe.
              </div>';
        } else {

            if (empty($_POST['clave'])) {

                $sql_update = mysqli_query($conection, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email' WHERE idUsuario = '$idUsuario'");
            } else {
                $sql_update = mysqli_query($conection, "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email', clave = '$clave' WHERE idUsuario = '$idUsuario'");
            }



            if ($sql_update) {
                $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario ha actualizado sus datos que son: nombre -> $nombre, apellido -> $apellido, email -> $email')");
                $alert = '<div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle-fill"></i> Usuario actualizado correctamente.
                  </div>';
            } else {
                $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario le ha salido un error al actualizar sus datos')");
                $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> Error al actualizar el usuario.
                  </div>';
            }
        }
    }
}



//Mostrar datos del usuario

if (empty($_GET['id'])) {
    header('Location: lista_usuario.php');
}

$iduser = $_GET['id'];

$sql = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idRol AS idRol, roles.rol AS rol FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol WHERE idUsuario = $iduser");

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('Location: lista_usuario.php');
} else {

    while ($data = mysqli_fetch_array($sql)) {

        $iduser = $data['idUsuario'];
        $name = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; 
    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario esta editando su perfil')");
    ?>

    <div class="contenedor">

        <h1>Editar mis datos</h1>

        <form class="registerUser" action="" method="post">
            <div>
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>

            <div class="row">

                <!-- Id -->
                <input class="form-control" type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $iduser; ?>">
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

                <!-- Email -->
                <div class="form-group col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $email; ?>">
                </div>
                <!-- Final email -->

                <!-- Contraseña -->
                <div class="form-group col-md-6">
                    <label class="form-label">Contraseña</label>
                    <input class="form-control" type="password" name="clave" id="clave" value="">
                </div>
                <!-- Final contraseña -->

                <!-- boton registar -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="perfil.php" class="btn btn-danger">Volver</a>
                    <button type="submit" class="btn btn-success">Aceptar cambios</button>
                </div>
                <!-- Final boton registrar -->
            </div>
        </form>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>