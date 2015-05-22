<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Precios del producto <?php echo $productosprecios[0]['Producto']['nombre']?></h1>
    </hgroup>

    <div class="with-padding">                   
<div class="twelve-columns twelve-columns-mobile">

					<p class="button-height">
                                            <a href="<?php echo $this->Html->url(array('action'=>'nuevoprecio'))?>" class="button">
							<span class="button-icon"><span class="icon-star"></span></span>
							Agregar nuevo precio
						</a>
						<a href="<?php echo $this->Html->url(array('controller'=>'Productos','action'=>'index'))?>" class="button">
							<span class="button-icon"><span class="icon-download"></span></span>
							Retornar a productos
						</a>
						
					</p>
					<p>
						
					</p>

				</div>
        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Para</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">escala</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">precio</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Actions</th>
                </tr>
            </thead>          

            <tbody>
               <?php foreach ($productosprecios as $pe): ?>
               <tr> 
                   
                
                        <td><?php echo $pe['Tipousuario']['nombre']; ?></td>                 
                        <td><?php echo $pe['Productosprecio']['escala']; ?></td>
                        <td><?php echo $pe['Productosprecio']['precio']; ?></td>
                        <td class="low-padding align-center"><a href="<?php echo $this->html->url(array('action'=>'editar',$pe['Productosprecio']['id'],$pe['Productosprecio']['producto_id'])); ?>" class="button compact icon-gear">Edit</a>
                         <a href="<?php echo $this->html->url(array('action'=>'delete',$pe['Productosprecio']['id'])); ?>" class="button compact icon-gear">Delete</a>
                    <?php endforeach; ?>
               </tr>
            </tbody>
        </table>       
    </div>
    
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 

