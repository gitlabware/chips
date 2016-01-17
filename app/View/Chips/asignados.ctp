<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Ultimas Entregas chip a distribuidor</h1>
    </hgroup>
    <div class="with-padding">                   
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Nro Chips</th>
                    <th>Acciones</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($entregados as $ent): ?>
                  <tr>
                      <td><?php echo $ent['Chip']['fecha_entrega_d'] ?></td>
                      <td><?php echo $ent['Chip']['nombre_dist'] ?></td>
                      <td><?php echo $ent[0]['num_chips'] ?></td>
                      <td>
                          <?php echo $this->Html->link('Detalle', array('action' => 'detalle_entrega', $ent['Chip']['fecha_entrega_d'], $ent['Chip']['distribuidor_id']), array('class' => 'tag blue-bg')); ?>
                          <?php //echo $this->Html->link('Descargar Excel', array('action' => 'genera_excel_1', $ent['Chip']['fecha_entrega_d'], $ent['Chip']['distribuidor_id']), array('class' => 'tag green-bg')); ?>
                          <?php echo $this->Html->link('Detalle excel', array('action' => 'excel', $ent['Chip']['fecha_entrega_d'], $ent['Chip']['distribuidor_id']), array('class' => 'tag green-bg')); ?>
                          <a href="javascript:" class="tag red-bg" onclick="cancelar('<?php echo $this->Html->url(array('controller' => 'Chips', 'action' => 'cancela_entrega', $ent['Chip']['fecha_entrega_d'], $ent['Chip']['distribuidor_id'])); ?>');">Cancelar</a>
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
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

