<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Ultimas Entregas Chip</h1>
    </hgroup>
    <div class="with-padding">                   
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th class="hide-on-mobile">Fecha</th>
                    <th>Cliente</th>
                    <th>Codigo CLiente</th>
                    <th>Nro Chips</th>
                    <th>Acciones</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($entregados as $ent): ?>
                  <tr>
                      <td class="hide-on-mobile"><?php echo $ent['Chip']['fecha_entrega_d'] ?></td>
                      <td><?php echo $ent['Cliente']['nombre'] ?></td>
                      <td><?php echo $ent['Cliente']['num_registro'] ?></td>
                      <td><?php echo $ent[0]['num_chips'] ?></td>
                      <td>
                          <?php echo $this->Html->link('Detalle', array('action' => 'detalle_entrega', $ent['Chip']['fecha_entrega_d'], $ent['Cliente']['id'])); ?>
                          <a href="javascript:" class="" onclick="cancelar('<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'cancela_entrega', $ent['Chip']['fecha_entrega_d'], $ent['Cliente']['id'])); ?>');">Cancelar</a>
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

