<?php
$meses = array(
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Sepetiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Disciembre'
);
?>
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<div id="main" class="contenedor">
    <hgroup id="main-title" class="thin">
        <h1>REPORTE DE CHIP'S POR MERCADO</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Reporte'); ?>

        <div class="columns ocultar_impresion">
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Inicial</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_ini', array('class' => 'input-unstyled datepicker','required')); ?>
                    </span>
                </p>
            </div>
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Final</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_fin', array('class' => 'input-unstyled datepicker','required')); ?>
                    </span>
                </p>
            </div>
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Mercado</label>
                    <?php echo $this->Form->select('Dato.cod_ruta', $mercados, array('class' => 'select','requied')); ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">GENERAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <table class="table responsive-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Entregado</th>
                    <th>Activados</th>
                    <th>Comerciales</th>
                    <th>No Comerciales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $entregados = 0;
                $activados = 0;
                $comerciales = 0;
                ?>
                <?php foreach ($datos as $da): ?>
                  <?php
                  $entregados = $entregados + $da['Cliente']['entregados'];
                  $activados = $activados + $da['Cliente']['activados'];
                  $comerciales = $comerciales + $da['Cliente']['comerciales'];
                  ?>
                  <tr>
                      <td><?php echo $da['Cliente']['nombre'] ?></td>
                      <td><?php echo $da['Cliente']['entregados'] ?></td>
                      <td><?php echo $da['Cliente']['activados'] ?></td>
                      <td><?php echo $da['Cliente']['comerciales'] ?></td>
                      <td><?php echo $da['Cliente']['activados'] - $da['Cliente']['comerciales'] ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td><?php echo $entregados; ?></td>
                    <td><?php echo $activados; ?></td>
                    <td><?php echo $comerciales; ?></td>
                    <td><?php echo $activados - $comerciales; ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php
echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add'))
?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 