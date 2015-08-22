<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<div id="main" class="contenedor">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>REPORTE DE CHIP'S CLIENTES</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create(NULL, array('url' => array('controller' => 'Reportes', 'action' => 'reporte_chips_clientes'))); ?>

        <div class="columns ocultar_impresion">
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Fecha Inicial</label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <?php echo $this->Form->text('Dato.fecha_ini', array('class' => 'input-unstyled datepicker')); ?>
                    </span>
                </p>
            </div>
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
                    <label for="block-label-1" class="label">Estado</label>
                    <?php echo $this->Form->select("Dato.activado", array(1 => 'Activado', 0 => 'No activado'), array('class' => 'select full-width full-width')) ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Distribuidor</label>
                    <?php echo $this->Form->select("Dato.distribuidor_id", $distribuidores, array('class' => 'select full-width full-width')) ?>
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
                    <th>Cant.</th>
                    <th>TipoSim</th>
                    <th>SIM</th>
                    <th>IMSI</th>
                    <th>Telefono</th>
                    <th>Fecha</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Zona</th>
                    <th>Estado</th>
                    <th>Dealer</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($datos as $da): ?>
                  <tr>
                      <td><?php echo $da['Chip']['cantidad'] ?></td>
                      <td><?php echo $da['Chip']['tipo_sim'] ?></td>
                      <td><?php echo $da['Chip']['sim'] ?></td>
                      <td><?php echo $da['Chip']['imsi'] ?></td>
                      <td><?php echo $da['Chip']['telefono'] ?></td>
                      <td><?php echo $da['Chip']['fecha'] ?></td>
                      <td><?php echo $da['Cliente']['num_registro'] ?></td>
                      <td><?php echo $da['Cliente']['nombre'] ?></td>
                      <td><?php echo $da['Cliente']['zona'] ?></td>
                      <td><?php echo $da['Chip']['distribuidor'] ?></td>
                      <td><?php echo $da['Chip']['lugar_dis'] ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    </div>
</div>

<?php
echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add'))
?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 