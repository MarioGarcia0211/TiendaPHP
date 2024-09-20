<?php
$subtotal     = 0;
$iva          = 0;
$impuesto     = 0;
$tl_sniva   = 0;
$total         = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include "../includes/scripts.php"; ?>
</head>

<body>
    <div>
        <div class="container">
            <h1 class="text-center">Sistema</h1>

            <div class="card">
                <div class="card-header">Datos del cliente</div>
                <div class="card-body">
                    <div class="row">
                        <!-- Numero documento -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Número del documento</label>
                            <input class="form-control" type="number" disabled value="<?php echo $factura['numeroDocumento']; ?>" name="nit_cliente" id="nit_cliente">
                        </div>
                        <!-- Final numero documento -->

                        <!-- Nombre -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Nombre</label>
                            <input class="form-control" type="text" disabled value="<?php echo $factura['nombre']; ?>" name="nombre" id="nombre">
                        </div>
                        <!-- Final nombre -->

                        <!-- Apellido -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Apellido</label>
                            <input class="form-control" type="text" disabled name="apellido" id="apellido">
                        </div>
                        <!-- Final apellido -->

                        <!-- Numero telefonico -->
                        <div class="form-group col-md-6">
                            <label class="form-label">Número telefonico</label>
                            <input class="form-control" type="number" disabled value="<?php echo $factura['telefono']; ?>" name="telefono" id="telefono">
                        </div>
                        <!-- Final numero telefonico -->

                        <!-- Dirección -->
                        <div class="form-group col-md-6">
                            <label class="form-label">Dirección</label>
                            <input class="form-control" type="text" disabled value="<?php echo $factura['direccion']; ?>" name="direccion" id="direccion">
                        </div>
                        <!-- Final Dirección -->

                        <input type="hidden" name="idCliente" id="idCliente">
                    </div>
                </div>
            </div>

            <table class="table table-bordered" style="margin-top: 15px;">
                <thead class="text-center">
                    <tr>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio unitario</th>
                        <th>Precio total</th>
                    </tr>
                </thead>
                <tbody class="text-center" id="detalle_productos">

                    <?php

                    if ($result_detalle > 0) {

                        while ($row = mysqli_fetch_assoc($query_productos)) {
                    ?>
                            <tr>
                                <td class="textcenter"><?php echo $row['cantidad']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                                <td class="textright"><?php echo $row['precio_venta']; ?></td>
                                <td class="textright"><?php echo $row['precio_total']; ?></td>
                            </tr>
                    <?php
                            $precio_total = $row['precio_total'];
                            $subtotal = round($subtotal + $precio_total, 2);
                        }
                    }

                    $tl_sniva     = $subtotal;
                    ?>
                </tbody>
                <tfoot class="textcenter" id="detalle_totales">
                    <tr>
                        <td colspan="3" class="textright"><span>TOTAL</span></td>
                        <td class="textright"><span><?php echo $tl_sniva; ?></span></td>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>

</body>

</html>