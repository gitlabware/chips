<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Tiendas</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col">id</th>
                    <th scope="col" >nombre</th>
                    <th scope="col" >direccion</th>                    
                    <th scope="col" >telefono</th>

                    <th scope="col" >Actions</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($sucursals as $p): ?>
                  <tr>                      
                      <td><?php echo $p['Sucursal']['id']; ?></td>
                      <td><?php echo $p['Sucursal']['nombre']; ?></td>
                      <td><?php echo $p['Sucursal']['direccion']; ?></td>
                      <td><?php echo $p['Sucursal']['telefono']; ?></td> 

                      <td scope="col" width="20%" class="align-center">
                          <a href="<?php echo $this->Html->url(array('action' => 'editar', $p['Sucursal']['id'])); ?>"class="button orange-gradient compact icon-pencil">Editar</a>
                          <?php if ($p['Sucursal']['central'] != 1): ?>
                            <a href="<?php echo $this->Html->url(array('action' => 'eliminar', $p['Sucursal']['id'])); ?>" onclick="if (confirm( & quot; Desea eliminar realmente?? & quot; )) {
                                      return true;
                                  }
                                  return false;" class="button red-gradient compact icon-cross-round">Eliminar</a>
                          <?php endif; ?>
                          <?php $ajaxv = 'openAjax2(' . $p['Sucursal']['id'] . ')' ?>
                          <?php //echo $this->Html->image("iconos/menu.png", array('onclick' => $ajaxv)); ?>
                          <?php //echo $this->Html->link($this->Html->image("iconos/editar.png", array("alt" => 'Editar', 'title' => 'editar')), array('action' => 'editar', $p['Sucursal']['id']), array('escape' => false)); ?>
                          &nbsp;
                          <?php //echo $this->html->link('usuarios', array('action'=>'usuarios',$p['Sucursal']['id'])); ?>

                          <?php //echo $this->Html->link($this->Html->image("iconos/eliminar.png", array("alt" => 'Editar', 'title' => 'editar')), array('action' => 'eliminar', $p['Sucursal']['id']), array('escape' => false)); ?>
                      </td>  
                  </tr>               
                <?php endforeach; ?>
            </tbody>
        </table> 
        <td><?php //echo $this->html->link('insertar', array('action' => 'insertar'), array('class' => 'button green-gradient glossy'));  ?> </td>
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php //echo $this->element('sidebar/administrador'); ?>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
<?php //echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 
<script>

  function openAjax2(id)
  {

      $.modal({
          title: 'Usuarios',
          url: '<?php echo $this->Html->url(array('action' => 'ajaxverusuarios')) ?>/' + id,
          width: 300
      });
  }
  ;
</script>