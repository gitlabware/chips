<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Entregas chip a distribuidor de <?php echo $excel['Excel']['nombre_original'] ?></h1>
    </hgroup>
    <div class="with-padding">                   
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Nro Chips</th>
                    <th>Monto total</th>
                    <th>Estado</th>
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
                          <?php
                          if (!empty($ent['Chip']['precio_d'])) {
                            echo $ent['Chip']['precio_d'] * $ent[0]['num_chips'];
                          } else {
                            echo $ent[0]['num_chips'] * $precio_chip['Precio']['monto'];
                          }
                          ?>
                      </td>
                      <td>
                          <?php if ($ent['Chip']['precio_d'] == 1): ?>
                          <?php echo $this->Html->link("Pagado",array('action' => 'cambia_nopagado',$excel['Excel']['id'], $ent['Chip']['fecha_entrega_d'], $ent['Chip']['distribuidor_id']),array('class' => 'button green-gradient glossy'))?>
                          <?php else:?>
                          <?php echo $this->Html->link("Pagar",array('action' => 'cambia_pagado',$excel['Excel']['id'], $ent['Chip']['fecha_entrega_d'], $ent['Chip']['distribuidor_id']),array('class' => 'button orange-gradient glossy'))?>
                          <?php endif; ?>
                      </td>
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

