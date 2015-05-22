
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h3>
        Detalle entrega de <?php echo $detalle[0]['Producto']['nombre'].' de '.$detalle[0]['Producto']['proveedor'] ?>
         a <?php echo $nombre?>
        </h3>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                     
                   <th scope="col" width="15%" class="align-center">Fecha entrega</th>
                    <th scope="col" width="15%" class="align-center">Cantidad</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">#factura desde</th>  
                    <th scope="col" width="15%" class="align-center hide-on-mobile">#factura hasta</th>  
                    <th scope="col" width="15%" class="align-center"># de lote</th> 
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($detalle as $rango): ?>
                    <tr>    
                       <td><?php echo $rango['Detalle']['created']?></td>
                        <td><?php echo $rango['Detalle']['cantient']; ?></td>
                        <td><?php echo $rango['Detalle']['rangoi']; ?></td>
                        <td><?php echo $rango['Detalle']['rangof']; ?></td>               
                        <td><?php echo $rango['Detalle']['lote']; ?></td>
                        
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>       
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/insumos'); ?>
<!-- End sidebar/drop-down menu --> 