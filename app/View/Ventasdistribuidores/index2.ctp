  <div class="grid-3" style="margin-top:30px">
  <div class="title-grid"> <span>Ruta Asignada</span></div>

  
   <table class="mobiletabla" align="center">
      <div id="dialog1" title="Ubicacion de 149"></div>
      <div id="dialog2" title="Observaciones de 149"></div>
</div>
      <tr>
         <th class="txt">#</th>
         <th class="txt">149</th>
         <th class="txt">Cliente</th>
         <th class="txt">Estado</th>
         <th>Acciones</th>
      </tr>
      <?php $n=0;
         //debug($lista);
         //debug($cmp);
      ?>
      
      <?php foreach($lista as $li):?>
         <tr>
            <td><?php echo $li['Listacliente']['orden'];?></td>
            <td><?php echo $li['Cliente']['num_registro']?></td>
            <td><?php echo $li['Cliente']['nombre']?></td>
            <td>
             <?php if(!empty($cmp)):?>
                <?php $estado=0;?>
                <?php foreach($cmp as $c):?>

                    <?php if($c == $li['Listacliente']['cliente_id']):?>
                            <?php $estado= 1;?>
                            <?php break;?>
                    <?php endif;?>
                <?php endforeach;?>
                <?php if ($estado):?>
                    <span class="published">Visitado</span>
                <?php else:?>
                    <span class="moderation">Pendiente</span>
                <?php endif;?>
             
             <?php else:?>
                  <span class="moderation">Pendiente</span>
                  <?php $estado= 0;?>
             <?php endif;?>
            </td>
            
            <td>
            <?php echo $this->Html->link($this->Html->image('/images/maps.jpg',array("alt"=>'Ver Mapa', 'title'=>'Ver mapa', 'id'=>'btnmapa')), array('action'=>'vermapa',$li['Cliente']['id']), array('escape' => false));?>&nbsp;
                <?php //echo $this->Form->button(null, array('title'=>'ver mapa', 'id'=>"btnmapa_$n", 'class'=>'boton_mapa')); ?>
                <?php echo $this->Form->button(null, array('title'=>'observaciones', 'id'=>"btnobs_$n", 'class'=>'boton_obs')); ?>
                <?php if($estado == 0):?>
                <?php //echo $this->Html->link('Registrar', array('action'=>'formulario', $li['Cliente']['id']));?>
                <?php echo $this->Html->link($this->Html->image('/images/venta.jpg', array("alt"=>'Registrar venta', 'title'=>'Registrar venta')), array('action'=>'formulario', $li['Cliente']['id']),array('escape' => false));?> &nbsp;
                <?php else:?>
                   <?php echo $this->Html->link($this->Html->image('/images/ventad.jpg', array("alt"=>'Registrar venta', 'title'=>'Registrar venta')), array('action'=>''),array('escape' => false));?>&nbsp;
                <?php endif;?>
             <?php echo $this->Html->link($this->Html->image('/images/recarga.jpg', array("alt"=>'Recargas', 'title'=>'Registrar recarga')), array('controller'=>'distribuidores', 'action'=>'recargasdistribuidor', $li['Cliente']['id'], $li['Cliente']['num_registro']),array('escape' => false));?> &nbsp;
                
<?php echo $this->Html->link($this->Html->image('cuestionario.png',array('title'=>'Evaluar cliente')), array("controller" => "Confcuestionarios" ,'action'=>'verconfcli',$li['Cliente']['id']), array('escape' => false));?>&nbsp;
            </td>
         </tr>
         <script type="text/javascript">
            jQuery(document).ready(function() {
            jQuery("#btnmapa_<?php echo $n?>").click(function() {
            jQuery("#dialog1").dialog().load('ventasdistribuidor/ajaxmapa/<?php echo $li['Cliente']['id'];?>');
            });
            
        });
        </script>
        <script>
          jQuery(document).ready(function() {
            jQuery("#btnobs_<?php echo $n?>").click(function() {
            jQuery("#dialog2").dialog().load('ventasdistribuidor/ajaxobs/<?php echo $li['Cliente']['id'];?>');
            });
            
        });
        </script>
         <?php $n++;?>
      <?php endforeach;?>
   </table>

<script type="text/javascript">
   jQuery(document).ready(function() {

         jQuery("#btnImprimir_<?php echo $n?>").click(function() {
            
             //alert("presiono mapa");
            //printElem({ leaveOpen: true, printMode: 'popup' });
            printElem({ overrideElementCSS: ['http://www.atotic.com/viva/inventario/app/webroot/css/printable.css'] });
         });


     });
 function printElem(options){
     jQuery('#imprime').printElement(options);
 }
</script>
</div>

</div>

</div>
