<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nuevo Precio</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Productosprecio', array('id' => 'formID')); ?>
        <?php echo $this->Form->hidden('fecha', array('value' => date('Y-m-d'))); ?>
        <div class="columns">

            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Producto<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('producto_id', $productos, array('class' => 'select')); ?>
                </p>
            </div>

            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Escala<small>(Requerido)</small></label>
                    <select id="validation-select1" name="data[Productosprecio][escala_id]" class="select" style="width: 200px">
                        <option value="">
                            Seleccione la escala...
                        </option>
                        <?php foreach ($escalas as $e): ?>
                            <option value="<?php echo $e['Escala']['id'] ?>">
                                <?php echo $e['Escala']['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>

            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Para Quien<small>(Requerido)</small></label>
                    <select id="validation-select1" name="data[Productosprecio][tipousuario_id]" class="select" style="width: 200px">
                        <option value="">
                            Seleccione para quienes...
                        </option>
                        <?php foreach ($usuarios as $e): ?>
                            <option value="<?php echo $e['Tipousuario']['id'] ?>">
                                <?php echo $e['Tipousuario']['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>

            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Precio<small>(Requerido)</small></label>
                    <?php echo $this->Form->text('precio', array('class' => 'input full-width')); ?>
                </p>
            </div>

            <div class="new-row six-columns">

                <button type="submit" class="button glossy mid-margin-right" onClick="javascript:verificar()">
                    <span class="button-icon"><span class="icon-tick"></span></span>
                    Guardar
                </button>

                <button type="submit" class="button glossy">
                    <span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>
                    Cancelar
                </button>

            </div>
        </div>
    </div>
</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 