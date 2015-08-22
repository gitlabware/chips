<div class="centered">
         <div class="grid-1">
         <div class="content-gird">
            <div class="title-grid"> <span>Listado de Chips Entregados</span></div> 
                <h3>Total <?php echo $cant_sims_entregados; ?> SIMS Entregados</h3>
                <div id="c_b">
            	   <table class="display">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No.</th>
                            <th style="width: 200px;">SIM</th>
                            <th style="width: 60px;">Celular</th>                            
                            <th style="width: 150px;">Cod 149</th>
                            <th style="width: 150px;">Fecha Entrega</th>
                            <th>Accines</th>
                        </tr>
                    </thead>
                    </table>
                    <div style="overflow: auto; width: 926px; height: 300px"> 
                    <table class="display">
                    <tbody>
                        <?php foreach ($sims_entregados as $se): ?>
                        <?php $id_sim = $se['Chip']['id']; ?>
                            <tr>
                               <td style="width: 60px;"><?php echo $se['Chip']['numexcel']; ?></td>
                                <td style="width: 200px;"><?php echo $se['Chip']['sim']; ?></td>
                                <td style="width: 60px;"><?php echo $se['Chip']['telefono']; ?></td>
                                <td style="width: 150px;"><?php echo $se['Chip']['149']; ?></td>
                                <td style="width: 150px;"><?php echo $se['Chip']['fechaentrega']; ?></td>
                                <td>
                                    <?php echo $this->Form->checkbox("Chip", array('value' => $id_sim)); ?> No entregar        
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>  
                    </div>                  
                </div>	    
                <?php echo $this->Form->create('Chip', array('action' => 'noentregarsims')); ?>
                            <?php echo $this->Form->hidden('codigos', array('id' => 't')); ?>                        
                        <?php echo $this->Form->end('No Entregar'); ?> 
                    <script type="text/javascript">
                        function updateTextArea() {         
                             var allVals = [];
                             jQuery('#c_b :checked').each(function() {
                               allVals.push(jQuery(this).val());
                               console.log("aqui el puto mensaje "+jQuery(this).val());
                             });
                             jQuery('#t').val(allVals)
                          }
                         jQuery(function() {
                           jQuery('#c_b input').click(updateTextArea);
                           updateTextArea();
                         });
                    </script>       
            <div style="float: left;">
                        <input type="button" class="button" value="Atras" onclick="javascript:history.back();" /> 
                    </div>
            </div>
         </div>
</div>