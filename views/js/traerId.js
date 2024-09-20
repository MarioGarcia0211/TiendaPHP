$(document).ready(function(){

    //Buscar cliente
    $('#nit_cliente').keyup(function(e) {
        e.preventDefault();

        var cl = $(this).val();
        var action = 'searchCliente';

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data: {action:action, cliente:cl},
    
            success: function(response){
    
                console.log(response);
                if(response == 0){
                    $('#idCliente').val('');
                    $('#nombre').val('');
                    $('#apellido').val('');
                    $('#telefono').val('');
                    $('#direccion').val('');
                    

                }else{
                    var data = $.parseJSON(response);
                    $('#idCliente').val(data.idCliente);
                    $('#nombre').val(data.nombre);
                    $('#apellido').val(data.apellido);
                    $('#telefono').val(data.telefono);
                    $('#direccion').val(data.direccion);
                    
                }
            },
    
            error: function(error) {
                console.log(error);
            }
        });

    });

    //Buscar producto
    $('#txt_cod_producto').keyup(function(e) {
        e.preventDefault();

        var producto = $(this).val();
        var action = 'infoProducto';

        if(producto != ''){
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: true,
                data: {action:action, producto:producto},
        
                success: function(response){
        
                    
                    if (response != 'error') {
                        var info = JSON.parse(response);
                        $('#txt_descripcion').html(info.descripcion);
                        $('#txt_existencia').html(info.existencia);
                        $('#txt_cant_producto').val('1');
                        $('#txt_precio').html(info.precio);
                        $('#txt_precio_total').html(info.precio);

                        //Activa el input de la cantidad
                        $('#txt_cant_producto').removeAttr('disabled');

                        //Mostrar boton agregar
                        $('#add_product_venta').slideDown();
                        

                    }else{
                        $('#txt_descripcion').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0');
                        $('#txt_precio_total').html('0');

                        //Desactivar el input de la cantidad
                        $('#txt_cant_producto').attr('disabled', 'disabled');

                        //Ocultar boton agregar
                        $('#add_product_venta').slideUp();
                    }
    
                },
        
                error: function(error) {
                    console.log(error);
                }
            });
        }

    });



    //Validar cantidad del producto antes de calcular
    $('#txt_cant_producto').keyup(function(e){
        e.preventDefault();
        var precio_total = $(this).val() * $('#txt_precio').html();
        
        var existencia =  parseInt($('#txt_existencia').html()); 
        $('#txt_precio_total').html(precio_total);

        //Oculta el boton agregar si la cantidad es menor a 1
        if ($(this).val() < 1 || isNaN($(this).val()) || $(this).val() > existencia) {
            $('#add_product_venta').slideUp();
        } else {
            $('#add_product_venta').slideDown();
        }
    });

    //Agregar producto al detalle
    $('#add_product_venta').on("click", function(e){
        e.preventDefault();

        if($('#txt_cant_producto').val() > 0){
            var idProducto = $('#txt_cod_producto').val();
            var cantidad = $('#txt_cant_producto').val();
            var action = 'addProductoDetalle';
            var cl = $('#nit_cliente').val();
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: true,
                data: {action:action, producto:idProducto, cantidadProducto:cantidad, cliente:cl},
        
                success: function(response){
                    if(response != 'error'){

                       var info = JSON.parse(response);
                       $('#detalle_venta').html(info.detalle);
                       $('#detalle_totales').html(info.totales);
                       
                       $('#txt_cod_producto').val('');
                       $('#txt_descripcion').html('-');
                       $('#txt_existencia').html('-');
                       $('#txt_cant_producto').val('0');
                       $('#txt_precio').html('0');
                       $('#txt_precio_total').html('0');

                       //Desactivar el input de la cantidad
                       $('#txt_cant_producto').attr('disabled', 'disabled');

                       //Ocultar boton agregar
                       $('#add_product_venta').slideUp();

                    } else{
                        console.log('No datos');
                    }
                },
        
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    //Anular venta
    $('#btn_anular_venta').on("click", function(e){
        e.preventDefault();

        var rows = $('#detalle_venta tr').length;

        if(rows > 0){
            var action = 'anularVenta';

            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: true,
                data: {action:action},
        
                success: function(response){
                    
                    console.log(response);

                    if(response != 'error'){
                        location.reload();
                    }
                },
        
                error: function(error) {
                    console.log(error);
                }
            });

        }
    });

    //Generar venta
    $('#btn_facturar_venta').on("click", function(e){
        e.preventDefault();

        var rows = $('#detalle_venta tr').length;

        if(rows > 0){
            var action = 'procesarVenta';
            var codCliente = $('#idCliente').val();

            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: true,
                data: {action:action, codCliente:codCliente},
        
                success: function(response){
                    
                    if(response != 'error'){

                        var info = JSON.parse(response);
                        console.log(info);

                        generarPDF(info.idCliente, info.idFactura);
                        location.reload();

                    }else{
                        console.log("No data");
                    }

                },
        
                error: function(error) {
                    console.log(error);
                }
            });

        }
    });

    //Mostrar factura
    $('.view_factura').on("click", function(e){
        //e.preventDefault();

        var codCliente = $('.view_factura').attr('cl');
        var codFactura = $('.view_factura').attr('f');

        generarPDF(codCliente, codFactura);

        console.log(codCliente, codFactura);
    });


});

function searchForDetalle(id){
    var action = 'searchForDetalle';
    var user = id;
    var cl = $('#nit_cliente').val();

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: {action:action, user:user, cliente:cl},

        success: function(response){
            if(response != 'error'){

                var info = JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);

             } else{
                 console.log('No datos');
             }
        },

        error: function(error) {
            console.log(error);
        }
    });
    
}

function del_product_detalle(idTemporal){
    var action = 'delProductoDetalle';
    var id_detalle = idTemporal;
    var cl = $('#nit_cliente').val();

    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data: {action:action, id_detalle:id_detalle, cliente:cl},

        success: function(response){

            if(response != 'error'){
                var info = JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);      
                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_precio').html('0');
                $('#txt_precio_total').html('0');

            }else{
                $('#detalle_venta').html('');
                $('#detalle_totales').html('');
            }
            
        },

        error: function(error) {
            console.log(error);
        }
    });
}

function generarPDF(cliente, factura){
    var ancho = 1000;
    var alto = 800;

    //Clacular posicion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generarFactura.php?cl='+cliente+'&f='+factura;
    window.open($url, "Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}