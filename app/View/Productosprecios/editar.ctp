<section class="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>editar Precio</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Productosprecio', array('id' => 'formID')); ?>
        <div class="columns">
            <div class="new-row six-columns">
                <p class=" block-label button-height">
                    <label for="label-block-1" class="label">Escala<small>(Requerido)</small></label>
                    <?php echo $this->Form->text('escala', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="label-block-2" class="label">Para Quien<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('tipousuario_id', $tipos, array('class' => 'select', 'required')); ?>
                </p>
            </div>
            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="label-block-3" class="label">Precio<small>(Requerido)</small></label>
                    <?php echo $this->Form->text('precio', array('class' => 'input full-qidth')); ?>
                </p>
            </div>
            <div class="new-row six-columns">
                <button type="submit" class="button glossy mid-margin-right">
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