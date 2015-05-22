
<h1>REPORTE POR FECHA</h1>
<?php echo $this->Form->create('Ventasdistribuidor'); ?>
<div class="ui-field-contain">
    <label for="textinput-1">Ingrese la fecha:</label>
    <?php echo $this->Form->text('fecha', array('data-role' => 'date','required','data-inline'=>'true','id' => 'fechap')); ?>
</div>
<div class="ui-input-btn ui-btn ui-btn-b">
        Generar Reporte
        
        <?php echo $this->Form->submit("Generar Reporte",array('data-enhanced' => true));?>
</div>

<?php echo $this->Form->end();?>
