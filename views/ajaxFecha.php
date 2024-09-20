<?php 
function mayorGananciasPorFecha($desde)
{
    include "../conexion.php";
    $es = mysqli_query($conection, "SET lc_time_names = 'es_CO';");
    $query = mysqli_query($conection, "SELECT DATE_FORMAT(fecha, '%d/%M/%Y') AS fecha, ganancia FROM fecha_mayor_ganancia_$desde ORDER BY `fecha_mayor_ganancia_$desde`.`fecha` ASC");
    $result = mysqli_num_rows($query);
    $arrayData = array();

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {

            $arrayData[] = $data;
        }

        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
    }
    mysqli_close($conection);
}

function menorGananciasPorFecha($desde)
{
    include "../conexion.php";
    $es = mysqli_query($conection, "SET lc_time_names = 'es_CO';");
    $query = mysqli_query($conection, "SELECT DATE_FORMAT(fecha, '%d/%M/%Y') AS fecha, ganancia FROM fecha_menor_ganancia_$desde ORDER BY `fecha_menor_ganancia_$desde`.`fecha` ASC");
    $result = mysqli_num_rows($query);
    $arrayData = array();

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {

            $arrayData[] = $data;
        }

        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
    }
    mysqli_close($conection);
}

function ventasUsuarioAño($desde)
{
    include "../conexion.php";
    $query = mysqli_query($conection, "SELECT * FROM usuario_venta_$desde");
    $result = mysqli_num_rows($query);
    $arrayData = array();

    if ($result > 0) {
        while ($data = mysqli_fetch_array($query)) {

            $arrayData[] = $data;
        }

        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
    }
    mysqli_close($conection);
}
?>