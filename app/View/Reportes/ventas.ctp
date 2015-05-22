<?php //debug($reporte) ?>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Productos</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col" width="15%" class="align-center hide-on-mobile">distribuidor</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">cliente 149</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Cliente</th>                    
                    <th scope="col" width="60" class="align-center">Producto</th>
                    <th scope="col" width="60" class="align-center">escala</th>
                    <th scope="col" width="60" class="align-center">precio</th>
                    <th scope="col" width="60" class="align-center">cantidad</th>
                    <th scope="col" width="60" class="align-center">total</th>
                </tr>
            </thead>          

            <tbody>
                <?php 
                $total = 0;
                foreach ($ventashoy as $p): ?>
                    <tr>      
                        <td><?php echo $p['Persona']['nombre'].' '.$p['Perosna']['ap_paterno'].' '.$p['Perosna']['ap_materno']; ?></td>                 
                        <td><?php echo $p['Cliente']['num_registro']; ?></td>
                        <td><?php echo $p['Cliente']['nombre']; ?></td>
                        <td><?php echo $p['Producto']['nombre']; ?></td>
                        <td><?php echo $p['Ventasdistribuidore']['escala']; ?></td>
                        <td><?php echo $p['Ventasdistribuidore']['precio']; ?></td>
                        <td><?php echo $p['Ventasdistribuidore']['cantidad']; ?></td>    
                        <td><?php echo $p['Ventasdistribuidore']['total']; ?></td>                   
                       
                    </tr>               
                <?php 
                $total = $total + $p['Ventasdistribuidore']['total'];
                endforeach; ?>
            </tbody>
        </table>       
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 