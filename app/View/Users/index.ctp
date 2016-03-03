<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de usuarios</h1>
    </hgroup>

    <div class="with-padding">       

        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>                      
                    <th scope="col" width="5%" class="align-center hide-on-mobile">ID</th>
                    <th scope="col" width="15%" class="align-center">Nombre</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Apellido Paterno</th>
                    <th scope="col" width="10%" class="align-center hide-on-mobile-portrait">Usuario</th>
                    <th scope="col" width="10%" class="align-center hide-on-mobile-portrait">Tipo Usuario</th>
                    <th scope="col" width="25%" class="align-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($users as $usu):
                  ?>
                  <?php
                  if ($usu['User']['estado'] == "Baja") {
                    $style1 = 'background-color: #fe9b96;';
                  } else {
                    $style1 = '';
                  }
                  ?>
                  <tr>                      
                      <td style="<?php echo $style1; ?>"><?php
                          echo $usu['User']['id'];
                          $i++;
                          ?></td> 
                      <td style="<?php echo $style1; ?>"><?php echo $usu['Persona']['nombre']; ?></td>
                      <td style="<?php echo $style1; ?>" scope="col"  class="align-center hide-on-mobile"><?php echo $usu['Persona']['ap_paterno']; ?></td>
                      <td style="<?php echo $style1; ?>"><?php echo $usu['User']['username']; ?></td>
                      <?php $nombre = $usu['Persona']['nombre']; ?>
                      <td style="<?php echo $style1; ?>"><?php echo $usu['Group']['name']; ?></td>
                      <td style="<?php echo $style1; ?>" scope="col" class="align-center">
                          <?php //$ajaxv = 'openAjax(' . $usu['User']['id'] . ')' ?>
                          <?php //echo $this->Html->image("iconos/menu.png", array('onclick' => $ajaxv));   ?>
                          <?php //echo $this->Html->link($this->Html->image("iconos/editar.png", array("alt" => 'Editar', 'title' => 'editar')), array('action' => 'editar', $usu['User']['id']), array('escape' => false));  ?>                          
                          <?php if ($this->Session->read('Auth.User.group_id') == 1): ?>
                            <a href="<?php echo $this->Html->url(array('action' => 'editar', $usu['User']['id'])); ?>" class="button orange-gradient compact icon-pencil" title="Editar"></a>
                          <?php endif; ?>
                          <?php if ($usu['User']['group_id'] == 2 || $usu['User']['group_id'] == 7): ?>
                            <?php if ($this->Session->read('Auth.User.group_id') == 1): ?>
                              <?php echo $this->Html->link('', array('controller' => 'Almacenes', 'action' => 'devuelto', $usu['User']['persona_id']), array('class' => 'button blue-gradient compact icon-mailbox', 'title' => 'devueltos')); ?>
                            <?php endif; ?>
                            <?php echo $this->Html->link('Entregas', array('controller' => 'Almacenes', 'action' => 'listaentregas', $usu['User']['persona_id'], 0), array('class' => 'button green-gradient compact icon-mailbox', 'title' => 'Entregas')); ?>
                            <?php if ($this->Session->read('Auth.User.group_id') == 1): ?> 
                              <a href="javascript:" class="button black-gradient compact icon-page-list" onclick="precios_productos('<?php echo $usu['User']['id'] ?>')" title="Rutas"></a>
                            <?php endif; ?>
                          <?php endif; ?>
                          <?php if ($this->Session->read('Auth.User.group_id') == 1): ?>
                            <a href="<?php echo $this->Html->url(array('action' => 'delete', $usu['User']['id'])); ?>" title="Eliminar" onclick="if (confirm('Desea eliminar realmente a ' + '<?php echo $nombre ?>')) {
                                          return true;
                                      }
                                      return false;" class="button red-gradient compact icon-cross-round"></a>
                             <?php endif; ?>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table> <br>     
        <div class="columns">
            <div class="six-columns">
                <a href="<?php echo $this->Html->url(array('controller' => 'Informes', 'action' => 'excel_lista_personal')); ?>" class="button full-width">
                    <span class="button-icon"><span class="icon-download"></span></span>
                    Descargar excel
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Sidebar/drop-down menu -->
<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu -->
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'TARJETAS'): ?>
  <?php echo $this->element('sidebar/tarjetas'); ?>
  <?php elseif ($this->Session->read('Auth.User.Group.name') == 'Recargas'): ?>
  <?php echo $this->element('sidebar/recargas'); ?>
<?php endif; ?>
<?php //echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 
<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => 'index.json')); ?>';
  $(document).ready(function () {
      $("#formID").validationEngine();
  });
  function precios_productos(idUsuario)
  {
      /*$.modal({
       title: 'Iframe content',
       url: '<?php echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'ajax_precios')); ?>/' + idproducto,
       useIframe: true,
       width: 600,
       height: 400
       });*/

      $.modal({
          content: '<div id="idmodal"></div>',
          title: 'RUTAS DEL DISTRIBUIDOR',
          width: 600,
          height: 400,
          actions: {
              'Cerrar': {
                  color: 'red',
                  click: function (win) {
                      win.closeModal();
                  }
              }
          },
          buttonsLowPadding: true
      });
      $('#idmodal').load('<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'ajaxrutas')); ?>/' + idUsuario);
  }

</script>
<!-- End sidebar/drop-down menu --> 
<script>
  function mensaje_nota(titulo, texto) {
      notify(titulo, texto, {
          system: true,
          vPos: 'top',
          hPos: 'right',
          autoClose: true,
          icon: false ? 'img/demo/icon.png' : '',
          iconOutside: true,
          closeButton: true,
          showCloseOnHover: true,
          groupSimilar: true
      });
  }
  function editar_p(idproducto) {
      window.location = '<?php echo $this->Html->url(array('action' => 'editar')); ?>/' + idproducto;
  }
  function elimina_p(idproducto) {
      if (confirm('Esta seguro de eliminar el producto??')) {
          window.location = '<?php echo $this->Html->url(array('action' => 'delete')); ?>/' + idproducto;
      }
  }
</script>

