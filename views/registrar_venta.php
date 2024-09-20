<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar venta</title>
    <?php include "includes/scripts.php"; ?>

    <style>
        .card {
            margin-top: 15px;
            margin-bottom: 15px;
            width: 100%;
        }

        #add_product_venta {
            display: none;
        }
    </style>
</head>

<body>
    <?php include "includes/navbar.php"; ?>

    <div class="contenedor">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="lista_venta.php">Lista de ventas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="registrar_venta.php">Registrar venta</a>
            </li>
        </ul>

        <h1>Registrar venta</h1>
        <div class="card">
            <div class="card-header">
                Datos del cliente
            </div>
            <div class="card-body">
                <form action="" name="form_new_cliente_venta" id="form_new_cliente_venta">
                    <div class="row">
                        <!-- Numero documento -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Número del documento</label>
                            <input class="form-control" type="number" name="nit_cliente" id="nit_cliente">
                        </div>
                        <!-- Final numero documento -->

                        <!-- Nombre -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Nombre</label>
                            <input class="form-control" type="text" disabled name="nombre" id="nombre">
                        </div>
                        <!-- Final nombre -->

                        <!-- Apellido -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Apellido</label>
                            <input class="form-control" type="text" disabled name="apellido" id="apellido">
                        </div>
                        <!-- Final apellido -->

                        <!-- Numero telefonico -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Número telefonico</label>
                            <input class="form-control" type="text" disabled name="telefono" id="telefono">
                        </div>
                        <!-- Final numero telefonico -->

                        <!-- Dirección -->
                        <div class="form-group col-md-4">
                            <label class="form-label">Dirección</label>
                            <input class="form-control" type="text" disabled name="direccion" id="direccion">
                        </div>
                        <!-- Final Dirección -->

                        <input type="hidden" name="idCliente" id="idCliente">
                    </div>
                </form>
            </div>
        </div>

        <!-- ----------------------------------------------------------------------- -->

        <div class="card">
            <div class="card-header">
                Datos de la venta
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Nombre -->
                    <div class="form-group col-md-6">
                        <label class="form-label">Usuario</label>
                        <input class="form-control" type="text" disabled name="" id="" value="<?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?>">
                    </div>
                    <!-- Final nombre -->

                    <div class="form-group col-md-6">
                        <label class="form-label">Acciones</label>
                        <div class="d-grid gap-2 d-md-block">
                            <a href="" id="btn_facturar_venta" class="btn btn-primary " type="button" title="">Procesar</a>


                            <a href="" id="btn_anular_venta" class="btn btn-danger" type="button" title="">Anular</a>

                        </div>
                    </div>
                </div>
                <div class="contenido-tabla">
                    <div class="table-responsive">
                        <table class="table table-bordered table-fixed table-striped">
                            <thead class="cabecera text-center">
                                <tr>
                                    <th scope="col" data-toggle="tooltip">Código</th>
                                    <th scope="col" data-toggle="tooltip">Descripcion</th>
                                    <th scope="col" data-toggle="tooltip">Existencia</th>
                                    <th scope="col" data-toggle="tooltip">Cantidad</th>
                                    <th scope="col" data-toggle="tooltip">Precio</th>
                                    <th scope="col" data-toggle="tooltip">Total</th>
                                    <th scope="col" data-toggle="tooltip">Accion</th>
                                </tr>
                                <tr>
                                    <td class="align-middle"><input class="form-control" name="txt_cod_producto" id="txt_cod_producto" type="text"></td>
                                    <td class="align-middle" id="txt_descripcion"></td>
                                    <td class="align-middle" id="txt_existencia"></td>
                                    <td class="align-middle"><input class="form-control" name="txt_cant_producto" id="txt_cant_producto" disabled value="0" min="1"></td>
                                    <td class="align-middle" id="txt_precio"></td>
                                    <td class="align-middle" id="txt_precio_total"></td>
                                    <td class="align-middle"><a href="#" id="add_product_venta" class="text-success">Agregar</a></td>
                                </tr>
                                <tr>
                                    <th class="table-info" style="width: 150px" scope="col" data-toggle="tooltip">Código</th>
                                    <th class="table-info" colspan="2" data-toggle="tooltip">Descripcion</th>
                                    <th class="table-info" style="width: 150px" scope="col" data-toggle="tooltip">Cantidad</th>
                                    <th class="table-info" scope="col" data-toggle="tooltip">Precio</th>
                                    <th class="table-info" scope="col" data-toggle="tooltip">Total</th>
                                    <th class="table-info" scope="col" data-toggle="tooltip">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="detalle_venta">
                                <!-- Contenido ajax -->
                            </tbody>

                            <tfoot id="detalle_totales">
                                <!-- Contenido ajax -->
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/traerId.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var usuarioid = '<?php $_SESSION['idUsuario'] ?>';
            searchForDetalle(usuarioid);
        });
    </script>
</body>

</html>