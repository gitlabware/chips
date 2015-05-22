<section role="main" id="main">
    <div class="with-padding">
        <div class="grid-4">
            <div class="title-grid">
                <span>Ventas a clientes</span>
            </div>
            <div class="content-gird">
                <div id="imprimir">
                    <?php $id = $precios['0']['Producto']['id']; ?>
                    <?php echo $this->Form->create('Ventasdistribuidore', array('url' => array( 'action' => 'formulario'), 'id'=>'formID')); ?>
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
                    <?php foreach ($rows as $r): ?>
                        <table class="simple-table responsive-table">
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
                                        <?php 
                                        $n = 0;
                                        foreach ($precios as $p): ?>

                                            <?php if ($p['Productosprecio']['producto_id'] == $r['Producto']['id']): ?>
                                                <tr>

                                                    <?php echo $this->Form->hidden("Ventasdistribuidore.$n.producto_id", array('value' => $p['Productosprecio']['producto_id'])); ?>
                                                    <?php echo $this->Form->hidden("Ventasdistribuidore.$n.usuario_id", array('value' => $usu)); ?>
                                                    <?php echo $this->Form->hidden("Ventasdistribuidore.$n.cliente_id", array('value' => $datoscli['Cliente']['id'])); ?>
                                                    <td>
                                                        <?php echo $this->Form->hidden("Ventasdistribuidore.$n.precio", array(
                                                            'value' => $p['Productosprecio']['precio'], 
                                                            "id" => "price_item_$n")); ?>
                                                        <?php $precio = $p['Productosprecio']['precio']; ?>
                                                        <?php echo "$" . $precio; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $this->Form->text("Ventasdistribuidore.$n.cantidad", 
                                                                array('value' => '0',
                                                                    "id" => "qty_item_$n", 
                                                                    'class' => 'input validate[required,custom[integer], min[0]]', 
                                                                    'size' => '6')); ?>
                                                    </td>
                                                    <td align="center" id="total2_item_<?php echo $n; ?>">
                                                        0
                                                    </td>
                                                </tr>
                                                <?php echo $this->Form->hidden("Ventasdistribuidore.$n.escala", array('value' => $p['Productosprecio']['escala'])); ?>
                                                <?php echo $this->Form->hidden("Ventasdistribuidore.$n.subtotal", array('id'=>"total_item_$n")); ?>
                                                <?php $fecha = date('Y-m-d'); ?>
                                                <?php echo $this->Form->hidden("Ventasdistribuidore.$n.fecha", array('value' => $fecha)); ?>
                                            <?php $n++; ?>
                                           <?php endif; ?>
                                            
                                            <script>
                                                function redondeo2decimales(numero)
                                                {
                                                    var original = parseFloat(numero);
                                                    var result = Math.round(original * 100) / 100;
                                                    return result;
                                                }
                                                function suma(){
                                                    var sumatotal = 0;
                                                    $('input[id^="total_item_"]').each(function(){
                                                     sumatotal = sumatotal + Number(this.value);   
                                                    });
                                                    
                                                   //console.log('total general ' + sumatotal);
                                                   $('#grandTotal').val(sumatotal);
                                                }
                                                $(document).ready(function() {
                                                    $("input[type='text']").change(function() {
                                                        var subtotal = 0;
                                                        var producto = 0;
                                                        
                                                        producto = Number($("input[id='price_item_<?php echo $n ?>']").val() * $("input[id='qty_item_<?php echo $n ?>']").val());
                                                        console.log('la variable es' + producto);
                                                       
                                                        subtotal = redondeo2decimales(producto);
                                                        $("#total_item_<?php echo $n; ?>").val(subtotal);
                                                        $("#total2_item_<?php echo $n; ?>").html(subtotal);
                                                        total = suma();
                                                        //suma
                                                        
                                                    });
                                                });
                                            </script>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    <?php endforeach; ?>
                    <table class="simple-table responsive-table">
                        
                        <tr>
                            <th colspan="4" align="right" class="text">
                                <strong>Total ventas:</strong>
                            </th>
                            <th align="center" id="grandTotal">0</th>
                        </tr>


                    </table> 

                    <table style="border: 1">
                        <tr>
                            <td colspan="3" class="total">Total recargas solicitadas:</td>
                        </tr>
                        <tr>
                            <th>N&uacute;mero</th>
                            <th>Monto</th>
                            <th>%</th>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->text('"Ventasdistribuidore.$n.num_abonado', array('placeholder' => 'numero')); ?>
                            </td>

                            <td>
                                <?php echo $this->Form->text("Ventasdistribuidore.$n.monto", array("id" => "qty_item_$n", 'size' => '6', 'placeholder' => 'monto')); ?>
                            </td>
                            <td>
                                <?php echo $this->Form->text("Ventasdistribuidore.$n.porcentaje", array("id" => "qty_item_$n", 'size' => '6', 'placeholder' => 'porcentaje 5 o 7')); ?> %
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->text('num_abonado', array('placeholder' => 'numero')); ?>
                            </td>

                            <td>
                                <?php echo $this->Form->text("Ventasdistribuidore.$n.monto", array("id" => "qty_item_$n", 'size' => '6', 'placeholder' => 'monto')); ?>
                            </td>
                            <td>
                                <?php echo $this->Form->text("Ventasdistribuidore.$n.porcentaje", array("id" => "qty_item_$n", 'size' => '6', 'placeholder' => 'porcentaje 5 o 7')); ?> %
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->text('num_abonado', array('placeholder' => 'numero')); ?>
                            </td>

                            <td>
                                <?php echo $this->Form->text("$n.Ventasdistribuidore.monto", array("id" => "qty_item_$n", 'size' => '6', 'placeholder' => 'monto')); ?>
                            </td>
                            <td>
                                <?php echo $this->Form->text("$n.Ventasdistribuidore.porcentaje", array("id" => "qty_item_$n", 'size' => '6', 'placeholder' => 'porcentaje 5 o 7')); ?> %
                            </td>
                        </tr>
                        <?php $n++; ?>

                        <tr>
                            <td colspan="2">Total recargas:</td>
                            <th id="totalpago">0</th>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: none;">
                                <?php $opt = array('Value' => 'registrar', 'class' => "boton"); ?>    
                                <?php echo $this->Form->end($opt); ?>
                            </td>
                        </tr>
                    </table>




                </div>

            </div>

            <!--*************************************************************************************************************************************
                     //botoneria-->
            <div class="grid-buttons">

                <div style="float: left;">
                    <input type="button" class="button" value="Atras" onclick="javascript:history.back();" /> 
                </div> 


                <div class="clear"> </div>
            </div>
            <!--/*************************************************************************************************************************************-->         
        </div>
    </div>

</section>
   <script>
$(document).ready(function(){
    
       $("#formID").validationEngine();
   });
</script>