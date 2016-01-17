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
        <?php echo $this->Form->create('Recargado'); ?>

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
            <div class="two-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Tipo</label>
                    <?php echo $this->Form->select('Dato.tipo', array(2 => 'Recarga', 1 => 'Carga', 3 => 'Recarga del Distribuidor'), array('class' => 'select full-width validate[required]', 'empty' => 'Seleccione el tipo de recarga')); ?>
                </p>
            </div>
            <div class="two-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Distribuidores</label>
                    <?php echo $this->Form->select('Dato.tipo', $distribuidores, array('class' => 'select full-width validate[required]', 'empty' => 'Seleccione el tipo de recarga')); ?>
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
                <td>Distribuidor</td>
                <td>Celular</td>
                <td>Tipo</td>
                <td>Ingreso</td>
                <td>Salida</td>
                <td>%</td>
                <td>Recarga</td>
            </tr>
            <?php $total_sal = $total_ing = $total_total = 0; ?>
            <?php foreach ($recargas as $rec): ?>
              <tr>
                  <td><?php echo $rec['Persona']['nombre'] . ' ' . $rec['Persona']['ap_paterno'] . ' ' . $rec['Persona']['ap_materno'] ?></td>
                  <td><?php echo $rec['Recargado']['num_celular'] ?></td>
                  <td><?php echo $tipos[$rec['Recargado']['tipo']] ?></td>
                  <td><?php echo $rec['Recargado']['entrada'] ?></td>
                  <td><?php echo $rec['Recargado']['salida'] ?></td>
                  <td><?php echo $rec['Porcentaje']['nombre'] ?></td>
                  <?php
                  $total_sal = $total_sal + $rec['Recargado']['salida'];
                  $total_ing = $total_ing + $rec['Recargado']['entrada'];
                  $total_total = $total_total + $rec['Recargado']['monto'];
                  ?>
                  <td><?php echo $rec['Recargado']['monto'] ?></td>
              </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td>TOTAL</td>
                <td><?php echo $total_ing; ?></td>
                <td><?php echo $total_sal; ?></td>
                <td></td>
                <td><?php echo $total_total; ?></td>
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