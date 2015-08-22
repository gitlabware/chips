<h1>Cambio de Password</h1>
<?php echo $this->Form->create('Ventasdistribuidor'); ?>
<div class="ui-field-contain">
    <label for="textinput-1">Password:</label>
    <?php echo $this->Form->password('User.password', array('placeholder'=>'Inserte Nuevo Password','class' => 'span12', 'required', 'value'=>'')); ?>
</div>
<div class="ui-input-btn ui-btn ui-btn-b">
        Cambiar Password
        
        <?php echo $this->Form->submit("Cambiar Password",array('data-enhanced' => true));?>
</div>
<?php echo $this->Form->end();?>
