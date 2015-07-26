<!-- glDatePicker -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de usuarios</h1>
    </hgroup>

    <div class="with-padding">       

        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>C.I.</th>
                    <th>Distribuidor</th>
                    <th>Fecha</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($distribuidores as $dis): ?>
                  <tr>
                      <td><?php echo $dis['Persona']['ci'] ?></td>
                      <td><?php echo $dis['Persona']['nombre'] . ' ' . $dis['Persona']['ap_paterno'] . ' ' . $dis['Persona']['ap_materno'] ?></td>
                      <?php echo $this->Form->create('Venta', array('action' => 'registra_venta')); ?>
                      <?php echo $this->Form->hidden('persona_id',array('value' => $dis['Persona']['id']))?>
                      <td>
                          <span class="input">
                              <input type="text" name="data[Venta][fecha]" class="input-unstyled datepicker" value="<?php echo date('Y-m-d'); ?>" required="true">
                          </span>
                      </td>
                      <td><?php echo $this->Form->submit('Registrar', array('class' => 'button blue-gradient glossy full-width')); ?></td>
                      <?php echo $this->Form->end(); ?>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>	

<!-- Sidebar/drop-down menu -->

<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

<!-- End sidebar/drop-down menu --> 


<?php
echo $this->Html->script(array(
  'libs/glDatePicker/glDatePicker.min.js?v=1',
  'ini_lg_datepicker.js'
  ), array('block' => 'js_add'));
?>