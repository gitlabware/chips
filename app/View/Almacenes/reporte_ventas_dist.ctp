<style>
    @media print{
        .ocultar_impresion{
            display: none !important; 
        }
    }
    .CSSTableGenerator {
        margin:0px;padding:0px;
        width:100%;
        border:1px solid #000000;

        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;

        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;

        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;

        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }.CSSTableGenerator table{
        border-collapse: collapse;
        border-spacing: 0;
        width:100%;
        height:100%;
        margin:0px;padding:0px;
    }.CSSTableGenerator tr:last-child td:last-child {
        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:first-child {
        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:last-child {
        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;
    }.CSSTableGenerator tr:last-child td:first-child{
        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;
    }.CSSTableGenerator tr:hover td{
        background-color:#ffffff;


    }
    .CSSTableGenerator td{
        vertical-align:middle;

        background-color:#ffffff;

        border:1px solid #000000;
        border-width:0px 1px 1px 0px;
        padding:5px;
        font-size:10px;
        font-family:Arial;
        font-weight:bold;
        color:#000000;
    }.CSSTableGenerator tr:last-child td{
        border-width:0px 1px 0px 0px;
    }.CSSTableGenerator tr td:last-child{
        border-width:0px 0px 1px 0px;
    }.CSSTableGenerator tr:last-child td:last-child{
        border-width:0px 0px 0px 0px;
    }
</style>
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<div id="main" class="contenedor">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>REPORTE DE DISTRIBUIDORES</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Almacene', array()); ?>

        <div class="columns ocultar_impresion">
            <div class="three-columns twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Inicial</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_ini', array('class' => 'input-unstyled datepicker', 'value' => date('Y-m-d'))); ?>
                    </span>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Final</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_fin', array('class' => 'input-unstyled datepicker', 'value' => date('Y-m-d'))); ?>
                    </span>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label class="label">Distribuidor</label>
                    <?php echo $this->Form->select('Dato.persona_id', $personas, array('class' => 'select full-width', 'required')) ?>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit"> GENERAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>


        <?php if (!empty($this->request->data['Dato']['persona_id'])): ?>       

          <table class="CSSTableGenerator">
              <tr>
                  <td style="width: 40%;">
                      FECHA: 
                      <?php
                      if ($this->request->data['Dato']['fecha_ini'] == $this->request->data['Dato']['fecha_fin']) {
                        echo $this->request->data['Dato']['fecha_ini'];
                      } else {
                        echo 'DE ' . $this->request->data['Dato']['fecha_ini'] . ' A ' . $this->request->data['Dato']['fecha_fin'];
                      }
                      ?>
                  </td>
                  <td style="width: 60%;">
                      DISTRIBUIDOR: <?php echo $distribuidor['Persona']['nombre'] . ' ' . $distribuidor['Persona']['ap_paterno'] . ' ' . $distribuidor['Persona']['ap_materno'] ?>
                  </td>
              </tr>
          </table><br>
          <table class="CSSTableGenerator">
              <tbody>
                  <tr>
                      <td style="text-align: center;">Producto</td>
                      <td style="text-align: center;">Saldo Anterior</td>
                      <td style="text-align: center;">Ingreso</td>
                      <td style="width: 35%; text-align: center;">Ventas</td>
                      <td style="text-align: center;">Bs.</td>
                      <td style="text-align: center;">Saldo Actual</td>
                  </tr>


                  <?php $total_bs = 0.00; ?>
                  <?php foreach ($productos as $pro): ?>
                    <?php
                    $venta_total = 0.00;
                    $venta_prec_total = 0.00;
                    $entregado = 0;
                    $datos = $this->requestAction(array('action' => 'get_ventas_dist', $fecha_ini, $fecha_fin, $persona, $pro['Producto']['id']));
                    $datos2 = $this->requestAction(array('action' => 'get_precios_prod', $fecha_ini, $fecha_fin, $persona, $pro['Producto']['id']));
                    if (!empty($datos)) {
                      $da = $datos[0];
                      foreach ($datos2 as $dato) {
                        $venta_total = $venta_total + $dato[0]['vendidos'];
                        $venta_prec_total = $venta_prec_total + $dato[0]['precio_total'];
                      }
                      $saldo = $pro['Productosprecio']['total_s'] - $da[0]['entregado'] + $venta_total;

                      $entregado = $da[0]['entregado'];
                    } else {
                      $da = NULL;
                      $saldo = $pro['Productosprecio']['total_s'];
                    }
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $pro['Producto']['nombre']; ?></td>

                        <td style="text-align: center;"><?php echo $saldo ?></td>
                        <td style="text-align: center;"><?php echo $entregado ?></td>
                        <td>
                            <table style="width: 100%;">
                                <?php foreach ($datos2 as $dato): ?>
                                  <tr>
                                      <td> <?php echo $dato['Productosprecio']['precio'] ?> Bs. </td>
                                      <td> <?php echo $dato[0]['vendidos'] ?> vendidos</td>
                                      <td> <?php echo $dato[0]['precio_total'] ?> Bs</td>
                                  </tr>

                                <?php endforeach; ?>
                            </table>
                        </td>
                        <?php
                        $total_bs = $total_bs + $venta_prec_total;
                        ?>
                        <td style="text-align: center;"><?php echo $venta_prec_total ?></td>
                        <td style="text-align: center;"><?php echo $pro['Productosprecio']['total_s'] ?></td>

                    </tr>
                  <?php endforeach; ?>
                  <?php $total_recarga = 0.00; ?>

                  <?php
                  $chips_r = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_num_chips_dist', $fecha_ini, $fecha_fin, $distribuidor['User']['id']));
                  $c_ingresos = 0;
                  $c_total_s = 0;
                  $c_vendidos = 0;
                  if (!empty($chips_r)) {
                    $c_ingresos = $chips_r[0]['Chip']['ingresado'];
                    $c_vendidos = $chips_r[0]['Chip']['vendidos_t'];
                    $c_total_s = $chips_r[0][0]['total_S'];
                  }
                  $precios_c = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_precios_ven'));
                  ?>
                  <tr>
                      <td style="text-align: center;">Chips</td>

                      <td style="text-align: center;"><?php echo $c_total_s - $c_vendidos - $c_ingresos ?></td>
                      <td style="text-align: center;"><?php echo $c_ingresos ?></td>
                      <td style="text-align: center;">
                          <table style="width: 100%">
                              <?php
                              $num_chips_p_t = 0.00;
                              foreach ($precios_c as $preci):
                                ?>
                                <tr>

                                    <td style="text-align: center;"><?php echo $preci['Precio']['monto'] . ' Bs.' ?></td>
                                    <?php
                                    $num_chips = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_num_vent_d', $fecha_ini, $fecha_fin, $distribuidor['User']['id'], $preci['Precio']['monto']));
                                    $num_chips_p_t = $num_chips_p_t + ($num_chips * $preci['Precio']['monto']);
                                    ?>
                                    <td style="text-align: center;"><?php echo $num_chips ?></td>
                                </tr>
                              <?php endforeach; ?>

                          </table>
                      </td>
                      <td style="text-align: center;"><?php echo $num_chips_p_t; ?></td>
                      <td style="text-align: center;"><?php echo $c_total_s - $c_vendidos ?></td>

                      <?php $total_bs = $total_bs + $num_chips_p_t; ?>
                  </tr>
                  <tr>
                      <td style="text-align: center;">Recarga</td>
                      <td></td>
                      <td></td>
                      <td>
                          <table style="width: 100%;">
                              <tr>
                                  <td style="width: 50%; text-align: center;">
                                      OFICINA
                                      <table style="width: 100%;">
                                          <?php foreach ($porcentajes as $por): ?>
                                            <tr>

                                                <td><?php echo $por['Porcentaje']['nombre'] . '%' ?></td>
                                                <?php $total_recarga = $total_recarga + $rec_por = $this->requestAction(array('controller' => 'Recargados', 'action' => 'get_recargas_dist', $fecha_ini, $fecha_fin, $persona, $por['Porcentaje']['id'], '2')) ?>
                                                <td><?php echo $rec_por ?> Bs</td>

                                            </tr>
                                          <?php endforeach; ?>
                                      </table>
                                  </td>
                                  <td style="width: 50%; text-align: center;">
                                      DISTRIBUIDOR
                                      <table style="width: 100%;">
                                          <?php foreach ($porcentajes as $por): ?>
                                            <tr>

                                                <td><?php echo $por['Porcentaje']['nombre'] . '%' ?></td>
                                                <?php $total_recarga = $total_recarga + $rec_por = $this->requestAction(array('controller' => 'Recargados', 'action' => 'get_recargas_dist', $fecha_ini, $fecha_fin, $persona, $por['Porcentaje']['id'], '3')) ?>
                                                <td><?php echo $rec_por ?> Bs</td>

                                            </tr>
                                          <?php endforeach; ?>
                                      </table>
                                  </td>
                              </tr>
                          </table>
                      </td>
                      <td style="text-align: center;">
                          TOTAL<br><br>
                          <?php echo $total_recarga ?>
                      </td>
                      <td></td>
                  </tr>
                  <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>TOTAL</td>
                      <td style="text-align: center;"><?php echo $total_bs + $total_recarga ?></td>
                      <td></td>
                  </tr>
              </tbody>
          </table>
          <?php $pagos = $this->requestAction(array('controller' => 'Cajachicas', 'action' => 'get_pagos_dist', $fecha_ini, $fecha_fin, $distribuidor['User']['id'])) ?>

          <?php if (!empty($pagos)): ?>
            <br>
            <br>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 40%;">
                        <table class="CSSTableGenerator" style="width: 100%;">
                            <tr>
                                <td><b>TOTAL VENTAS</b></td>
                                <td><?php echo $total_bs + $total_recarga ?> Bs</td>
                            </tr>
                            <?php foreach ($pagos['bancos'] as $ba): ?>
                              <tr>
                                  <td><?php echo $ba['nombre'] ?> Bs</td>
                                  <td><?php echo $ba['monto'] ?> Bs</td>
                              </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>FALTANTE</td>
                                <td><?php echo $pagos['faltante'] ?> Bs</td>
                            </tr>
                            <tr>
                                <td>OTROS INGRESOS</td>
                                <td><?php echo $pagos['otro_ingreso'] ?> Bs</td>
                            </tr>
                            <tr>
                                <td>OBSERVACIONES</td>
                                <td><?php echo $pagos['observaciones'] ?></td>
                            </tr>
                            <tr>
                                <td>TOTAL</td>
                                <td><?php echo $total_bs + $total_recarga + $pagos['otro_ingreso'] ?> Bs</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 60%;">
                        <table style="width: 100%; color: black;">
                            <tr style="height: 10px;">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width: 40%; padding-left: 20px; padding-right: 20px; padding-top: 30px;">
                                    <div style="text-align: center; border-top: 1px solid #000000;">
                                        Entregue conforme<br>
                                        <span contentEditable="true">CI: </span>
                                    </div>
                                </td>
                                <td style="width: 20%;text-align: center;">
                                    INGRESOS
                                </td>
                                <td style="width: 40%; padding-left: 20px; padding-right: 20px; padding-top: 30px;">
                                    <div style="text-align: center; border-top: 1px solid #000000;">
                                        Recibi conforme<br>
                                        <span contentEditable="true">CI: <?php echo $distribuidor['Persona']['ci'] ?></span>
                                    </div>
                                </td>
                            </tr>
                            <tr style="height: 40px;">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width: 40%; padding-left: 20px; padding-right: 20px; padding-top: 30px;">
                                    <div style="text-align: center; border-top: 1px solid #000000;">
                                        Entregue conforme<br>
                                        <span contentEditable="true">CI: <?php echo $distribuidor['Persona']['ci'] ?></span>
                                    </div>
                                </td>
                                <td style="width: 20%;text-align: center;">
                                    VENTAS
                                </td>
                                <td style="width: 40%; padding-left: 20px; padding-right: 20px; padding-top: 30px;">
                                    <div style="text-align: center; border-top: 1px solid #000000;">
                                        Recibi conforme<br>
                                        <span contentEditable="true">CI: </span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


          <?php endif; ?>



        <?php endif; ?>


        <div class="columns ocultar_impresion">
            <div class="twelve-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button black-gradient full-width" type="button" onclick="window.print();"> IMPRIMIR</button>
                </p>
            </div>
        </div>


    </div>
</div>

<?php
echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add'))
?>

<!-- Sidebar/drop-down menu -->
<?php //echo $this->element('sidebar/administrador'); ?>
<?php //echo $this->element('sidebar/administrador'); ?>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
<!-- End sidebar/drop-down menu --> 