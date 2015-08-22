<div id="main" class="contenedor">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>SIM'S DISPONIBLES</h1>
    </hgroup>
    <div class="with-padding">
        <h4><?php echo strtoupper($cliente['Cliente']['nombre']); ?></h4>
        <?php echo $this->Form->create(NULL, array('url' => array('controller' => 'Tiendas','action' => 'registra_asignado'))); ?>
        <?php echo $this->Form->hidden('Dato.cliente_id', array('value' => $idCliente)); ?>
        <div class="columns">
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Rang. Inicial</label>
                    <?php echo $this->Form->text('Dato.rango_ini', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Cantidad</label>
                    <?php echo $this->Form->text('Dato.cantidad', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">ASIGNAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <table class="table responsive-table" id="tabla-json">
            <thead>
                <tr>                      
                    <th style="width: 10%;">Id</th>
                    <th style="width: 10%;" class="hide-on-mobile">Cant.</th>
                    <th style="width: 20%;">SIM</th>
                    <th style="width: 15%;" class="hide-on-mobile">IMSI</th>
                    <th style="width: 15%;">Telefono</th>
                    <th style="width: 10%;" class="hide-on-mobile">Fecha</th>
                </tr>
            </thead>          

            <tbody>

            </tbody>
        </table> 
    </div>
</div>
<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => 'chips.json')); ?>';
  datos_tabla2 = {};
  datos_tabla2 = {
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
      }, "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
          $('td:eq(1)', nRow).addClass('hide-on-mobile');
          $('td:eq(3)', nRow).addClass('hide-on-mobile');
          $('td:eq(5)', nRow).addClass('hide-on-mobile');
      }
  };
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 