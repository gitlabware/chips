<?php echo $this->Form->create('Ventasdistribuidor');?>
<div class="ui-field-contain">
    <label for="textinput-1">Usuario:</label>
    <?php echo $this->Form->text('User.username',array('placeholder' => 'Ingrese el Usuario','required'));?>
</div>
<div class="ui-field-contain">
    <label for="textinput-1">Password:</label>
    <?php echo $this->Form->password('User.password',array('placeholder' => 'Ingrese el password','required'));?>
</div>
<div class="ui-input-btn ui-btn ui-btn-b">
        Ingresar
        
        <?php echo $this->Form->submit("Ingresar",array('data-enhanced' => true));?>
</div>
<?php echo $this->Form->end();?>