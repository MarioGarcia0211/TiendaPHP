<?php 
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'ventas';

    try {
        $con = new PDO("mysql:host={$host};dbname={$db}", $user, $password);
    }catch (PDOException $exception) {
        echo "Connection error: " . $exception->getMessage();
    }

    $conection2 = @mysqli_connect($host, $user, $password, $db);

    //mysqli_close($conection);

    if(!$conection2){
        echo "Error en la conexión a la bd";
    }else {
        
    }
?>