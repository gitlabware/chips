<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Detalle de <?php echo $excel['Excel']['nombre_original'] . ' en fecha ' . $excel['Excel']['created'] ?></h1>
    </hgroup>
    <div class="with-padding">       
        <?php echo $this->Form->create('Chip', array('action' => 'registra_caja')); ?>
        <div class="columns">
            <div class="new-row three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Caja</label>
                    <?php echo $this->Form->select('Dato.caja', $cajas, array('class' => 'full-width select')); ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Telefono Inicial</label>
                    <?php echo $this->Form->text('Dato.tel_ini', array('class' => 'full-width input', 'required')); ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Telefono Final</label>
                    <?php echo $this->Form->text('Dato.tel_fin', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Inicio Factura</label>
                    <?php echo $this->Form->text('Dato.ini_factura', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">REGISTRAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <table class="table responsive-table" id="tabla-json">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cantidad</th>
                    <th>Tipo SIM</th>
                    <th>SIM</th>
                    <th>IMSI</th>
                    <th>Num Telefono</th>
                    <th>N.Factura</th>
                    <th>Fecha</th>
                    <th>Caja</th>
                </tr>
            </thead>          
            <tbody>

            </tbody>
        </table>          
    </div>
</section>	

<!-- Sidebar/drop-down menu -->

<?php echo $this->element('sidebar/administrador'); ?>


<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => "verexcel/$idExcel.json")); ?>';

  datos_tabla2 = {
      /*"oLanguage": {
       "sUrl": "https://cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json"
       },*/
      'sPaginationType': 'full_numbers',
      'sDom': '<"dataTables_header"lfr>t<"dataTables_footer"ip>',
      'bProcessing': true,
      'sAjaxSource': urljsontabla,
      'sServerMethod': 'POST',
      "order": [],
      'fnInitComplete': function (oSettings)
      {
          // Style length select
          table2.closest('.dataTables_wrapper').find('.dataTables_length select').addClass('select blue-gradient glossy').styleSelect();
          tableStyled = true;
      }
  };
  
</script>