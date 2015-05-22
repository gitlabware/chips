<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nuevo Almacen</h1>
    </hgroup>

    <div class="with-padding"> 
        <?php echo $this->Form->create('Almacene', array('id' => 'formID')) ?>
        <div class="columns">

            <div class="new-row six-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width')); ?>
                </p>
            </div>
            
            <div class="six-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Tienda<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('sucursal_id', $sucursals, array('class' => 'select full-width','required')); ?>
                </p>
            </div>
            
            <div class="twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Descripcion<small>(requerido)</small></label>
                    <?php echo $this->Form->textarea('descripcion', array('class' => 'input full-width')); ?>
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
<script>
    $(document).ready(function () {
        $("#formID").validationEngine();
    });
</script>
<?php if ($this->Session->read('Auth.User.Group.name')=='Almaceneros'):?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name')=='Administradores'):?>
<?php echo $this->element('sidebar/administrador');?>
<?php endif; ?>
