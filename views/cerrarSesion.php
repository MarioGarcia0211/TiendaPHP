<?php 
    include "../conexion.php";
    session_start();
    $email = $_SESSION['email'];
    $insert = mysqli_query($conection, "INSERT INTO log_login (email, descripcion) VALUES ('$email', 'Este usuario ha finalizado la sesión')");
    session_destroy();

    header('location: ../');
?>