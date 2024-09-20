<?php
session_start();
include "../conexion.php";
//print_r($_POST); exit;
if (!empty($_POST)) {

    //Grafica de fechas con mayor ganancia
    if ($_POST['action'] == 'fechas') {
        
        $query = mysqli_query($conection, "SELECT MONTH(fecha) AS mes, SUM(totalFactura) AS total_mes FROM `facturas` WHERE YEAR(fecha) = '2023' GROUP BY MONTH(fecha);");
        $result = mysqli_num_rows($query);
        $arrayData = array();

        if ($result > 0) {

            while ($data = mysqli_fetch_array($query)) {
                $arrayData[] = $data;
            }

            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }

    if ($_POST['action'] == 'facturas') {
        
        $query = mysqli_query($conection, "SELECT MONTH(fecha) AS mes, COUNT(*) AS total_mes FROM `facturas` WHERE YEAR(fecha) = '2023' GROUP BY MONTH(fecha);");
        $result = mysqli_num_rows($query);
        $arrayData = array();

        if ($result > 0) {

            while ($data = mysqli_fetch_array($query)) {
                $arrayData[] = $data;
            }

            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }

    if ($_POST['action'] == 'usuario') {
        
        $query = mysqli_query($conection, "SELECT facturas.idUsuario, usuarios.nombre AS nombreVendedor, usuarios.apellido AS apellidoVendedor, COUNT(*) AS totalVentas FROM `facturas` INNER JOIN usuarios ON facturas.idUsuario = usuarios.idUsuario GROUP BY idUsuario;");
        $result = mysqli_num_rows($query);
        $arrayData = array();

        if ($result > 0) {

            while ($data = mysqli_fetch_array($query)) {
                $arrayData[] = $data;
            }

            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }

    if ($_POST['action'] == 'productos') {
        
        $query = mysqli_query($conection, "SELECT productos.descripcion, productos.existencia FROM `productos` LIMIT 0, 4;");
        $result = mysqli_num_rows($query);
        $arrayData = array();

        if ($result > 0) {

            while ($data = mysqli_fetch_array($query)) {
                $arrayData[] = $data;
            }

            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }
    
}
exit;
