<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Listado de Clientes</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="tabla-json">

            <thead>
                <tr>                      

                    <th style="width: 10%;">numero de registro</th>
                    <th >nombre</th>
                    <th style="width: 30%;" class="hide-on-mobile">direccion</th>  
                    <th class="hide-on-mobile">celular</th>
                    <th class="hide-on-mobile">zona</th>
                    <th >Acciones</th>
                </tr>
            </thead>          

            <tbody>

            </tbody>
        </table>  
    </div>
</section>	

<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => 'index.json')); ?>';
  datos_tabla2 = {};
  datos_tabla2 = {
      "oLanguage": {
          "sUrl": "https://cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json"
      },
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
          $('td:eq(2)', nRow).addClass('hide-on-mobile');
          $('td:eq(3)', nRow).addClass('hide-on-mobile');
          $('td:eq(4)', nRow).addClass('hide-on-mobile');
      }
  };
  function editarc(idcliente) {
      location = '<?php echo $this->Html->url(array('action' => 'edit')); ?>/' + idcliente;
  }
  function eliminarc(idcliente) {
      if (confirm("Esta seguro de eliminar al cliente??")) {
          location = '<?php echo $this->Html->url(array('action' => 'delete')); ?>/' + idcliente;
      }
  }
</script>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/administrador'); ?>
  <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Distribuidores'): ?>
  <?php echo $this->element('sidebar/distribuidor'); ?>
<?php endif; ?>
<?php //echo $this->Html->link($this->Html->image("iconos/editar.png", array("alt" => 'Editar', 'title' => 'editar')), array('action' => 'edit', $p['Cliente']['id']), array('escape' => false));?>
<?php //echo $this->Html->link($this->Html->image("iconos/eliminar.png", array("alt" => 'eliminar', 'title' => 'eliminar')), array('action' => 'delete', $p['Cliente']['id']), array('escape' => false), ("Desea eliminar realmente??"));
?>