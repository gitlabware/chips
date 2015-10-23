<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Detalle de venta con Nro de Transaaccion <?php echo $transaccion; ?></h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Monto Total</th>
                    <th>Accion</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($items as $it): ?>
                  <tr>
                      <td><?php echo $it['Producto']['tipo_producto']; ?></td>
                      <td><?php echo $it['Producto']['nombre']; ?></td>
                      <td><?php echo $it['Movimiento']['marca']; ?></td>
                      <td><?php echo $it['Movimiento']['precio_uni']; ?></td>
                      <td><?php echo $it['Movimiento']['salida']; ?></td>
                      <td><?php echo $it[0]['mon_total']; ?></td>
                      <td>
                          <?php echo $this->Html->link("Eliminar", array('action' => 'elimina_venta_t', $it['Movimiento']['id']), array('class' => 'tag red-bg', 'confirm' => 'Esta seguro de eliminar la venta???')) ?>
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

