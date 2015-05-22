<h1>Nueva Venta por Fecha</h1>
<?php echo $this->Form->create(null, array('url'=>array('controller'=>'Ventasdistribuidor', 'action'=>'registrafecha_mobile')))?>
<label for="login" class="label"><b>Codigo 149</b></label>
<?php echo $this->Form->text('Cliente.codigo', array('required')); ?>
<label for="" class="label"><b>Ingrese la fecha:</b></label>
<?php echo $this->Form->text('Cliente.fecha', array('data-role' => 'date','required','data-inline'=>'true')); ?>
<br />

<div class="ui-input-btn ui-btn ui-btn-b ui-icon-check ui-btn-icon-left ui-shadow-icon">
    Vender
    
    <?php echo $this->Form->submit('Vender',array('data-enhanced' => true));?>
</div>
<?php echo $this->Form->end();?>