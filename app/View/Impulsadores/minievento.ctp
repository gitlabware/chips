<div class="with-padding">
    <?php echo $this->Form->create('Impulsadore', array('action' => 'registra_minievento', 'id' => 'form_minievento')); ?>
    <div class="columns">
        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">Direccion <small>(requerido)</small></label>
                <?php echo $this->Form->hidden("Minievento.id");?>
                <?php echo $this->Form->hidden("Minievento.impulsador_id", array('value' => $this->Session->read('Auth.User.id')));?>
                <?php echo $this->Form->text("Minievento.direccion", array('class' => 'input full-width', 'required','placeholder' => 'Ingrese la direccion'));?>
            </p>
        </div>
        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">Fecha <small>(requerido)</small></label>         
            <?php echo $this->Form->date('Minievento.fecha', array('class' => 'input full-width', 'placeholder' => 'Fecha 2015-05+29', 'value' => date("Y-m-d"))); ?>
            </p>
        </div>
        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <label class="label">&nbsp;</label>  
                <button class="button green-gradient full-width">REGISTRAR</button>
            </p>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
