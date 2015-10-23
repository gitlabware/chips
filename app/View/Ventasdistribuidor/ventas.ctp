<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de ventas de hoy <?php echo date("Y-m-d"); ?></h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Monto Total</th>
                    <th>Accion</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($ventas as $ven): ?>
                  <tr>
                      <td><?php echo $ven['Cliente']['nombre']; ?></td>
                      <td><?php echo $ven[0]['monto_total']; ?></td>
                      <td>
                         <?php echo $this->Html->link("venta",array('action' => 'formulario',$ven['Movimiento']['cliente_id'],$ven['Movimiento']['transaccion']));?> 
                      </td>
                  </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 

