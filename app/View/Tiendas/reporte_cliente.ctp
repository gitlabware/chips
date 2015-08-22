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
        <h1>REPORTE DE TIENDA <?php echo strtoupper($this->Session->read('Auth.User.Sucursal.nombre')); ?></h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create(NULL, array('url' => array('controller' => 'Tiendas', 'action' => 'reporte_cliente'))); ?>

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
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">GENERAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <table class="CSSTableGenerator" >
            <tr>
                <td>Cod cliente</td>
                <td>Cliente</td>
                <td>Por Productos</td>
                <td>Venta Total</td>
                <td>Precio Total (Bs)</td>
            </tr>
            <?php foreach ($datos as $da): ?>
              <?php
              $venta_total = 0;
              $venta_prec_total = 0;
              ?>
              <tr>
                  <td><?php echo $da['Cliente']['num_registro'] ?></td>
                  <td><?php echo $da['Cliente']['nombre'] ?></td>
                  <td>
                      <table>
                          <?php foreach ($da['productos'] as $dat): ?>
                            <tr>
                                <td><?php echo $dat['Producto']['nombre'];?></td>
                                <td><?php echo $dat['Movimiento']['precio_uni']?></td>
                                <td><?php echo $dat[0]['vendidos']?></td>
                                <td><?php echo $dat[0]['precio_total']?></td>
                            </tr>
                            <?php $venta_total = $venta_total + $dat[0]['vendidos'];?>
                            <?php $venta_prec_total = $venta_prec_total + $dat[0]['precio_total'];?>
                          <?php endforeach; ?>
                      </table>
                  </td>
                  <td><?php echo $venta_total;?></td>
                  <td><?php echo $venta_prec_total;?></td>
              </tr>
            <?php endforeach; ?>
        </table> 
    </div>
</div>

<?php
echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add'))
?>

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 