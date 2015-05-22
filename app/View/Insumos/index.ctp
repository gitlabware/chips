<?php //uses('model/connection_manager'); ?>
<?php 
    //App::import('Model', 'Movimiento');
    //$modeloMovimiento = new Movimiento();
    //debug($montos->find('all', array('recursive'=>-1, 'limit'=>3))); 
?>

                    <table id="exampleDTB-2" class="table boo-table table-striped table-content table-hover">
                        <caption>
                            Insumos<span></span>
                        </caption>
                        <thead>
                            <tr>  
                                <th scope="col">ID <span class="column-sorter"></span></th>                          
                                <th scope="col">Nombre <span class="column-sorter"></span></th>
                                <th scope="col">Categoria <span class="column-sorter"></span></th>
                                <th scope="col">Cantidad <span class="column-sorter"></span></th>                            
                                <th scope="col">Acciones <span class="column-sorter"></span></th>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($insumos as $i): ?>                        
                        <?php $idInsumo = $i['Insumo']['id'] ?>                        
                            <tr>                                    
                                <td>
                                    <?php echo $idInsumo; ?>                                    
                                    <div id="cuadro_<?php echo $idInsumo; ?>"></div>                         
                                    <div id="cuadro2_<?php echo $idInsumo; ?>"></div>
                                    <div id="ajax-modal_<?php echo $idInsumo; ?>" class="modal hide fade" tabindex="-1" data-width="760"></div>
                                    <div id="ajax2_<?php echo $idInsumo; ?>" class="modal hide fade" tabindex="-1" data-width="90%">
                                    </div>
                                </td>
                                <td><?php echo $i['Insumo']['nombre']; ?></td>
                                <td> <?php echo $i['Categoria']['nombre']; ?></td>                                
                                <td> 
                                    <?php
                                        $ultimoMovimiento = $modeloMovimiento->find('first', array(
                                            'recursive'=>-1,
                                            'fields'=>array('MAX(id) as cod'),
                                            'conditions'=>array('Movimiento.insumo_id'=> $idInsumo )
                                        ));
                                        //debug($idInsumo);
                                        //debug($ultimoMovimiento);
                                        $idMovimiento = $ultimoMovimiento['0']['cod'];
                                        
                                        $total = $modeloMovimiento->find('first', array(
                                            'recursive'=>-1,
                                            'conditions'=>array('Movimiento.id'=>$idMovimiento)
                                        ));
                                        //debug($total);
                                        echo $total['Movimiento']['total']; 
                                        //debug($enAlmacen); 
                                        //echo $enAlmacen['0']['cod'];
                                        //echo $i['Tipo']['nombre']; 
                                    ?>
                                </td>                                                              
                                <td>
                                <div id="ajaxModal4_<?php echo $idInsumo; ?>" style="float: left;">
                                <?php
                                    echo $this->Html->image("show.png", array("title" => "ver cantidades en almacenes"));
                                ?>
                                </div>
                                                                        
                                        <div id="ajaxModal1_<?php echo $idInsumo; ?>" style="float: left;">
                                            <?php
                                            echo $this->Html->image("in.png", array("title" => "Ingresar"));
                                            ?>
                                        </div>
                                        <div id="ajaxModal2_<?php echo $idInsumo; ?>" style="float: left;">
                                            <?php
                                            echo $this->Html->image("transfer.png", array("title" => "Tranferencia entre almacenes"));
                                            ?>
                                        </div>
                                        
                                        <div id="ajaxModal3_<?php echo $idInsumo; ?>" style="float: left;">
                                            <?php
                                            echo $this->Html->image("out.png", array(
                                                "title" => "Salida Almacen"
                                            ));
                                            ?>            
                                        </div>
                                        <?php
                                        echo $this->Html->image("edit.png", array(
                                            "title" => "Editar",
                                            'url' => array('action' => 'modificar', $idInsumo)
                                        ));
                                        ?> 
                                        <?php
                                        echo $this->Html->image("elim.png", array(
                                            "title" => "Eliminar Insumo",
                                            'url' => array('action' => 'deshabilitar', $idInsumo)
                                        ));
                                        ?>            
                                        <script type="text/javascript">
                                        $(document).ready(function(){
                                            
                                            var $modal1 = $('#ajax-modal_<?php echo $idInsumo; ?>');
                                            
                                        	$('#ajaxModal1_<?php echo $idInsumo; ?>').on('click', function () {
                                        			// create the backdrop and wait for next modal to be triggered
                                        			GlobalModalManager.loading();
                                        	
                                        			setTimeout(function () {
                                        					$modal1.load("<?php echo $this->Html->url(array('controller'=>'movimientos', 'action'=>'ajaxingreso')) ?>/<?php echo $idInsumo; ?>", '', function () {
                                        							$modal1.modal();
                                        					});
                                        			}, 500);
                                        	});
                                            
                                            var $modal2 = $('#ajax-modal_<?php echo $idInsumo; ?>');
                                            
                                            $('#ajaxModal2_<?php echo $idInsumo; ?>').on('click', function () {
                                        			// create the backdrop and wait for next modal to be triggered
                                        			GlobalModalManager.loading();
                                        	
                                        			setTimeout(function () {
                                        					$modal2.load("<?php echo $this->Html->url(array('controller'=>'movimientos', 'action'=>'ajaxtransferencia')) ?>/<?php echo $idInsumo; ?>", '', function () {
                                        							$modal2.modal();
                                        					});
                                        			}, 500);
                                        	});
                                        	
                                            
                                            var $modal3 = $('#ajax-modal_<?php echo $idInsumo; ?>');
                                            $('#ajaxModal3_<?php echo $idInsumo; ?>').on('click', function () {
                                        	   console.log('ciclk');
                                        			// create the backdrop and wait for next modal to be triggered
                                        			GlobalModalManager.loading();
                                        	
                                        			setTimeout(function () {
                                        					$modal3.load("<?php echo $this->Html->url(array('controller'=>'movimientos', 'action'=>'ajaxsalida')) ?>/<?php echo $idInsumo; ?>", '', function () {
                                        							$modal3.modal();
                                        					});
                                        			}, 500);
                                        	});
                                            var $modal4 = $('#ajax2_<?php echo $idInsumo; ?>');
                                            $('#ajaxModal4_<?php echo $idInsumo; ?>').on('click', function () {
                                        	   console.log('ciclk');
                                        			// create the backdrop and wait for next modal to be triggered
                                        			GlobalModalManager.loading();
                                        	
                                        			setTimeout(function () {
                                        					$modal4.load("<?php echo $this->Html->url(array('controller'=>'insumos','action'=>'ajaxver')) ?>/<?php echo $idInsumo; ?>", '', function () {
                                        							$modal4.modal();
                                        					});
                                        			}, 500);
                                        	});
                                        	
                                        });                                            
                                        </script>        
                                </td>                                
                            </tr>
                        <?php endforeach; ?>                           
                        </tbody>
                    </table>
 	
<!-- Sidebar -->
<?php //echo $this->element('menualmacenes') ?>
<!-- End Sidebar -->