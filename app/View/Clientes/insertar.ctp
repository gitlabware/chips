<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nuevo Cliente</h1>
    </hgroup>

    <div class="with-padding"> 
        <?php echo $this->Form->create('Cliente', array('id' => 'formID')) ?>
        <div class="columns">
            <?php if($this->Session->read('Auth.User.Group.name') == 'Administradores'):?>
            <div class="new-row six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Codigo 149 <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('num_registro', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <?php endif;?>
            <div class="new-row six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="six-columns new-row-mobile twelve-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Direccion<small>(requerido)</small></label>
                    <?php echo $this->Form->text('direccion', array('class' => 'input full-width')); ?>
                </p>  
            </div>

            <div class="three-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Celular<small>(requerido)</small></label>
                    <?php echo $this->Form->text('celular', array('class' => 'input full-width')); ?>
                </p>
            </div>

            <div class="three-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Zona<small>(requerido)</small></label>
                    <?php echo $this->Form->text('zona', array('class' => 'input full-width')); ?>                       
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Mercado<small>(requerido)</small></label>
                    <?php echo $this->Form->text('mercado', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Ruta<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('ruta_id', $rutas, array('class' => 'select', 'style' => 'width: 222px', 'required')); ?>
                </p>
            </div>

            <div class="new six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Inspector<small>(requerido)</small></label>
                    <?php echo $this->Form->text('inspector', array('class' => 'input full-width')) ?>

                </p>
            </div>

            

            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Lugar<small>(Requerido)</small></label>
                    <select id="validation-select" name="data[cliente][lugare_id]" class="select" style="width: 222px">
                        <?php foreach ($lugares as $lug): ?>
                            <option value="<?php echo $lug['Lugare']['id'] ?>">
                                <?php echo $lug['Lugare']['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>

            <div class="six-columns new-row-mobile twelve-columns">

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

<script>
    $(document).ready(function () {
        $("#formID").validationEngine();
    });
</script>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Distribuidores'): ?>
    <!-- Sidebar/drop-down menu -->
    <?php echo $this->element('sidebar/distribuidor'); ?>
    <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
    <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
