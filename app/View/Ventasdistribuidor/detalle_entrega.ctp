<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <div class="with-padding"> 
        <h4 class="green underline">Entregas a <?php echo $cliente['Cliente']['nombre'] ?> de <?php echo $fecha; ?></h4>
        <?php echo $this->Form->create('Ventasdistribuidor', array('url' => array('controller' => 'Ventasdistribuidor', 'action' => 'cancela_asignado'))); ?>
        <div class="columns">
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Rang. Inicial</label>
                    <?php echo $this->Form->hidden("Dato.fecha", array('value' => $fecha)); ?>
                    <?php echo $this->Form->hidden("Dato.distribuidor_id", array('value' => $idDistribuidor)); ?>
                    <?php echo $this->Form->text('Dato.rango_ini', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Cantidad</label>
                    <?php echo $this->Form->text('Dato.cantidad', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="four-columns-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">CANCELAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Sim</th>
                    <th>Imsi</th>
                    <th>Telefono</th>
                    <th>Accion</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($entregados as $ent): ?>
                  <tr>
                      <td><?php echo $ent['Chip']['id'] ?></td>
                      <td><?php echo $ent['Chip']['cantidad'] ?></td>
                      <td><?php echo $ent['Chip']['tipo_sim'] ?></td>
                      <td><?php echo $ent['Chip']['sim'] ?></td>
                      <td><?php echo $ent['Chip']['imsi'] ?></td>
                      <td><?php echo $ent['Chip']['telefono'] ?></td>
                      <td>
                          <a href="javascript:"  class="button red-gradient icon-forbidden" title="Cancelar Asignacion" onclick="cancelar('<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'cancela_entrega_id', $ent['Chip']['id'])); ?>');"></a>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>	

<script>
  function cancelar(url) {
      if (confirm("Esta seguro de cancelar la entrega??")) {
          window.location = url;
      }
  }
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 

