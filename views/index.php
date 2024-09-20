<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <?php include "includes/scripts.php"; ?>
</head>

<body>
    <?php include "includes/navbar.php"; 
        include "../conexion.php";
        $email = $_SESSION['email'];
        $insert = mysqli_query($conection, "INSERT INTO log_navegacion (email, descripcion) VALUES ('$email', 'Este usuario esta navegando en el inicio')");
    ?>

    

    <div class="contenedor">
        <h1>Bienvenido <?php echo$_SESSION['nombre'] ?></h1>
    </div>
    
    <?php include "includes/footer.php"; ?> 
</body>
</html>