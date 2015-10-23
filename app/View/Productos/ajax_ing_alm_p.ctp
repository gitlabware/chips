<div class="with-padding">
    <?php echo $this->Form->create('Producto'); ?>
    <div class="columns">
        <div class="twelve-columns">
            <p class="block-label button-height">
                <label style="font-weight: bold;font-size: 17px;">PRODUCTO: <?= $producto['Producto']['nombre']; ?> </label>
            <h4 align="center">Ingreso a almacen Central (TOTAL: <?= $totalProducto ?>)</h4>
            </p>
        </div>

        <div class="three-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">Cantidad</label>
            </p>
        </div>
        <div class="nine-columns">
            <p class="block-label button-height">                   
                <?php echo $this->Form->text('ingreso', array('class' => 'input full-width', 'placeholder' => 'Ingrese la cantidad a ingresar', 'type' => 'number', 'required')); ?>
            </p>
        </div>
        <div class="twelve-columns">
            <p class="block-label button-height">
                <label class="label">&nbsp;</label>  
                <button type="submit" class="button green-gradient full-width" >INGRESAR</button>
            </p>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

</div>
