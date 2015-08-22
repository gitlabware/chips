<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Productos vendidos</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col" width="5%" class="align-center hide-on-mobile">Nro.</th>
                    <th scope="col" width="10%" class="align-center">Nombre</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Precio</th>
                    <th scope="col" width="15%" class="align-center">subtotal</th>
                </tr>
            </thead>          

            <tbody>
                <?php $i=1; foreach ($ventas as $p): ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>                      
                        <td><?php echo $p['Producto']['nombre']; ?></td>
                        <td><?php echo $p['Ventastienda']['precio']; ?></td>
                        <td><?php echo $p['Ventastienda']['total']; ?></td>
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>   

    </div>
</section>	

<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 
