<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Productos Cabina</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col">id</th>
                    <th scope="col" >Producto</th>
                    <th scope="col" >Monto</th>                    
                    <th scope="col" >Monto recarga</th>
                    
                    <th scope="col" >Actions</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>                      
                        <td><?php echo $p['Recargascabina']['id']; ?></td> 
                        <td><?php echo $p['Producto']['nombre']; ?></td>
                        <td><?php echo $p['Recargascabina']['monto']; ?></td>
                        <td><?php echo $p['Recargascabina']['monto_recarga']; ?></td> 
                        
                        <td>
                        <?php echo $this->html->link('editar', array('action'=>'editapro',$p['Recargascabina']['id'])); ?> 
                        &nbsp;
                        <?php //echo $this->html->link('usuarios', array('action'=>'usuarios',$p['Sucursal']['id'])); ?>
                        <?php echo $this->html->link('Eliminar', array('action'=>'eliminapro',$p['Recargascabina']['id'])); ?>
                        </td>  
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table> 
        <td><?php echo $this->html->link('insertar', array('action'=>'addrecargacabina')); ?> </td>
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 