
   <div class="grid-5">
      <!--<div class="title-grid">
         <span>Observaciones</span>
      </div>-->
      <div class="content-gird">
      
         <?php echo $this->Form->create('Detalleobservacione');?>
          <table>
             <tr>
                <td>Opci&oacute;n:</td>
                <td><?php echo $this->Form->select('observacion_id', $obse);?></td>
             </tr>
             <tr>
                <td>Texto:</td>
                <td><?php echo $this->Form->textarea('descripcion', array('cols'=>5, 'rows'=>7));?></td>

             </tr>
          </table>
         <?php echo $this->Form->hidden("cliente_id", array('value'=>$id_cli));?>
         <?php echo $this->Form->hidden("distribuidor_id", array('value'=>$idusu));?>
          <?php $fecha = date("Y-m-d");?>
          <?php echo $this->Form->hidden("fecha_registro", array('value'=>$fecha));?>
         <?php $opt = array('Value'=>'registrar', 'class'=>'boton');?>
         <?php echo $this->Form->end($opt);?>
      </div>
   </div>
