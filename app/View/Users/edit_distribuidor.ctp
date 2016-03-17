<section role="main" id="main">
    <div class="with-padding">
        <?php echo $this->Form->create('User') ?>
        <form method="post" action="" class="columns" onsubmit="return false">
            <div class="twelve-columns twelve-columns-tablet twelve-columns-mobile">
                <h3 class="thin underline">Datos del usuario</h3>
                <fieldset class="fieldset">
                    <div class="columns">
                        <div class="four-columns twelve-columns-mobile">
                            <p class="button-height inline-label">
                                <label for="input-3" class="label">Nombres</label>
                                <?php echo $this->Form->text('Persona.nombre', array('class' => 'input full-width', 'required')); ?>
                            </p>
                        </div>
                        <div class="four-columns twelve-columns-mobile">
                            <p class="button-height inline-label">
                                <label for="input-3" class="label">Ap. materno</label>
                                <?php echo $this->Form->text('Persona.ap_paterno', array('class' => 'input full-width')); ?>
                            </p>
                        </div>
                        <div class="four-columns twelve-columns-mobile">
                            <p class="button-height inline-label">
                                <label for="input-3" class="label">Ap. paterno</label>
                                <?php echo $this->Form->text('Persona.ap_materno', array('class' => 'input full-width')); ?>
                            </p>
                        </div>
                    </div>
                    <div class="new-row columns">
                        <div class="four-columns twelve-columns-mobile">
                            <p class="button-height inline-label">
                                <label for="input-3" class="label">Celular</label>
                                <?php echo $this->Form->text('Persona.celular', array('class' => 'input full-width', 'required')); ?>
                            </p>
                        </div>
                        <div class="four-columns twelve-columns-mobile">
                            <p class="button-height inline-label">
                                <label for="input-3" class="label">Usuario</label>
                                <?php echo $this->Form->text('User.username', array('class' => 'input full-width', 'disabled')); ?>
                            </p>
                        </div>
                        <div class="four-columns twelve-columns-mobile">
                            <p class="button-height inline-label">
                                <label for="input-3" class="label">Contrase&ntilde;a</label>
                                <?php echo $this->Form->password('User.password2', array('class' => 'input full-width')); ?>
                            </p>
                        </div>
                    </div>
                </fieldset>
                <div class="button-height"><button type="submit" class="button blue-gradient">Registrar datos</button></div>
            </div>
            
            <?php echo $this->Form->hidden('Persona.id')?>
            <?php echo $this->Form->hidden('User.id')?>
            <?php echo $this->Form->end(); ?>
    </div>
</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu -->