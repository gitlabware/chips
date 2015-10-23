<div class="with-padding">
    <?php echo $this->Form->create('Tienda', array( 'id' => 'form_cambio')); ?>
    <?= $this->Form->hidden('Celcambio.producto_id' ,array('value' => $venta['Ventascelulare']['producto_id']))?>
    <?= $this->Form->hidden('Celcambio.ventascelulare_id' ,array('value' => $venta['Ventascelulare']['id']))?>
    <?= $this->Form->hidden('Celcambio.sucursal_id' ,array('value' => $venta['Ventascelulare']['sucursal_id']))?>
    <?= $this->Form->hidden('Celcambio.imei_anterior' ,array('value' => $venta['Ventascelulare']['imei']))?>
    <?= $this->Form->hidden('Celcambio.num_serie_anterior' ,array('value' => $venta['Ventascelulare']['num_serie']))?>
    <div class="columns">

        <div class="new-row six-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">IMEI Actual </label>                    
                <?php echo $this->Form->text('Celcambio.a_imei_anterior', array('class' => 'input full-width', 'placeholder' => 'IMEI', 'value' => $venta['Ventascelulare']['imei'],'disabled')); ?>
            </p>
        </div>
        <div class="six-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label"># SERIE Actual </label>                    
                <?php echo $this->Form->text('Celcambio.a_num_serie_anterior', array('class' => 'input full-width', 'placeholder' => '# SERIE', 'value' => $venta['Ventascelulare']['num_serie'],'disabled')); ?>
            </p>
        </div>
        <div class="new-row six-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">IMEI Nuevo </label>                    
                <?php echo $this->Form->text('Celcambio.imei_nuevo', array('class' => 'input full-width', 'placeholder' => 'Ingrese el IMEI Nuevo')); ?>
            </p>
        </div>
        <div class="six-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label"># SERIE Nuevo </label>                    
                <?php echo $this->Form->text('Celcambio.num_serie_nuevo', array('class' => 'input full-width', 'placeholder' => 'Ingrese el # Serie Nuevo')); ?>
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

