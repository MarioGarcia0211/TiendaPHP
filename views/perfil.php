<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; ?>

    <?php
include "../conexion.php";
include "../conexion.php";
        $email = $_SESSION['email'];
        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario esta navegando en el perfil')");
$idUsuario = $_SESSION['idUsuario'];
$nombre = '';
$apellido = '';
$email = '';
$contraseña = '';
$rol = '';

$query = mysqli_query($conection, "SELECT usuarios.idUsuario, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.idRol, roles.rol FROM usuarios INNER JOIN roles ON usuarios.idRol = roles.idRol WHERE idUsuario = $idUsuario");

$result = mysqli_num_rows($query);

if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $email = $data['email'];
        $rol = $data['rol'];
    }
}
?>

    <div class="contenedor">
        <nav class="navbar">
            <div class="container-fuild">
                <h1>Mi perfil</h1>
            </div>

            <a type="button" href="editar_datos.php?id=<?php echo $_SESSION['idUsuario']; ?>" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Editar</a>
        </nav>
        

        <div class="row g-3">
            <div class="form-group col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" value="<?php echo $nombre; ?>" readonly>
            </div>

            <div class="form-group col-md-6">
                <label class="form-label">Apellido</label>
                <input type="text" class="form-control" value="<?php echo $apellido; ?>" readonly>
            </div>

            <div class="form-group col-md-6">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="<?php echo $email; ?>" readonly>
            </div>

            <div class="form-group col-md-6">
                <label class="form-label">Rol</label>
                <input type="text" class="form-control" value="<?php echo $rol; ?>" readonly>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>