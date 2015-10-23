<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Mis chips</h1>
    </hgroup>
    <div class="with-padding" align="">   
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Fecha</th>
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
                          <?php if ($ent['Chip']['pagado'] == 1): ?>
                          <span class="tag green-bg">Pagado</span>
                          <?php else:?>
                          <span class="tag orange-bg">No pagado</span>
                          <?php endif; ?>
                      </td>
                      <td>
                          <?php echo $this->Html->link('Detalle', array('action' => 'detalle_asignados', $ent['Chip']['fecha_entrega_d']), array('class' => 'tag blue-bg')); ?>
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

