
<?php
 if(empty($pedidos)):?>
<div class="message2">No realizo ningun pedido hoy.</div>
<?php else:?>
      <div class="centered">
         <div class="grid-1">
            <div class="title-grid"> <span>Pedidos</span></div>
            <div class="content-gird">
            <div id="imprime">
               <div class="logoprint">
                  
               </div>
                            
               <table class="display">
                  <thead>
                     <tr class="oculto">
                        <th colspan="7">Lista de Pedidos</th>
                     </tr>
                     <tr>
                        <th>Producto</th>
                       
                        <th >Cantidad</th>
                        <th>Fecha pedido</th>
                        <th class="th_status sorting">Estado</th>
                        <th class="txt">Cantidad entregada</th>
                        <th>Fecha entrega</th>
                        <th>Acciones</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($pedidos as $prod):?>
                         <tr class="item">
                            <td> <?php echo $prod['Producto']['nombre'];?></td>
                         
                            <td><?php echo $prod['Pedido']['cantidad'];?></td>
                            <td><?php echo $prod['Pedido']['fechapedido'];?></td>
                            
                            <?php if($prod['Pedido']['fechaentrega'] == null):?>
                            <td><span class="moderation">Pendiente</span></td>
                            <td><?php echo $prod['Pedido']['cantient'];?></td>
                            <td>0</td>
                            <?php else:?>
                            <td><span class="published">Entregado</span></td>
                            <td><?php echo $prod['Pedido']['cantient'];?></td>
                            <td><?php echo $prod['Pedido']['fechaentrega'];?></td>
                            <?php endif;?>
                            <td><?php echo $this->Html->link($this->Html->image('/images/counter.png', array("alt"=>'Detalle', 'title'=>'Detalle')), array('action'=>'detalle', $prod['Pedido']['id'], $prod['Producto']['nombre']),array('escape' => false));?></td>
                         </tr>
                     <?php endforeach;?>
                  </tbody>
               </table><!--fin tabla-->
               </div>
               <div class="paginator">
                  <?php echo $this->Paginator->prev('<< Anterior', array(), null, array('class'=>'disabled'));?>  <?php echo $this->Paginator->numbers( ); ?>  <?php echo $this->Paginator->next('Siguiente >>', array(), null, array('class'=>'disabled'));?>
               </div>
               </div>
            </div><!--fin contenido grid-->
             <div class="grid-buttons">
             <!--<div class="title-grid"><span>Acciones</span></div>-->
             <div class="content-gird">
                <div class="button">
                   <?php echo $this->Html->link('Registrar', 'pedidos', array('title'=>'Hacer nuevo pedido')); ?>
                </div>
                                
                <div style="float:left">
                   <?php echo $this->Form->button('Imprimir', array('title'=>'Imprimir lista', 'id'=>'btnImprimir', 'class'=>'mybutton')); ?>
                </div>
            <div class="clear"> </div>
             </div>
            
         </div>
         </div><!--fin contenido-->
        
        
            

      </div><!--End div centered-->
   
<?php endif;?>
 <script type="text/javascript">
   jQuery(document).ready(function() {

         jQuery("#btnImprimir").click(function() {
            //printElem({ leaveOpen: true, printMode: 'popup' });
            printElem({ overrideElementCSS: ['http://www.atotic.com/viva/inventario/app/webroot/css/printable.css'] });
         });


     });
 function printElem(options){
     jQuery('#imprime').printElement(options);
 }
</script>