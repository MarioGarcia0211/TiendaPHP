<?php
$alert = '';

$rand = rand(1000, 9999);

session_start();
if (!empty($_SESSION['active'])) {
    header('location: views/');
} else {
    if (!empty($_POST)) {

        if (empty($_POST['email']) || empty($_POST['clave']) || empty($_POST['captcha'])) {
            $alert = '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-circle-fill"></i> Todos los datos son obligatorios.
              </div>';
        } else {
            if ($_POST['captcha'] != $_POST['codigo']) {
                $alert = '<div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-circle-fill"></i> El captcha no coincide con el código.
              </div>';
            } else {

                require_once "conexion.php";

                $email = mysqli_real_escape_string($conection, $_POST['email']);
                $clave = md5(mysqli_real_escape_string($conection, $_POST['clave']));

                $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE email = '$email' AND clave = '$clave'");

                $result = mysqli_num_rows($query);

                if ($result > 0) {
                    $insert = mysqli_query($conection, "INSERT INTO log_login (email, descripcion) VALUES ('$email', 'Este usuario pudo acceder al sistema')");
                    $data = mysqli_fetch_array($query);
                    $_SESSION['active'] = true;
                    $_SESSION['idUsuario'] = $data['idUsuario'];
                    $_SESSION['nombre'] = $data['nombre'];
                    $_SESSION['apellido'] = $data['apellido'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['clave'] = $data['clave'];
                    $_SESSION['rol'] = $data['idRol'];
                    $_SESSION['estado'] = $data['estado'];

                    header('location: views/');
                } else {
                    $insert = mysqli_query($conection, "INSERT INTO log_login (email, descripcion) VALUES ('$email', 'Este usuario no pudo acceder porque el email o la contraseña eran incorrectas')");

                    $alert = '<div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i> El email o la contraseña son incorrectas.
                  </div>';
                    session_destroy();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>

    <div class="contenedor">
        <div class="login">
            <h1 class="tituloLogin">Iniciar Sesión</h1>

            <!-- Alerta -->
            <div class="alerta">
                <?php
                echo isset($alert) ? $alert : '';
                ?>
            </div>
            <!-- Final alerta -->
            <form action="" method="post">

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email">
                </div>
                <!-- Final email -->

                <!-- Contraseña -->
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input class="form-control" type="password" name="clave">
                </div>
                <!-- Final contraseña -->

                <!-- Captcha -->
                <div class="row g-3">
                    <div class="form-group col-md-6">
                        <label class="form-label">Captcha</label>
                        <input type="text" class="form-control" name="captcha" id="captcha">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Código del captcha</label>
                        <input type="text" class="form-control text-center" name="codigo" id="codigo" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(0,212,255,1) 100%); color:white;" value="<?php echo $rand; ?>" readonly>
                    </div>
                </div>
                <!-- Final captcha -->

                <!-- Boton -->
                <input type="submit" class="btn btn-primary w-100" value="Ingresar">
                <!-- Final boton -->

            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</body>

</html>