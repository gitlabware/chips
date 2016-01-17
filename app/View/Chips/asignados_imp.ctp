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
                    <label class="label">Impulsador</label>
                    <?php echo $this->Form->select('Dato.distribuidor_id', $distribuidores, array('class' => 'select full-width', 'required')) ?>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label class="label">Tipo</label>
                    <?php echo $this->Form->select('Dato.tipo', array('VENDIDOS' => 'VENDIDOS','NO VENDIDOS' => 'NO VENDIDOS'), array('class' => 'select full-width','empty' => 'TODOS')) ?>
                </p>
            </div>
            <div class="twelve-columns new-row">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit"> GENERAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>


        <?php if (!empty($this->request->data['Dato'])): ?>       
          <table style="width: 100%;">
              <tr>
                  <td>
                      <table class="CSSTableGenerator">
                          <tr>
                              <td colspan="3" style="text-align: center;">
                                  CONTROL DE VENTAS (MINIEVENTOS) SANCHEZ ALVAVREZ S.R.L.
                              </td>
                          </tr>
                          <tr>
                              <td>IMPULSADOR: <?php echo $distribuidor['Persona']['nombre'] . ' ' . $distribuidor['Persona']['ap_paterno'] . ' ' . $distribuidor['Persona']['ap_materno'] ?></td>
                              <td>DIA: </td>
                              <td rowspan="2" style="width: 18%;">
                                  
                              </td>
                          </tr>
                          <tr>
                              <td>LUGAR DEL EVENTO: </td>
                              <td>FECHA: 
                                  <?php
                                  if ($this->request->data['Dato']['fecha_ini'] == $this->request->data['Dato']['fecha_fin']) {
                                    echo $this->request->data['Dato']['fecha_ini'];
                                  } else {
                                    echo 'DE ' . $this->request->data['Dato']['fecha_ini'] . ' A ' . $this->request->data['Dato']['fecha_fin'];
                                  }
                                  ?>
                              </td>
                          </tr>
                          <tr>
                              <td>SUPERVISOR: </td>
                              <td>CODIGO: </td>
                              <td style="text-align: center;">FIRMA REVISOR</td>
                          </tr>
                      </table>
                  </td>
              </tr>
          </table>


          <table class="CSSTableGenerator">
              <tr>
                  <td></td>
                  <td>La PAZ</td>
                  <td></td>
                  <td>EL ALTO</td>
                  <td></td>
                  <td></td>
              </tr>
              <tr>
                  <td>No</td>
                  <td>Numero</td>
                  <td>Nombre Cliente</td>
                  <td>Monto</td>
                  <td>Regalo</td>
                  <td>Referencia</td>
              </tr>
              <?php foreach ($chips as $key => $ch): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $ch['Chip']['telefono'] ?></td>
                    <td><?php echo $ch['Chip']['cliente'] ?></td>
                    <td><?php echo $ch['Chip']['precio_chip'] ?></td>
                    <td><?php echo $ch['Chip']['regalo'] ?></td>
                    <td><?php echo $ch['Chip']['referencia'] ?></td>
                </tr>
              <?php endforeach; ?>
          </table>


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