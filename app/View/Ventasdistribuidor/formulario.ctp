
<script>
  function sacatotal() {
      var totalpago = 0;
      //console.log($("#grandTotal").text());
      totalpago = Number($("#grandTotal").text()) + Number($("#totalrecargas").text());
      //console.log('suma total ' + totalpago);
      //$("#total").html(totalpago);
  }
</script>
<section role="main" id="main">
    <div class="with-padding">
        <div class="grid-4">
            <div class="title-grid">
                <span style=" font-size: 20px;">Ventas a clientes</span>
            </div>
            <div class="content-gird">
                <div id="imprimir">
                    <?php $id = $precios['0']['Producto']['id']; ?>
                    <?php echo $this->Form->create(null, array('url' => array('controller' => 'Ventasdistribuidor', 'action' => 'registra_venta_mayor'), 'id' => 'formID')); ?>
                    <table class="simple-table responsive-table" style=" font-size: 16px;">
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

                    <table class="simple-table responsive-table"  style=" font-size: 17px;">
                        <?php foreach ($rows as $r): ?>
                          <tr>
                              <?php if ($r['0']['cantidad'] == 1): ?>
                                <?php $filas = 3; ?>
                              <?php else: ?>
                                <?php $filas = $r['0']['cantidad']; ?>
                              <?php endif; ?>
                              <td style="width: 30%;">
                                  <?php echo $r['Producto']['nombre']; ?>
                              </td>
                              <td style="width: 8%;">
                                  <table class="mitabla2" style="width:100%;">
                                      <tr>
                                          <td align="center">
                                              <b>Tiene</b>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td align="center" style="color: teal; font-weight: bold;">
                                              <?php echo $this->requestAction(array('action' => 'get_total',$r['Producto']['id'],0,$this->Session->read('Auth.User.persona_id')))?>
                                          </td>
                                      </tr>
                                  </table>
                              </td>
                              <td>
                                  <table class="mitabla2" style="width:100%;">
                                      <tr>
                                          <th>Precio</th>
                                          <th>Cantidad</th>
                                          <th>Total</th>
                                      </tr>

                                      <?php foreach ($precios as $p): ?>

                                        <?php
                                        if ($p['Productosprecio']['producto_id'] ==
                                          $r['Producto']['id']):
                                          ?>
                                          <tr>
                                              <?php
                                              echo $this->Form->
                                                hidden("Movimiento.$n.user_id", array('value' => $usu));
                                              ?>
                                              <?php
                                              echo $this->Form->
                                                hidden("Movimiento.$n.producto_id", array('value' => $p['Productosprecio']['producto_id']));
                                              ?>
                                              <?php echo $this->Form->hidden("Movimiento.$n.cliente_id", array('value' => $datoscli['Cliente']['id'])); ?>
                                              <?php echo $this->Form->hidden("Movimiento.$n.persona_id", array('value' => $this->Session->read('Auth.User.persona_id'))); ?>
                                              <?php echo $this->Form->hidden("Movimiento.$n.nombre_prod", array('value' => $r['Producto']['nombre'])) ?>
                                              <?php echo $this->Form->hidden("Movimiento.$n.escala", array('value' => 'MAYOR')) ?>
                                              <td  align="center">
                                                  <?php echo $this->Form->hidden("Movimiento.$n.precio_uni", array('value' => $p['Productosprecio']['precio'], "id" => "price_item_$n")); ?>
                                                  <?php $precio = $p['Productosprecio']['precio']; ?>
                                                  <?php echo "$" . $precio; ?>
                                              </td>
                                              <td align="center">
                                                  <?php
                                                  echo $this->Form->text("Movimiento.$n.salida", array(
                                                    //'value' => '0',
                                                    "id" => "qty_item_$n",
                                                    'class' => 'input full-width validate[custom[integer], min[0]]',
                                                    'size' => '6'));
                                                  ?>
                                              </td>
                                              <td align="center" id="total2_item_<?php echo $n; ?>">
                                                  0
                                              </td>
                                          </tr>
                                          <?php echo $this->Form->hidden("Movimiento.$n.total_p", array('id' => "total_item_$n"));
                                          ?>

                                          <script>
                                            function redondeo2decimales(numero)
                                            {
                                                var original = parseFloat(numero);
                                                var result = Math.round(original * 100) / 100;
                                                return result;
                                            }
                                            function suma() {
                                                var sumatotal = 0;
                                                $('input[id^="total_item_"]').each(function () {
                                                    sumatotal = sumatotal + Number(this.value);
                                                });

                                                //console.log('total general ' + sumatotal);
                                                $('#grandTotal').html(sumatotal);
                                            }

                                            $(document).ready(function () {
                                                $("input[type='text']").change(function () {
                                                    var subtotal = 0;
                                                    var producto = 0;
                                                    var a = $("input[id='price_item_<?php
                                    echo
                                    $n
                                    ?>']").val();
                                                    var b = $("input[id='qty_item_<?php
                                    echo
                                    $n
                                    ?>']").val();
                                                    console.log('precio ' + a);
                                                    console.log('cantidad' + b);
                                                    producto = Number(a * b);
                                                    console.log('el producto es' + producto);

                                                    subtotal = redondeo2decimales(producto);
                                                    $("#total_item_<?php
                                    echo
                                    $n;
                                    ?>").val(subtotal);
                                                    $("#total2_item_<?php
                                    echo
                                    $n;
                                    ?>").html(subtotal);
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
                        <?php endforeach; ?>
                    </table>


                    <table class="simple-table responsive-table" style=" font-size: 18px;">

                        <tr>
                            <th align="right" class="text">
                                <strong>Total ventas:</strong>
                            </th>

                            <th align="center" id="grandTotal">0</th>
                        </tr>


                    </table>

                    <br>
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <?php $opt = array('Value' => 'registrar venta', 'class' => "button green-gradient glossy huge full-width"); ?>    
                                <?php echo $this->Form->end($opt); ?>
                            </td>
                        </tr>
                    </table>
                    <!--
                    <table class="simple-table responsive-table">

                        <tr>
                            <th colspan="4" align="right" style="font-size: 20px;">
                                <strong>Total a cancelar:</strong>
                            </th>

                            <th align="center" id="total" style="font-size: 20px;">0</th>
                        </tr>


                    </table>-->



                </div>

            </div>

        </div>
    </div>

</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu -->
<script>
  $(document).ready(function () {

      $("#formID").validationEngine();

  });
</script>