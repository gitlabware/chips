<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de pedidos</h1>
    </hgroup>
    <div class="with-padding">                   
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Distribuidor</th>
                    <th>Numero</th>
                    <th>Accion</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($pedidos as $ped): ?>
                  <tr>
                      <td><?php echo $ped['Pedido']['created'] ?></td>
                      <td><?php echo $ped['Pedido']['nombre_dist'] ?></td>
                      <td><?php echo $ped['Pedido']['numero'] ?></td>
                      <td>
                          <?php echo $this->Html->link("pedido", array('action' => 'pedido', $ped['Pedido']['numero']), array('class' => 'button blue-gradient glossy')); ?> 
                          <?php echo $this->Html->link("", array('action' => 'eliminar_pedido', $ped['Pedido']['numero']), array('class' => 'button icon-trash red-gradient', 'title' => 'Eliminar el pedido', 'confirm' => 'Esta seguro de eliminar el pedido?')) ?>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

