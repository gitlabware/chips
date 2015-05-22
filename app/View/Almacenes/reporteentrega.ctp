<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1><?php //debug($movimiento);exit;?>
            Producto
            <?php echo $movimiento['Producto']['nombre']?>
            
            entregados fecha <?php echo $fecha?> 
        </h1>
        <h4>
            <?php if($movimiento['Movimiento']['persona_id'] != null):?>
            Persona: 
            <?php echo $movimiento['Persona']['nombre'].' '.$movimiento['Persona']['ap_paterno'];?>
            <?php endif;?>
            <?php if($movimiento['Movimiento']['almacene_id'] != null):?>
            Almacen: 
            <?php echo $movimiento['Almacene']['nombre'];?>
            <?php endif;?>
        </h4>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>  
                    
                                     
                    <th scope="col" width="15%" class="align-center">
                        <?php if($almacentral == 0):?>
                        Cantidad entregada
                        <?php else:?>
                        Cantidad ingresada
                        <?php endif;?>
                    </th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Saldo anterior</th>
                    <?php if($almacentral == 0):?>
                    
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Ventas</th>
                    <?php else:?>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">salidas</th>
                    <?php endif;?>
                    <th>Total</th>
                </tr>
            </thead>
            <tr>
                <td>
                    <?php echo $movimiento['Movimiento']['ingreso'];?>
                </td>
                <td>
                    <?php echo $movimiento['Movimiento']['saldo'];?>
                </td>
                <td>
                    <?php echo $movimiento['Movimiento']['salida'];?>
                </td>
                <td>
                    <?php echo $movimiento['Movimiento']['total'];?>
                </td>
            </tr>          
            <tbody>
                
            </tbody>
        </table>       
    </div>
</section>	
<?php if($this->Session->read('Auth.User.Group.name')=='Almaceneros'):?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 
<?php elseif($this->Session->read('Auth.User.Group.name')=='Administradores'):?>
<?php echo $this->element('sidebar/administrador');?>
<?php endif; ?>
