<div class="with-padding">
    <?php echo $this->Form->create('Marca', array('id' => 'form_f')); ?>
    <?= $this->Form->hidden('Marca.id') ?>
    <div class="columns">

        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">Nombre Marca </label>                    
                <?php echo $this->Form->text('nombre', array('class' => 'input full-width', 'placeholder' => 'Nombre','required')); ?>
            </p>
        </div>
        <div class="new-row twelve-columns">
            <p class="block-label button-height">
                <button type="submit" class="button green-gradient full-width">REGISTRAR</button>
            </p>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

</div>

