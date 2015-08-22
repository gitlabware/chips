<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Clientes</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    
                    <th>numero de registro</th>
                    <th >nombre</th>
                    <th >direccion</th>  
                    <th >celular</th>
                    <th >zona</th>
                    <th>Acciones</th>      
                     
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($clientes as $p): ?>
                    <tr>                      
                        <td><?php echo $p['Cliente']['num_registro']; ?></td>
                        <td><?php echo $p['Cliente']['nombre']; ?></td>
                        <td><?php echo $p['Cliente']['direccion']; ?></td>
                        <td><?php echo $p['Cliente']['celular']; ?></td>
                        <td><?php echo $p['Cliente']['zona']; ?></td>
                        <td><?php echo $this->Html->link($this->Html->image("iconos/editar.png", array("alt" => 'Editar', 'title' => 'editar')), array('action' => 'edit', $p['Cliente']['id']), array('escape' => false));?></td>            
                       
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>   
        
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 
