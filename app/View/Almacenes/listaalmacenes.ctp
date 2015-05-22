<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Almacenes</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                     
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Almacen</th>  
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Sucursal</th>  
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Direccion</th>
                    <th>Telefono</th>                  
                    <th scope="col" width="60" class="align-center">Acciones</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($distribuidores as $distribuidor): ?>
                    <tr>    
                        <td scope="col" width="25%"><?php echo $distribuidor['Almacene']['nombre']; ?></td>
                        <td><?php echo $distribuidor['Sucursal']['nombre']; ?></td>               
                        <td scope="col" width="25%"><?php echo $distribuidor['Sucursal']['direccion']; ?></td>                   
                        <td><?php echo $distribuidor['Sucursal']['telefono'] ?></td>
                        <td scope="col" width="25%" class="align-center">
                          <?php if($distribuidor['Almacene']['central'] == 1): ?>
                            <a href="<?php echo $this->Html->url(array('action' => 'listaentregas', $distribuidor['Almacene']['id'],1)); ?>" class="button green-gradient compact icon-down-fat">Recargar</a> 
                            <a href="<?php echo $this->Html->url(array('action' => 'entrega_celulares', $distribuidor['Almacene']['id'],1)); ?>" class="button green-gradient compact icon-down-fat">Rec. Celulares</a>
                            <?php else: ?>
                            <a href="<?php echo $this->Html->url(array('action' => 'listaentregas', $distribuidor['Almacene']['id'],1)); ?>" class="button orange-gradient compact icon-up-fat">Entregar</a>
                            <a href="<?php echo $this->Html->url(array('action' => 'entrega_celulares', $distribuidor['Almacene']['id'],1)); ?>" class="button blue-gradient compact icon-up-fat">Ent. celulares</a>
                            <?php endif; ?>
                           <?php 
                           /*if($distribuidor['Almacene']['central'] == 1){
                               echo $this->Html->link('repartir', array('action'=>'listaentregas',$distribuidor['Almacene']['id'],1),array('class'=>"button compact icon-gear")); 
                               //echo $this->Html->link('registro recargas', array('action'=>'listaentregas',$distribuidor['Almacene']['id'],1),array('class'=>"button compact icon-gear")); 
                           }else
                               echo $this->Html->link('dar', array('action'=>'listaentregas',$distribuidor['Almacene']['id'],1),array('class'=>"button compact icon-gear")); */
                           ?>
                        </td>
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>       
    </div>
</section>	
<?php if($this->Session->read('Auth.User.Group.name')=='Administradores'):?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 
<?php elseif($this->Session->read('Auth.User.Group.name')=='Almaceneros'):?>
<?php echo $this->element('sidebar/almacenero'); ?>
<?php endif; ?>
 