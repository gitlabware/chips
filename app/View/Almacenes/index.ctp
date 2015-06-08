<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Almacenes</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col">id</th>
                    <th scope="col" >Nombre almacen</th>
                    <th scope="col" >Sucursal</th>                    
                    <th scope="col" >Descripcion</th>

                    <th scope="col" class="align-center">Actions</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($almacenes as $p): ?>
                  <tr>                      
                      <td><?php echo $p['Almacene']['id']; ?></td>
                      <td><?php echo $p['Almacene']['nombre']; ?></td>
                      <td><?php echo $p['Sucursal']['nombre']; ?></td>
                      <td><?php echo $p['Almacene']['descripcion']; ?></td> 

                      <td scope="col" width="20%" class="align-center">
                          <a href="<?php echo $this->Html->url(array('action' => 'editar', $p['Almacene']['id'])) ?>"class="button orange-gradient compact icon-pencil">Editar</a>
                          <?php if($p['Almacene']['id']!=1): ?>
                          <a href="<?php echo $this->Html->url(array('action' => 'eliminar', $p['Almacene']['id'])); ?>" onclick="if (confirm('Desea eliminar realmente??' )) {
                                    return true;
                                }
                                return false;" class="button red-gradient compact icon-cross-round">Eliminar</a>
                          <?php else: ?>
                          <?php endif; ?>
                      </td>  
                  </tr>               
                <?php endforeach; ?>
            </tbody>
        </table> 
        <td><?php //echo $this->html->link('insertar', array('action' => 'add'), array('class' => 'button green-gradient'));  ?> </td>
    </div>
</section>	

<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
