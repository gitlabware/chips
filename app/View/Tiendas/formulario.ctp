
<script>
    function sacatotal() {
        var totalpago = 0;
        //console.log($("#grandTotal").text());
        totalpago = Number($("#grandTotal").text()) + Number($("#totalrecargas").text());
        //console.log('suma total ' + totalpago);
        $("#total").html(totalpago);
    }
</script>
<section role="main" id="main">
    <div class="with-padding">
        <div class="grid-4">
            <div class="title-grid">
                <span>Ventas a clientes</span>
            </div>
            <div class="content-gird">
                <div id="imprimir">
                    <?php $id = $precios['0']['Producto']['id']; ?>
                    <?php echo $this->Form->create(null, array('url' => array('controller' =>
        'Tiendas', 'action' => 'registra_venta_mayor'), 'id' => 'formID')); ?>
                    <?php echo $this->Form->hidden('Ventastienda.sucursal_id',array('value' => $this->Session->read('Auth.User.sucursal_id')));?>
                    <?php echo $this->Form->hidden('Ventastienda.cliente_id',array('value' => $datoscli['Cliente']['id']));?>
                    <?php echo $this->Form->hidden('Ventastienda.user_id',array('value' => $this->Session->read('Auth.User.id')));?>
                    <?php echo $this->Form->hidden('Ventastienda.escala',array('value' => 'MAYOR'));?>
                    <table class="simple-table responsive-table">
                        <tr>
                            <th class="txt">149:</th>
                            <td class="txt"><?php echo $datoscli['Cliente']['num_registro']; ?></td>
                            <th>Fecha: </th>
                            <td><?php echo date("y-m-d"); ?></td>
                        </tr>
                        <tr>
                            <th class="txt">Nombre</th>
                            <td class="txt" colspan="3"><?php echo $datoscli['Cliente']['nombre']; ?></td>
                        </tr>
                    </table>
                    <?php $n = 1; ?>
                    <?php foreach ($rows as $r): ?>
                        <table class="simple-table responsive-table" >
                            <tr>
                                <?php if ($r['0']['cantidad'] == 1): ?>
                                    <?php $filas = 3; ?>
                                <?php else: ?>
                                    <?php $filas = $r['0']['cantidad']; ?>
                                <?php endif; ?>
                                <td rowspan="<?php echo $filas; ?>" >
                                    <?php echo $r['Producto']['nombre']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="mitabla2">
                                        <tr>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Total</th>
                                        </tr>
                                        
                                        <?php foreach ($precios as $p): ?>

                                            <?php if ($p['Productosprecio']['producto_id'] ==
$r['Producto']['id']): ?>
                                                <tr>
                                                     <?php echo $this->Form->
                hidden("Movimiento.$n.user_id", array('value' => $usu)); ?>
                                                    <?php echo $this->Form->
                hidden("Movimiento.$n.producto_id", array('value' => $p['Productosprecio']['producto_id'])); ?>
                                                    <?php echo $this->Form->hidden("Movimiento.$n.almacene_id", array('value' => $idAlmacen)); ?>
                                                    <?php echo $this->Form->hidden("Movimiento.$n.cliente_id", array('value' => $datoscli['Cliente']['id'])); ?>
                                                    <?php echo $this->Form->hidden("Movimiento.$n.sucursal_id", array('value' => $this->Session->read('Auth.User.sucursal_id'))); ?>
                                                    <?php echo $this->Form->hidden("Movimiento.$n.nombre_prod",array('value' => $r['Producto']['nombre']))?>
                                                    <?php echo $this->Form->hidden("Movimiento.$n.escala",array('value' => 'MAYOR'))?>
                                                    <td>
                                                        <?php echo $this->Form->
                hidden("Movimiento.$n.precio_uni", array('value' => $p['Productosprecio']['precio'],
                        "id" => "price_item_$n")); ?>
                                                        <?php $precio = $p['Productosprecio']['precio']; ?>
                                                        <?php echo "$" . $precio; ?>
                                                    </td>
                                                    <td><?php echo $this->Form->
                text("Movimiento.$n.salida", array(
                    //'value' => '0',
                    "id" => "qty_item_$n",
                    'class' => 'input validate[custom[integer], min[0]]',
                    'size' => '6')); ?></td>
                                                    <td align="center" id="total2_item_<?php echo
                $n; ?>">
                                                        0
                                                    </td>
                                                </tr>
                                                <?php echo $this->Form->hidden("Movimiento.$n.total_p",
                array('id' => "total_item_$n")); ?>
                                            
                                            <script>
                                                function redondeo2decimales(numero)
                                                {
                                                    var original = parseFloat(numero);
                                                    var result = Math.round(original * 100) / 100;
                                                    return result;
                                                }
                                                function suma() {
                                                    var sumatotal = 0;
                                                    $('input[id^="total_item_"]').each(function() {
                                                        sumatotal = sumatotal + Number(this.value);
                                                    });

                                                    //console.log('total general ' + sumatotal);
                                                    $('#grandTotal').html(sumatotal);
                                                }

                                                $(document).ready(function() {
                                                    $("input[type='text']").change(function() {
                                                        var subtotal = 0;
                                                        var producto = 0;
                                                        var a = $("input[id='price_item_<?php echo
                $n ?>']").val();
                                                        var b = $("input[id='qty_item_<?php echo
                    $n ?>']").val();
                                                        console.log('precio ' + a);
                                                        console.log('cantidad' + b);
                                                        producto = Number( a * b);
                                                        console.log('el producto es' + producto);

                                                        subtotal = redondeo2decimales(producto);
                                                        $("#total_item_<?php echo
                    $n; ?>").val(subtotal);
                                                        $("#total2_item_<?php echo
                $n; ?>").html(subtotal);
                                                        suma();
                                                        //suma
                                                        sacatotal();
                                                    });
                                                });
                                            </script>
                                            <?php $n++; ?>
                                            <?php endif; ?>
                                            
                                            
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    <?php endforeach; ?>
                    <table class="simple-table responsive-table">

                        <tr>
                            <th align="right" class="text">
                                <strong>Total ventas:</strong>
                            </th>

                            <th align="center" id="grandTotal">0</th>
                        </tr>


                    </table> 
                    <table class="simple-table responsive-table">
                        <thead>
                            <tr>
                                <th>
                                    N&uacute;mero
                                </th>
                                <th>
                                  
                                     <th>
                                
                                    Monto
                                </th>
                                <th>
                                    porcentaje
                                </th>
                                <th>
                                    total recarga 
                                </th>
                                <th>
                                   por cobrar
                                </th>
                                  
                                </th>
                                
                            </tr>
                        </thead>
                    </table>
                    <table class="simple-table responsive-table">
                       
                        <tbody>
                            <?php for ($n = 1; $n <= 3; $n++): ?>
                            <?php echo $this->Form->hidden("Recarga.$n.user_id",
            array('value' => $usu)); ?>
                            <?php echo $this->Form->hidden("Recarga.$n.sucursal_id",
            array('value' => $sucursal)); ?> 
                            <?php echo $this->Form->hidden("Recarga.$n.cliente_id",
            array('value' => $datoscli['Cliente']['id'])); ?> 
            <?php echo $this->Form->hidden("Recarga.$n.estado", array('value' =>
0)); ?>
                                <tr>
                                    <td>
                                     <?php echo $this->Form->text("Recarga.$n.numero",
            array(
                'size' => '5',
                'class' => 'input validate[custom[integer]]',
                'value' => '0')); ?>&nbsp;Num
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <?php echo $this->Form->
            text("Recarga.$n.monto", array(
                "id" => "item_$n",
                'size' => '4',
                'class' => 'input validate[custom[integer]]',
                'value' => '0')); ?>&nbsp;Bs
                                                </td>
                                                <td>
                                                    <?php echo $this->Form->
            text("Recarga.$n.porcentaje", array(
                "id" => "porcentaje_$n",
                'class' => 'input validate[custom[integer], min[5], max[8]]',
                'size' => '2',
                'value' => '7')); ?>&nbsp;%
                                                </td>
                                                <?php echo $this->Form->hidden("Recarga.$n.total",
            array('id' => "monto_$n")); ?>
                                                <td id="subtotalrecarga_<?php echo
            $n ?>">
                                                    0
                                                </td>
                                                <td>
                                                <?php echo $this->Form->
                checkbox("Recarga.$n.xcobrar", array('class' => 'checkbox')) ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                            <script>
                                function redondeo2decimales(numero)
                                {
                                    var original = parseFloat(numero);
                                    var result = Math.round(original * 100) / 100;
                                    return result;
                                }

                                $(document).ready(function() {
                                    $("input[type='text']").change(function() {
                                        var subtotal2 = 0;
                                        var producto2 = 0;

                                        producto2 = Number($("input[id='item_<?php echo
                $n ?>']").val() * $("input[id='porcentaje_<?php echo $n ?>']").val()) / 100;
                                        // console.log('la variable es' + producto);
                                        subtotal2 = redondeo2decimales(producto2 + Number($("input[id='item_<?php echo
                $n ?>']").val()));

                                        $("#monto_<?php echo $n; ?>").val(subtotal2);
                                        $("#subtotalrecarga_<?php echo $n ?>").html(subtotal2);
                                        //total2 = suma2();
                                        //suma
                                        var sumatotal2 = 0;
                                        $('input[id^="item_"]').each(function() {
                                            //console.log('entro ' + this.value);
                                            sumatotal2 = sumatotal2 + Number(this.value);
                                        });

                                        //console.log('total recargas ' + sumatotal2);
                                        $('#grandTotal2').val(sumatotal2);
                                        $("#totalrecargas").html(sumatotal2);
                                        sacatotal();

                                    });
                                });
                            </script>
                        <?php endfor; ?>
                            <tr>
                            <th align="right" class="text">
                                <strong>Total recargas:</strong>
                            </th>

                            <th align="center" id="totalrecargas">0</th>
                        </tr>
                       
                        
                        </tbody>
                    </table>
                    <table>
                        <tr>
                            <td>
                                <?php $opt = array('Value' => 'registrar venta',
            'class' => "button"); ?>    
                                <?php echo $this->Form->end($opt); ?>
                            </td>
                        </tr>
                    </table>
                    <table class="simple-table responsive-table">

                        <tr>
                            <th colspan="4" align="right" style="font-size: 20px;">
                                <strong>Total a cancelar:</strong>
                            </th>

                            <th align="center" id="total" style="font-size: 20px;">0</th>
                        </tr>


                    </table>



                </div>

            </div>

            <!--*************************************************************************************************************************************
                     //botoneria-->
            <div class="grid-buttons">

                <?php echo $this->Html->link('ATRAS', array('action' =>
'pidecodigo'), array('class' => 'button blue-gradient')); ?>


                <div class="clear"> </div>
            </div>
            <!--/*************************************************************************************************************************************-->         
        </div>
    </div>

</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu -->
<script>
                                $(document).ready(function() {

                                    $("#formID").validationEngine();

                                });
</script>