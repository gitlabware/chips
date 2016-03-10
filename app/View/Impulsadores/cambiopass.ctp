<h3>
    Formulario de Password
</h3>
<div class="twelve-columns" id="mod-normal">
    <?php echo $this->Form->create('Venstasimpulsadore', array('class' => 'columns')) ?>
    <fieldset class="fieldset">
        <p class="button-height inline-label">
            <label for="input-text" class="label">
                Nuevo Password
            </label>
            <?php echo $this->Form->password("Dato.password", array('class' => 'input required')) ?>
        </p>
        <div class="button-height">
            <button class="button blue-gradient full-width" type="submit">Registrar</button>
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>