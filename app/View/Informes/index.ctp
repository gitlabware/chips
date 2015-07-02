<section role="main" id="main">

    <hgroup id="main-title" class="thin">
        <h1>Formularios de informes</h1>
    </hgroup>

    <div class="with-padding">                   
        <div class="columns">
            <div class="twelve-columns">
                <fieldset class="fieldset">
                    <legend class="legend">HOJA DE RUTEO CONSOLIDADO DISTRIBUIDORES</legend>
                    <div class="columns">
                        <div class="six-columns">
                            <p class="block-label button-height inline-label">
                                <label for="input-1" class="label">Fecha Inicial</label>
                                <span class="input">
                                    <span class="icon-calendar"></span>
                                    <input type="text" name="special-input-3" id="special-input-3" class="input-unstyled datepicker" value="">
                                </span>
                            </p>
                        </div>
                        <div class="six-columns">
                            <p class="inline-label">
                                <label for="input-1" class="label">Unstyled input</label>
                                <input type="text" name="input-1" id="input-1" size="9" value="Unstyled text input">
                            </p>
                        </div>
                        <div class="new-row twelve-columns">
                            <p class="inline-label">
                                <?php echo $this->Form->submit("GENERAR", array('class' => 'button anthracite-gradient glossy full-width')); ?>
                            </p>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</section>	
<?php echo $this->element('sidebar/administrador'); ?>
