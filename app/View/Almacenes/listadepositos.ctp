<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Depositos</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>                     
                    <th scope="col" width="15%" class="align-center">Distribuidor</th> 
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Banco</th>
                    <th scope="col" width="15%" class="align-center">Deposito</th>
                    <th scope="col" width="5%" class="align-center hide-on-mobile">Comprobante</th>
                    <th scope="col" width="15%" class="align-center">Efectivo</th>
                    <th scope="col" width="5%" class="align-center hide-on-mobile">Recibo</th>
                    <th scope="col" width="5%" class="align-center">Total</th>                  
                    <th scope="col" class="align-center hide-on-mobile">Fecha</th>
                </tr>
            </thead>          
            <tbody>
                <?php 
                foreach ($depositos as $d): 
                    $total = 0;
                    $total = $d['Deposito']['banco'] + $d['Deposito']['efectivo']; 
                ?>
                    <tr>    
                        <td><?php echo $d['Persona']['nombre'].' '.$d['Persona']['ap_paterno']; ?></td>
                        <td class="hide-on-mobile"><?php echo $d['Banco']['nombre'];?></td>
                        <td><?php echo $d['Deposito']['banco']; ?></td>               
                        <td class="hide-on-mobile"><?php echo $d['Deposito']['comprobante']; ?></td>                   
                        <td><?php echo $d['Deposito']['efectivo'] ?></td>
                        <td class="hide-on-mobile"><?php echo $d['Deposito']['recibo'] ?></td>
                        <td><?php echo $total ?></td>
                        <td class="low-padding align-center hide-on-mobile">
                           <?php echo $d['Deposito']['created']?>
                        </td>
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>       
    </div>
</section>	
<?php if($this->Session->read('Auth.User.Group.name')=='Distribuidores'):?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 
<?php elseif($this->Session->read('Auth.User.Group.name')=='Administradores'):?>
<?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>