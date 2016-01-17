<div class="with-padding">
    <?php echo $this->Form->create('Users', array('action' => 'registra_precios')); ?>
    <div class="columns">
        <?php foreach ($precios as $key => $pre):?>
        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <label class="label"><?php echo $pre['Precio']['descripcion']?></label> 
                <?php echo $this->Form->hidden("Precio.$key.id",array('value' => $pre['Precio']['id']))?>
                <?php echo $this->Form->text("Precio.$key.monto",array('value' => $pre['Precio']['monto'],'class' => 'input full-width','type' => 'number','step' => 'any'));?>
            </p>
        </div>
        <?php endforeach;?>
        <?php $key++;?>
        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <label class="label">Nuevo precio Chip</label> 
                <?php echo $this->Form->hidden("Precio.$key.id",array('value' => NULL))?>
                <?php echo $this->Form->hidden("Precio.$key.descripcion",array('value' => 'Chips'))?>
                <?php echo $this->Form->text("Precio.$key.monto",array('value' => '','class' => 'input full-width','type' => 'number','step' => 'any'));?>
            </p>
        </div>
        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <label class="label">&nbsp;</label> 
                <?php echo $this->Form->submit('GUARDAR',array('class' => 'button green-gradient full-width'));?>
            </p>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

    
</div>
