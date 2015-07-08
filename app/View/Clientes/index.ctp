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
        </table>  <br>
        
        <div class="columns">
            <div class="twelve-columns">
                <?php echo $this->Form->create('Cliente', array('action' => 'guardaexcel', 'id' => 'formActi', 'enctype' => 'multipart/form-data')); ?>
                <div class="field-block button-height">							
                    <label for="login" class="label"><b>Seleccionar Excel:</b></label>
                    <span class="input file">
                        <span class="file-text"></span>
                        <span class="button compact green-gradient">Seleccione</span>
                        <input type="file" name="data[Excel][excel]" id="special-input-1" value="" class="file withClearFunctions" required="" />
                    </span>
                    <button type="submit" class="button blue-gradient glossy">SUBIR EXCEL</button> 
                    <button type="button" class="button glossy mid-margin-right" onclick="openModal2();">
                        <span class="button-icon"><span class="icon-search"></span></span>
                        Ver Formato Clientes
                    </button>
                </div> 
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section>	

<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => 'index.json')); ?>';
  datos_tabla2 = {};
  datos_tabla2 = {
      "oLanguage": {
          "sUrl": "<?php echo $this->webroot; ?>js/libs/DataTables/Spanish.json"
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
  function openModal2()
  {
      //console.log('hizo click');
      $.modal({
          title: 'Formato del Archivo',
          content: '<?php echo $this->Html->image('iconos/clientes.png'); ?>',
          center: true,
          width: 1250,
          height: 450,
      });
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