<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <div class="with-padding">       
        <h4 class="green underline">Ultimas Entregas Chip</h4>
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th style="min-width: 70px;">Fecha</th>
                    <th>Cod.Cli</th>
                    <th style="min-width: 250px;">Cliente</th>
                    <th>#Chips</th>
                    <th>Monto.total</th>
                    <th style="min-width: 80px;">Estado</th>
                    <th style="min-width: 70px;">Acciones</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($entregados as $ent): ?>
                  <tr>
                      <td><?php echo $ent['Chip']['fecha_entrega_c'] ?></td>
                      <td><?php echo $ent['Cliente']['num_registro'] ?></td>
                      <td><?php echo $ent['Cliente']['nombre'] ?></td>
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
                          <?php else: ?>
                          <span class="tag orange-bg">No pagado</span>
                          <?php endif; ?>
                      </td>
                      <td>
                          <?php echo $this->Html->link('', array('action' => 'detalle_entrega', $ent['Chip']['fecha_entrega_d'], $ent['Cliente']['id']),array('class' => 'button blue-gradient icon-list','title' => 'Detalle de chips entregados')); ?>
                          <a href="javascript:" class="button red-gradient icon-forbidden" title="Cancelar Asignacion" onclick="cancelar('<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'cancela_entrega', $ent['Chip']['fecha_entrega_c'], $ent['Cliente']['id'])); ?>');"></a>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>	

<script>
  function modificar(url)
  {
      $.modal({
          content: '<div id="idmodal"></div>',
          title: 'PRECIOS DEL PRODUCTO',
          width: 600,
          height: 400,
          actions: {
              'Close': {
                  color: 'red',
                  click: function (win) {
                      win.closeModal();
                  }
              }
          },
          buttonsLowPadding: true
      });
      $('#idmodal').load(url);
  }

  function cancelar(url) {
      if (confirm("Esta seguro de cancelar la entrega??")) {
          window.location = url;
      }
  }


</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 

