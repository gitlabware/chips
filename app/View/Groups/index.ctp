<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Productos</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Nro.</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Nombre</th>   
                    <th scope="col" width="60" class="align-center">Acciones</th>
                </tr>
            </thead>          

            <tbody>
                <?php $i=1; foreach ($groups as $gro): ?>
                    <tr>  
                        <td><?php echo $i; $i++; ?></td>                    
                        <td><?php echo $gro['Group']['name']; ?></td>          
                        <td class="low-padding align-center"><a href="<?php echo $this->html->url(array('action'=>'editar',$gro['Group']['id'])); ?>" class="button compact icon-gear">Editar</a>
                        <a href="<?php echo $this->Html->url(array('action'=>'delete',$gro['Group']['id'])); ?>" class="button compact icon-gear">Eliminar</a>
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>   
        <td class="low-padding align-center"><a href="<?php echo $this->html->url(array('action'=>'insertar')); ?>" class="button compact icon-gear">Insertar Nuevo Usuario</a></td>    
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 
