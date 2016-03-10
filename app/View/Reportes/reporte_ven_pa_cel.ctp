<style>
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
        <h1>CONTROL DE VENTAS </h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create(NULL, array('url' => array('controller' => 'Reportes', 'action' => 'reporte_ven_pa_cel'))); ?>
        <div class="columns ocultar_impresion">
            <div class="three-columns twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Inicial</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_ini', array('class' => 'input-unstyled datepicker')); ?>
                    </span>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Final</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_fin', array('class' => 'input-unstyled datepicker')); ?>
                    </span>
                </p>
            </div>
            <div class="two-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Sucursal</label>
                    <span class="input">
                        <?php echo $this->Form->select('Dato.sucursal',$sucursales,array('class' => 'select','required'));?>
                    </span>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">GENERAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <h2 align="center">CONTROL VENTAS DE PRODUCTOS</h2>
        <table class="CSSTableGenerator" >
            <tr>
                <td>Producto</td>
                <td>Inicial</td>
                <td>Adic.</td>
                <td>Total</td>
                <td>Saldos</td>
                <td>Vendidos</td>
                <td>Total (Bs)</td>
            </tr>
            <?php $total_v = 0.00; ?>
            <?php foreach ($datos as $da): ?>
              <?php $total_v +=$da['Totale']['precio_v_t']; ?>
              <tr>
                  <td><?php echo $da['Producto']['nombre'] ?></td>
                  <td><?php echo $da['Totale']['total_s'] - $da['Totale']['entregado'] + $da['Totale']['ventas'] + $da['Totale']['ventas_mayor'] ?></td>
                  <td><?php echo $da['Totale']['entregado'] ?></td>
                  <td><?= ($da['Totale']['total_s'] + $da['Totale']['ventas'] + $da['Totale']['ventas_mayor']) ?></td>
                  <td><?php echo $da['Totale']['total_s'] ?></td>
                  <td><?php echo $da['Totale']['ventas'] ?></td>
                  <td><?php echo $da['Totale']['precio_v_t'] ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $total_v ?></td>
            </tr>
        </table> 
        <br>
        <h2 align="center">CONTROL VENTAS DE EQUIPOS</h2>
        <table class="CSSTableGenerator">
            <tr>
                <td>Cliente</td>
                <td>Marca</td>
                <td>Modelo</td>
                <td>c/Voucher</td>
                <td>c/Ticket</td>
                <td>Efectivo</td>
                <td>c/T de credito</td>
            </tr>
            <?php
            $t_coucher = 0.00;
            $t_ticket = 0.00;
            $t_efectivo = 0.00;
            $t_tarjeta = 0.00;
            ?>
            <?php foreach ($datos_array as $pc): ?>
              <?php
              $t_voucher = $t_voucher + $pc['Ventascelulare']['voucher'];
              $t_ticket = $t_ticket + $pc['Ventascelulare']['ticket'];
              $t_efectivo = $t_efectivo + $pc['Ventascelulare']['efectivo'];
              $t_tarjeta = $t_tarjeta + $pc['Ventascelulare']['tarjeta'];
              ?>
              <tr>
                  <td><?= $pc['Ventascelulare']['cliente']; ?></td>
                  <td><?= $pc['Ventascelulare']['prod_marca'] ?></td>
                  <td><?= $pc['Producto']['nombre'] ?></td>
                  <td><?= $pc['Ventascelulare']['voucher'] ?></td>
                  <td><?= $pc['Ventascelulare']['ticket'] ?></td>
                  <td><?= $pc['Ventascelulare']['efectivo'] ?></td>
                  <td><?= $pc['Ventascelulare']['tarjeta'] ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $t_voucher ?></td>
                <td><?= $t_ticket ?></td>
                <td><?= $t_efectivo ?></td>
                <td><?= $t_tarjeta ?></td>
            </tr>
        </table><br>
        <table style="width: 100%;">
            <tr>
                <td style="width: 43%;">
                    <table class="CSSTableGenerator">
                        <tr>
                            <td></td>
                            <td>Caja Inicial</td>
                            <td></td>
                            <td><?= $inicial_c ?></td>
                        </tr>
                        <?php foreach ($cmovimientos as $mo): ?>
                          <tr>
                              <td><?= $mo['Cajachica']['fecha'] ?></td>
                              <td><?= $mo['Cajadetalle']['nombre'] ?></td>
                              <td><?= $mo['Cajachica']['tipo'] ?></td>
                              <td><?= $mo['Cajachica']['monto'] ?></td>
                          </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td></td>
                            <td>Total Ingresos</td>
                            <td></td>
                            <td><?= $ingresos_m ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Total Egresos</td>
                            <td></td>
                            <td><?= $salidas_m ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Total Ventas</td>
                            <td></td>
                            <td><?= $total_v + $t_efectivo ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Efectivo En Caja</td>
                            <td></td>
                            <td><?= $total_a_m ?></td>
                        </tr>
                    </table>
                </td>
                <td style="width: 4%;"></td>
                <td style="width: 43%;">
                    <table class="CSSTableGenerator">
                        <tr>
                            <td>Bolivianos</td>
                            <td>
                                <?php
                                if ($total_dolares_b <= $total_a_m) {
                                  echo $total_a_m - $total_dolares_b;
                                }else{
                                  echo $total_a_m;
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Dolares</td>
                            <td>
                                <?php
                                if ($total_dolares_b <= $total_a_m) {
                                  echo $total_dolares;
                                } else {
                                  echo 0.00;
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php
echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add'))
?>

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 
