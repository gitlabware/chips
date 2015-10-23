<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Recargas</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    
                    <th scope="col" width="15%" class="align-center hide-on-mobile">#149</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">nombre</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Num de cel cliente</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">monto</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Actions</th>
                </tr>
            </thead>          

            <tbody>
             
 <?php foreach ($recargas as $pe): ?>
               <tr> 
                   
                
                        <td><?php echo $pe['Cliente']['num_registro']; ?></td> 
                         <td><?php echo $pe['Cliente']['nombre']; ?></td> 
                        <td><?php echo $pe['Cliente']['celular']; ?></td>
                        <td><?php echo $pe['Recarga']['monto']; ?></td>
                        <td  class="low-padding align-center"><a href="<?php echo $this->html->url(array('action'=>'editar',$pe['Productosprecio']['id'],$pe['Productosprecio']['producto_id'])); ?>" class="button compact icon-gear">Edit</a>
                         <a href="<?php echo $this->html->url(array('action'=>'delete',$pe['Productosprecio']['id'])); ?>" class="button compact icon-gear">Delete</a>
                          <a class="low-padding align-center"><a href="<?php echo $this->html->url(array('action'=>'add')); ?>" class="button compact icon-gear">Add recarga</a></td>
                    <?php endforeach; ?>
               </tr>
            </tbody>
        </table>
        <td class="low-padding align-center"><a href="<?php echo $this->html->url(array('action'=>'add',$pe['Recarga']['Cliente.id'])); ?>" class="button compact icon-gear">Add recarga</a>      </td>
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 