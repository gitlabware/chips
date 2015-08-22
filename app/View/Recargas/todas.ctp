
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Recargas</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Solicita</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">#149/cliente</th>
                    <th scope="col" width="15%" class="align-center">Abonado</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">monto solicitado</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">%</th>
                    <th scope="col" width="15%" class="align-center">Total a Recargar</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Estado</th>
                    <th scope="col" width="15%" class="align-center">Accion</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">
                    Pago
                    </th>
                </tr>
            </thead>          

            <tbody>
               <?php foreach ($recargas as $pe): ?>
               <tr> 
                   
                <td>
                <?php echo $pe['Persona']['nombre'].' '.$pe['ap_paterno']['ap_materno']?>
                </td>
                        <td>
                        <span style="font-weight: bold;"><?php echo $pe['Cliente']['num_registro']; ?></span>/<?php echo $pe['Cliente']['nombre']; ?>
                        </td>                 
                        <td><?php echo $pe['Recarga']['numero']; ?></td>
                        <td><?php echo $pe['Recarga']['monto']; ?></td>
                        <td><?php echo $pe['Recarga']['porcentaje']; ?></td>
                        <td><?php echo $pe['Recarga']['total']?></td>
                        
                       <?php if($pe['Recarga']['estado']==0):  ?>
                        <td style="background: #E28791;">
                        RECARGAR   
                        </td>
                        <?php else:?>
                        <td style="background: #83A4D6;">
                         RECARGADO
                        </td>
                        <?php endif;?>
                        
                        <td  class="align-center">
                        <div class="with-padding">

			
                         <?php echo $this->Form->create(null, array('url'=>array('controller'=>'recargas', 'action'=>'cambiaestado')))?>
                            <?php echo $this->Form->hidden('Recarga.id', array('value'=>$pe['Recarga']['id']))?>
                             <p class="button-height">
				                <?php if(!($pe['Recarga']['estado'])):?>
				                <input type="checkbox" name="data[Recarga][estado]" id="anthracite-inputs" class="switch medium wide anthracite-active mid-margin-left replacement checked" value="1" data-text-on="recargar" data-text-off="cargado">
                                <?php else:?>
                                <input type="checkbox" name="data[Recarga][estado]" id="anthracite-inputs" class="switch medium wide anthracite-active mid-margin-left" value="2" data-text-on="recargar" data-text-off="cargado">
                                <?php endif;?>
			                 </p>
                           
                                <div class="button-height">
                                    
                                    <?php 
                                    $opcion = array(
                                    'Value'=>'Cambiar', 
                                    'class'=>'button blue-gradient'
                                    );
                                    echo $this->Form->end($opcion)?>
                                    
                                </div>
                            </div>
                        
                        </td>
                        
                        <?php if($pe['Recarga']['xcobrar'] == 1):?>
                        <td style="background: #FFAEAE;">
                        POR COBRAR
                        </td>
                        <?php else:?>
                        <td style="background: silver;">
                        AL CONTADO
                        </td>
                        <?php endif;?>
                        
                        
               <?php endforeach; ?>
               </tr>
            </tbody>
        </table>
        <td class="low-padding align-center"><a href="<?php echo $this->html->url(array('action'=>'add',$pe['Recarga']['Cliente.id'])); ?>" class="button compact icon-gear">Add recarga</a>      </td>
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/recargas'); ?>
<!-- End sidebar/drop-down menu --> 