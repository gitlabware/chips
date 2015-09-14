<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Ventas de Tienda</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Accion</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($ventas as $ven): ?>
                  <tr>
                      <td><?php echo $ven['Movimiento']['created']; ?></td>
                      <td><?php echo $ven[0]['monto_total']; ?></td>
                      <td>
                          <a href="<?php echo $this->Html->url(array('action' => 'detalle_venta_t', $ven['Movimiento']['transaccion'])); ?>" class="button anthracite-gradient">Detalle</a>

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

