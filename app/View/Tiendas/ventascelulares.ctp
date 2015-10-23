<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Ventas de celulares</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Marca</th>
                    <th>Producto</th>
                    <th>Color</th>
                    <th>Monto</th>
                    <th>Accion</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($ventas as $ven): ?>
                  <tr>
                      <td><?php echo $ven['Ventascelulare']['created']; ?></td>
                      <td><?php echo $ven['Ventascelulare']['cliente']; ?></td>
                      <td><?php echo $ven['Ventascelulare']['marca']; ?></td>
                      <td><?php echo $ven['Producto']['nombre']; ?></td>
                      <td><?php echo $ven['Ventascelulare']['color']; ?></td>
                      <td><?php echo $ven['Ventascelulare']['precio']; ?></td>
                      <td>
                          <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('action' => 'ajax_cambio_cel', $ven['Ventascelulare']['id'])); ?>','Cambio de Equipo',230)" class="button blue-gradient icon-cycle" title="Cambio"></a> 
                          <a href="<?php echo $this->Html->url(array('action' => 'ventacelular', $ven['Ventascelulare']['id'])); ?>" class="button green-gradient icon-pencil" title="Editar"></a> 
                          <?php echo $this->Html->link('',array('action' => 'elimina_venta_cel',$ven['Ventascelulare']['id']),array('class' => 'button red-gradient icon-cross-round','confirm' => 'Esta seguro de eliminar la venta??','title' => 'Eliminar')); ?>
                      </td>
                  </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 

