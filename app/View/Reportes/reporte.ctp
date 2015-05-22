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
                    <th scope="col">Nombre</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Proveedor</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Precio compra</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile-portrait">Categoria</th>                    
                    <th scope="col" width="60" class="align-center">Actions</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>                      
                        <td><?php echo $p['Producto']['nombre']; ?></td>
                        <td><?php echo $p['Producto']['proveedor']; ?></td>
                        <td><?php echo $p['Producto']['precio_compra']; ?></td>
                        <td><?php echo $p['Tiposproducto']['nombre']; ?></td>                    
                        <td class="low-padding align-center"><a href="#" class="button compact icon-gear">Edit</a></td>
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>       
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 