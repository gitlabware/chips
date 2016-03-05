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
        <h1>REPORTE DE CHIP'S CLIENTES</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Reporte'); ?>

        <div class="columns ocultar_impresion">
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Final</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_fin', array('class' => 'input-unstyled datepicker')); ?>
                    </span>
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
                    <th colspan="8">
                        <?php echo "Dias de lunes a sabado en el mes " . $meses[$mes] . " de $ano : $dias_lab"; ?>
                    </th>
                </tr>
                <tr>
                    <th>Inspector</th>
                    <th>Mercado</th>
                    <th>Ventas</th>
                    <th>Meta</th>
                    <th>Cumplimiento</th>
                    <th>Restante</th>
                    <th>Comercial</th>
                    <th>No comercial</th>
                </tr>
            </thead>          
            <tbody>
                <?php
                $to_ventas = 0;
                $to_metas = 0;
                $to_comercial = 0;
                ?>
                <?php foreach ($metas as $me): ?>
                  <?php
                  $to_ventas = $to_ventas + $me['Meta']['ventas'];
                  $to_metas = $to_metas + $me['Meta']['meta'];
                  $to_comercial = $to_comercial + $me['Meta']['comercial'];
                  ?>
                  <tr>
                      <td><?php echo $me['Meta']['inspector'] ?></td>
                      <td><?php echo $me['Ruta']['cod_ruta'] . '-' . $me['Ruta']['nombre'] ?></td>
                      <td><?php echo $me['Meta']['ventas'] ?></td>
                      <td><?php echo $me['Meta']['meta'] ?></td>
                      <td><?php echo round(($me['Meta']['ventas'] / $me['Meta']['meta']) * 100, 2) . ' %' ?></td>
                      <td><?php echo $me['Meta']['meta'] - $me['Meta']['ventas'] ?></td>
                      <td><?php echo $me['Meta']['comercial'] ?></td>
                      <td><?php echo $me['Meta']['ventas'] - $me['Meta']['comercial'] ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL</td>
                    <td><?php echo $to_ventas; ?></td>
                    <td><?php echo $to_metas; ?></td>
                    <td>
                        <?php
                        if ($to_metas != 0) {
                          echo round(($to_ventas / $to_metas) * 100, 2) . ' %';
                        } else {
                          echo '0 %';
                        }
                        ?>
                    </td>
                    <td><?php echo $to_metas - $to_ventas ?></td>
                    <td><?php echo $to_comercial ?></td>
                    <td><?php echo $to_ventas - $to_comercial ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="columns">
            <div class="new-row twelve-columns">
                <?php if (!empty($this->request->data['Dato']['fecha_fin'])): ?>
                  <?php echo $this->Html->link("Excel", array('controller' => 'Reportes', 'action' => 'gen_exc_chips_metas', $this->request->data['Dato']['fecha_fin'])) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add'))
?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 