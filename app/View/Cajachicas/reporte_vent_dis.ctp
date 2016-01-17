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
<?php $tipos = array(2 => 'Recarga', 1 => 'Carga', 3 => 'Recarga del Distribuidor'); ?>
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<div id="main" class="contenedor">
    <hgroup id="main-title" class="thin">
        <h1>REPORTE DE RECARGAS</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Cajachica'); ?>

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
                    <label for="block-label-1" class="label">Distribuidores</label>
                    <?php echo $this->Form->select('Dato.distribuidor_id', $distribuidores, array('class' => 'select full-width validate[required]', 'empty' => 'Seleccione el tipo de recarga')); ?>
                </p>
            </div>
            <div class="two-columns new-row-mobile twelve-columns-mobile">
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
                <td>Fecha</td>
                <td>Distribuidor</td>
                <td>Ingresos</td>
                <td>Faltantes</td>
                <td>Otros Ingresos</td>
                <td>Observaciones</td>
            </tr>
            <?php $total_fal = $total_o_ing = $total_ing = 0; ?>
            <?php foreach ($pagosdis as $pa): ?>
              <tr>
                  <td><?php echo $pa['Distribuidorpago']['fecha'] ?></td>
                  <td><?php echo $pa['Distribuidorpago']['nombre_dis'] ?></td>
                  <?php
                  $cajachicas = $this->requestAction(array('action' => 'get_caja_dis', $pa['Distribuidorpago']['id']));
                  ?>
                  <td>
                      <table style="width: 100%;">
                          <?php foreach ($cajachicas as $ca): ?>
                            <tr>
                                <td><?php echo $ca['Banco']['nombre'] ?></td>
                                <td><?php echo $ca['Cajachica']['monto'] ?></td>
                            </tr>
                          <?php endforeach; ?>
                      </table>
                  </td>
                  <td><?php echo $pa['Distribuidorpago']['faltante'] ?></td>
                  <td><?php echo $pa['Distribuidorpago']['otro_ingreso'] ?></td>
                  <td><?php echo $pa['Distribuidorpago']['observaciones'] ?></td>
              </tr>
              <?php
              $total_fal = $total_fal + $pa['Distribuidorpago']['faltante'];
              $total_o_ing = $total_o_ing + $pa['Distribuidorpago']['otro_ingreso'];
              ?>
            <?php endforeach; ?>
              <?php 
              $cajas = $this->requestAction(array('action' => 'get_caja_d_t',$this->request->data['Dato']['fecha_ini'],$this->request->data['Dato']['fecha_fin'],$this->request->data['Dato']['distribuidor_id']));
              ?>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <table style="width: 100%;">
                        <?php foreach ($cajas as $ca): ?>
                          <tr>
                              <td><?php echo $ca['Banco']['nombre'] ?></td>
                              <td><?php echo $ca[0]['monto_total'] ?></td>
                          </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
                <td><?php echo $total_fal; ?></td>
                <td><?php echo $total_o_ing; ?></td>
                <td></td>
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