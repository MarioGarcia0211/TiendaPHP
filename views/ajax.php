<?php
session_start();
include "../conexion.php";
include "../conexion2.php";
//print_r($_POST); exit;
if (!empty($_POST)) {

    //Buscar cliente
    if ($_POST['action'] == 'searchCliente') {

        if (!empty($_POST['cliente'])) {
            # code...
            $nit = $_POST['cliente'];

            $query = mysqli_query($conection, "SELECT * FROM clientes WHERE numeroDocumento LIKE '$nit' AND estado = 1");

            $result = mysqli_num_rows($query);

            $data = '';

            if ($result > 0) {
                $data = mysqli_fetch_assoc($query);
            } else {
                # code...
                $data = 0;
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    //Buscar producto
    if ($_POST['action'] == 'infoProducto') {

        $idProducto = $_POST['producto'];

        $query = mysqli_query($conection, "SELECT * FROM productos WHERE idProducto = $idProducto AND estado = 1");

        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);

            exit;
        } else {
            # code...
            echo 'error';
            exit;
        }
    }

    //Agregar producto al detalle temporal
    if ($_POST['action'] == 'addProductoDetalle') {

        if (empty($_POST['producto']) || empty($_POST['cantidadProducto'])) {
            # code...
            echo "error";
        } else {

            $idProducto = $_POST['producto'];
            $cantidadProducto = $_POST['cantidadProducto'];
            $token = $_SESSION['idUsuario'];
            $nit = $_POST['cliente'];

            $query_descuento = mysqli_query($conection2, "SELECT numeroDescuento AS descuento FROM descuentos WHERE numeroDocumento LIKE '$nit'");

            $result_descuento = mysqli_num_rows($query_descuento);

            $query_temporal = mysqli_query($conection, "CALL add_detalle_temp($idProducto, $cantidadProducto, $token)");
            $result = mysqli_num_rows($query_temporal);

            $detalleTabla = '';
            $sub_total = 0;
            $descuento = 0;
            $total = 0;
            $arrayData = array();

            if ($result > 0) {

                if ($result_descuento > 0) {
                    $info_descuento = mysqli_fetch_assoc($query_descuento);
                    $descuento = $info_descuento['descuento'];
                }

                while ($data = mysqli_fetch_assoc($query_temporal)) {
                    $precioTotal = $data['cantidad'] * $data['precio_venta'];
                    $sub_total = $sub_total + $precioTotal;
                    $total = $total + $precioTotal;

                    $detalleTabla .= '
                            <tr>
                                <td>' . $data['idProducto'] . '</td>
                                <td colspan="2">' . $data['descripcion'] . '</td>
                                <td>' . $data['cantidad'] . '</td>
                                <td>' . $data['precio_venta'] . '</td>
                                <td>' . $precioTotal . '</td>
                                <td><a href="#" onclick="event.preventDefault(); del_product_detalle(' . $data['idTemporal'] . ');" class="text-danger">Eliminar</a></td>
                            </tr>
                        ';
                }


                $descontar = $sub_total * ($descuento / 100);

                $total = $sub_total - $descontar;

                $detalleTotales = '
                        <tr>
                            <td colspan="5">Subtotal</td>
                            <td>' . $sub_total . '</td>
                        </tr>
                        <tr>
                            <td colspan="5">Descuento</td>
                            <td>' . $descuento .'%</td>
                        </tr>
                        <tr>
                            <td colspan="5">Total</td>
                            <td>' . $total . '</td>
                        </tr>
                    ';

                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;

                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conection);
        }
        exit;
    }

    //Extraer datos del detalle temporal
    if ($_POST['action'] == 'searchForDetalle') {

        if (!empty($_POST['user'])) {
            # code...
            echo "error";
        } else {

            $token = $_SESSION['idUsuario'];
            $nit = $_POST['cliente'];

            $query = mysqli_query($conection, "SELECT temporal.idTemporal, temporal.token_user, temporal.cantidad, temporal.precio_venta, productos.idProducto, productos.descripcion FROM temporal INNER JOIN productos ON temporal.idProducto = productos.idProducto WHERE token_user = '$token'");

            $result = mysqli_num_rows($query);

            $query_descuento = mysqli_query($conection2, "SELECT numeroDescuento AS descuento FROM descuentos WHERE numeroDocumento LIKE '$nit'");

            $result_descuento = mysqli_num_rows($query_descuento);



            $detalleTabla = '';
            $sub_total = 0;
            $descuento = 0;
            $total = 0;
            $arrayData = array();

            if ($result > 0) {

                if ($result_descuento > 0) {
                    $info_descuento = mysqli_fetch_assoc($query_descuento);
                    $descuento = $info_descuento['descuento'];
                }

                while ($data = mysqli_fetch_assoc($query)) {
                    $precioTotal = $data['cantidad'] * $data['precio_venta'];
                    $sub_total = $sub_total + $precioTotal;
                    $total = $total + $precioTotal;

                    $detalleTabla .= '
                            <tr>
                                <td>' . $data['idProducto'] . '</td>
                                <td colspan="2">' . $data['descripcion'] . '</td>
                                <td>' . $data['cantidad'] . '</td>
                                <td>' . $data['precio_venta'] . '</td>
                                <td>' . $precioTotal . '</td>
                                <td><a href="#" onclick="event.preventDefault(); del_product_detalle(' . $data['idTemporal'] . ');" class="text-danger">Eliminar</a></td>
                            </tr>
                        ';
                }

                $descontar = $sub_total * ($descuento / 100);

                $total = $sub_total - $descontar;

                $detalleTotales = '
                        <tr>
                            <td colspan="5">Subtotal</td>
                            <td>' . $sub_total . '</td>
                        </tr>
                        <tr>
                            <td colspan="5">Descuento</td>
                            <td>' . $descuento .'%</td>
                        </tr>
                        <tr>
                            <td colspan="5">Total</td>
                            <td>' . $total . '</td>
                        </tr>
                    ';

                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;

                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conection);
        }
        exit;
    }

    //Eliminar producto del detalle temporal
    if ($_POST['action'] == 'delProductoDetalle') {

        if (empty($_POST['id_detalle'])) {
            # code...
            echo "error";
        } else {

            $id_detalle = $_POST['id_detalle'];
            $token = $_SESSION['idUsuario'];
            $nit = $_POST['cliente'];

            $query_descuento = mysqli_query($conection2, "SELECT numeroDescuento AS descuento FROM descuentos WHERE numeroDocumento LIKE '$nit'");

            $result_descuento = mysqli_num_rows($query_descuento);

            $query_detalle_temp = mysqli_query($conection, "CALL del_detalle_temp($id_detalle, '$token')");


            $result = mysqli_num_rows($query_detalle_temp);

            $detalleTabla = '';
            $sub_total = 0;
            $descuento = 0;
            $total = 0;
            $arrayData = array();

            if ($result > 0) {

                if ($result_descuento > 0) {
                    $info_descuento = mysqli_fetch_assoc($query_descuento);
                    $descuento = $info_descuento['descuento'];
                }

                while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
                    $precioTotal = $data['cantidad'] * $data['precio_venta'];
                    $sub_total = $sub_total + $precioTotal;
                    $total = $total + $precioTotal;

                    $detalleTabla .= '
                            <tr>
                                <td>' . $data['idProducto'] . '</td>
                                <td colspan="2">' . $data['descripcion'] . '</td>
                                <td>' . $data['cantidad'] . '</td>
                                <td>' . $data['precio_venta'] . '</td>
                                <td>' . $precioTotal . '</td>
                                <td><a href="#" onclick="event.preventDefault(); del_product_detalle(' . $data['idTemporal'] . ');" class="text-danger">Eliminar</a></td>
                            </tr>
                        ';
                }

                $descontar = $sub_total * ($descuento / 100);

                $total = $sub_total - $descontar;

                $detalleTotales = '
                        <tr>
                            <td colspan="5">Subtotal</td>
                            <td>' . $sub_total . '</td>
                        </tr>
                        <tr>
                            <td colspan="5">Descuento</td>
                            <td>' . $descuento .'%</td>
                        </tr>
                        <tr>
                            <td colspan="5">Total</td>
                            <td>' . $total . '</td>
                        </tr>
                    ';

                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;

                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conection);
        }
        exit;
    }

    //Anular venta
    if ($_POST['action'] == 'anularVenta') {

        $token = $_SESSION['idUsuario'];

        $query_del = mysqli_query($conection, "DELETE FROM temporal WHERE token_user = '$token'");
        mysqli_close($conection);
        if ($query_del) {
            echo 'Ok';
        } else {
            echo 'Error';
        }
        exit;
    }

    //Generar venta
    if ($_POST['action'] == 'procesarVenta') {

        if (empty($_POST['codCliente'])) {
            echo "error falta el cliente";
        } else {
            $codCliente = $_POST['codCliente'];
        }

        $token = $_SESSION['idUsuario'];
        $idUsuario = $_SESSION['idUsuario'];

        $query = mysqli_query($conection, "SELECT * FROM temporal WHERE token_user = '$token'");
        $result = mysqli_num_rows($query);

        if ($result > 0) {

            $query_procesar = mysqli_query($conection, "CALL procesar_venta($idUsuario, $codCliente, '$token')");
            $result_detalle = mysqli_num_rows($query_procesar);

            if ($result_detalle > 0) {
                $data = mysqli_fetch_assoc($query_procesar);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
        mysqli_close($conection);
        exit;
    }

    //Grafica de fechas con mayor ganancia
    if ($_POST['action'] == 'fechaMayor') {
        $es = mysqli_query($conection, "SET lc_time_names = 'es_CO';");
        $query = mysqli_query($conection, "SELECT DATE_FORMAT(fecha, '%d/%M/%Y') AS fechas, DAY(fecha) AS dia, MONTH(fecha) AS mes, SUM(totalFactura) AS total_mes FROM `facturas` GROUP BY fechas ORDER BY `total_mes` DESC LIMIT 5");
        $result = mysqli_num_rows($query);
        $arrayData = array();

        if ($result > 0) {

            while ($data = mysqli_fetch_array($query)) {
                $arrayData[] = $data;
            }

            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }

    //Graficas de fechas con menor ganancia
    if ($_POST['action'] == 'fechaMenor') {
        $es = mysqli_query($conection, "SET lc_time_names = 'es_CO';");
        $query = mysqli_query($conection, "SELECT DATE_FORMAT(fecha, '%d/%M/%Y') AS fechas, DAY(fecha) AS dia, MONTH(fecha) AS mes, SUM(totalFactura) AS total_mes FROM `facturas` GROUP BY fechas ORDER BY `total_mes` ASC LIMIT 5");
        $result = mysqli_num_rows($query);
        $arrayData = array();

        if ($result > 0) {

            while ($data = mysqli_fetch_array($query)) {
                $arrayData[] = $data;
            }

            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }

    //Grafica del total de ventas realizadas por los usuarios
    if ($_POST['action'] == 'usuarios') {
        $query = mysqli_query($conection, "SELECT facturas.idUsuario, usuarios.nombre AS nombreVendedor, usuarios.apellido AS apellidoVendedor, COUNT(*) AS totalVentas FROM `facturas` INNER JOIN usuarios ON facturas.idUsuario = usuarios.idUsuario GROUP BY idUsuario");
        $result = mysqli_num_rows($query);
        $arrayData = array();

        if ($result > 0) {

            while ($data = mysqli_fetch_array($query)) {
                $arrayData[] = $data;
            }

            echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        }
    }

    //Usuarios menor ventas
    
}
exit;
