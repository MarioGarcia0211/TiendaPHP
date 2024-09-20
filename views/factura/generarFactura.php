<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}

	include "../../conexion.php";
	include "../../conexion2.php";
	require_once '../pdf/dompdf/autoload.inc.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conection,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}


		$query = mysqli_query($conection,"SELECT facturas.idFactura, DATE_FORMAT(facturas.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(facturas.fecha,'%H:%i:%s') as  hora, facturas.idCliente, facturas.estado,
												 usuarios.nombre as vendedor,
												 clientes.numeroDocumento, clientes.nombre, clientes.telefono, clientes.direccion
											FROM facturas
											INNER JOIN usuarios
											ON facturas.idUsuario = usuarios.idUsuario
											INNER JOIN clientes
											ON facturas.idCliente = clientes.idCliente
											WHERE facturas.idFactura = $noFactura AND facturas.idCliente = $codCliente AND facturas.estado != 10 ");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['idFactura'];

			$numeroDocumento = $factura['numeroDocumento'];
			$numero_descuento = 0;

			$query_descuento = mysqli_query($conection2, "SELECT numeroDescuento AS descuento FROM descuentos WHERE numeroDocumento LIKE '$numeroDocumento'");
			$result_descuento = mysqli_num_rows($query_descuento);
			

			if ($result_descuento > 0) {
				$info_descuento = mysqli_fetch_assoc($query_descuento);
				$numero_descuento = $info_descuento['descuento'];
			} else {
				$numero_descuento = 0;
			}



			if($factura['estado'] == 2){
				$anulada = '<img class="anulada" src="img/anulado.png" alt="Anulada">';
			}

			$query_productos = mysqli_query($conection,"SELECT productos.descripcion, detallefactura.cantidad, detallefactura.precio_venta,(detallefactura.cantidad * detallefactura.precio_venta) as precio_total
														FROM facturas
														INNER JOIN detallefactura
														ON facturas.idFactura = detallefactura.idFactura
														INNER JOIN productos
														ON detallefactura.idProducto = productos.idProducto
														WHERE facturas.idFactura = $no_factura ");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>