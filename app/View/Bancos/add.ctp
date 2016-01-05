<section role="main" id="main">

    <hgroup id="main-title" class="thin">
        <h1>Nuevo Banco</h1>
    </hgroup>
    <?php echo $this->Form->create('Banco', array('id' => 'formID')); ?>
    <div class="with-padding"> 

        <div class="columns">

            <div class="new-row six-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width', 'placeholder' => 'Ingrese el nombre del banco')); ?>
                </p>
            </div>
            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Total <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('total', array('class' => 'input full-width', 'placeholder' => 'Ingrese el total del banco')); ?>
                </p>
            </div>
            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Sucursal <small>(requerido)</small></label>                    
                <p class="button-height">
                    <?php echo $this->Form->select('sucursal_id',$sucursales,array('class' => 'select blue-gradient full-width','empty' => 'Seleccione La Sucursal'))?>
                    
                </p>
                </p>
            </div>
            <div class="new-row six-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Descripcion<small>(requerido)</small></label>
                    <?php echo $this->Form->textarea('descripcion', array('class' => 'input full-width autoexpanding', 'style' => 'overflow: hidden; resize: none; height: 50px;', 'placeholder' => 'Descripcion lugar')); ?>
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
<?php echo $this->element('sidebar/administrador'); ?>