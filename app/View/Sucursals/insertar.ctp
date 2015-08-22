<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nueva Tienda</h1>
    </hgroup>

    <div class="with-padding"> 
        <?php echo $this->Form->create('Sucursal', array('id' => 'formID')) ?>
        <div class="columns">

            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width input validate[required]', 'autofocus')); ?>
                </p>
            </div>
            <div class="six-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label"> Telefono<small>(requerido)</small></label>
                    <?php echo $this->Form->text('telefono', array('class' => 'input full-width')); ?>
                </p>  
            </div>
            <div class="new-row twelve-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Direccion<small>(requerido)</small></label>
                    <?php echo $this->Form->text('direccion', array('class' => 'input full-width')); ?>
                </p>  
            </div>


            <div class="new-row six-columns">

                <button type="submit" class="button glossy mid-margin-right" onClick="javascript:verificar()">
                    <span class="button-icon"><span class="icon-tick"></span></span>
                    Guardar
                </button>

                <button type="button" class="button glossy">
                    <span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>
                    Cancelar
                </button>

            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</section>

<script>
  $(document).ready(function () {
      $("#formID").validationEngine();
  });
</script>
<!-- Sidebar/drop-down menu -->
<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
<!-- End sidebar/drop-down menu --> 