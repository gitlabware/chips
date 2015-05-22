<script>
    function sacatotal() {
        var totalpago = 0;
        //console.log($("#grandTotal").text());
        totalpago = Number($("#grandTotal").text()) + Number($("#totalrecargas").text());
        //console.log('suma total ' + totalpago);
        $("#total").html(totalpago);
    }
    
    
    
</script>
<h1>VENTAS AL CLIENTE</h1>
<?php $id = $precios['0']['Producto']['id']; ?>
                    <?php echo $this->Form->create(null, array('url' => array('controller' =>
        'ventasdistribuidor', 'action' => 'formulario_mobile'), 'id' => 'formID')); ?>
<div class="ui-grid-a">
    <div class="ui-block-a"><div class="ui-bar ui-bar-a" >149: </div></div>
    <div class="ui-block-b"><div class="ui-bar ui-bar-a" ><?php echo $datoscli['Cliente']['num_registro']; ?></div></div>
</div>
<div class="ui-grid-a">
    
    <div class="ui-block-a"><div class="ui-bar ui-bar-a" >Fecha: </div></div>
    <div class="ui-block-b"><div class="ui-bar ui-bar-a" ><?php echo date("y-m-d"); ?></div></div>
</div><!-- /grid-c -->


<?php $n = 1; ?>
                    <?php foreach ($rows as $r): ?>
                        <div class="ui-grid-solo">
                        <div class="ui-block-a">
                            <div  align="center">
                            <?php if ($r['0']['cantidad'] == 1): ?>
                                    <?php $filas = 3; ?>
                                <?php else: ?>
                                    <?php $filas = $r['0']['cantidad']; ?>
                                <?php endif; ?>
                                    <?php echo $r['Producto']['nombre']; ?>
                            </div>
                                
                            </div>
                        </div>
                        <div class="ui-grid-solo" >
                            
                            <div class="ui-block-a">
                                <div class="ui-bar ui-bar-a">
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
                hidden("Ventasdistribuidore.$n.user_id", array('value' => $usu)); ?>
                                                    <?php echo $this->Form->
                hidden("Ventasdistribuidore.$n.producto_id", array('value' => $p['Productosprecio']['producto_id'])); ?>
                                                    <?php echo $this->Form->
                hidden("Ventasdistribuidore.$n.persona_id", array('value' => $usuario)); ?>
                                                    <?php echo $this->Form->
                hidden("Ventasdistribuidore.$n.cliente_id", array('value' => $datoscli['Cliente']['id'])); ?>
                                                    <td>
                                                        <?php echo $this->Form->
                hidden("Ventasdistribuidore.$n.precio", array('value' => $p['Productosprecio']['precio'],
                        "id" => "price_item_$n")); ?>
                                                        <?php $precio = $p['Productosprecio']['precio']; ?>
                                                        <?php echo "$" . $precio; ?>
                                                    </td>
                                                    <td><?php echo $this->Form->
                text("Ventasdistribuidore.$n.cantidad", array(
                    'value' => '0',
                    "id" => "qty_item_$n",
                    'class' => 'input validate[required,custom[integer], min[0]]',
                    'size' => '6',
                    'type' => 'number'
                    )); ?></td>
                                                    <td align="center" id="total2_item_<?php echo
                $n; ?>">
                                                        0
                                                    </td>
                                                </tr>
                                                <?php echo $this->Form->hidden("Ventasdistribuidore.$n.escala",
                array('value' => $p['Productosprecio']['escala'])); ?>
                                                <?php echo $this->Form->hidden("Ventasdistribuidore.$n.total",
                array('id' => "total_item_$n")); ?>
                                                <?php $fecha = date('Y-m-d'); ?>
                                                <?php echo $this->Form->hidden("Ventasdistribuidore.$n.fecha",
                array('value' => $fecha)); ?>
                                            
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
                                                    $("input[type='number']").change(function() {
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
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar ui-bar-a">
Total ventas:
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar ui-bar-a" id="grandTotal">
0
</div>
</div>
</div>



<?php for ($n = 1; $n <= 3; $n++): ?>
                            <?php echo $this->Form->hidden("Recarga.$n.user_id",
            array('value' => $usu)); ?>
                            <?php echo $this->Form->hidden("Recarga.$n.persona_id",
            array('value' => $usuario)); ?> 
                            <?php echo $this->Form->hidden("Recarga.$n.cliente_id",
            array('value' => $datoscli['Cliente']['id'])); ?> 
            <?php echo $this->Form->hidden("Recarga.$n.estado", array('value' =>
0)); ?>

<div data-role="collapsible" data-theme="b" data-content-theme="b">
    <h4>Recarga</h4>
    <p>
    <div class="ui-field-contain">
    <label for="">N&uacute;mero:</label>
    <?php echo $this->Form->text("Recarga.$n.numero",
            array(
                'size' => '5',
                'class' => 'input validate[custom[integer]]',
                'value' => '0',
                    'type' => 'number')); ?>
</div>
<div class="ui-field-contain">
    <label for="">Monto Bs:</label>
    <?php echo $this->Form->
            text("Recarga.$n.monto", array(
                "id" => "item_$n",
                'size' => '4',
                'class' => 'input validate[custom[integer]]',
                'value' => '0',
                    'type' => 'number')); ?>
</div>
<div class="ui-field-contain">
    <label for="">porcentaje %o:</label>
    <?php echo $this->Form->
            text("Recarga.$n.porcentaje", array(
                "id" => "porcentaje_$n",
                'class' => 'input validate[custom[integer], min[5], max[8]]',
                'size' => '2',
                'value' => '7',
                    'type' => 'number')); ?>
</div>
<div class="ui-field-contain">
    <label for="">total recarga:</label>
    <div id="subtotalrecarga_<?php echo $n ?>">
    <p>
    0
    </p>
    </div>
</div>

<div class="ui-field-contain">
    <fieldset data-role="controlgroup">
        <legend>Por Cobrar:</legend>
        <label for="checkcobrar<?php echo $n;?>">Si</label>
        <?php echo $this->Form->
                checkbox("Recarga.$n.xcobrar",array('id' => 'checkcobrar'.$n)) ?>
    </fieldset>
</div>
    </p>
</div>




<script>
                                function redondeo2decimales(numero)
                                {
                                    var original = parseFloat(numero);
                                    var result = Math.round(original * 100) / 100;
                                    return result;
                                }

                                $(document).ready(function() {
                                    $("input[type='number']").change(function() {
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
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar ui-bar-a">
Total recargas:
</div>

</div>
<div class="ui-grid-b">
<div class="ui-bar ui-bar-a" id="totalrecargas">
0
</div>
</div>
</div>

<div class="ui-input-btn ui-btn ui-btn-b">
        Registrar Venta
        
        <?php echo $this->Form->submit("Registrar Venta",array('data-enhanced' => true));?>
</div>
<?php echo $this->Form->end();?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar ui-bar-a">
Total a Cancelar:
</div>

</div>
<div class="ui-grid-b">
<div class="ui-bar ui-bar-a" id="total">
0
</div>
</div>
</div>

