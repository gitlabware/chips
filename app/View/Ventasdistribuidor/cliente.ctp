
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Formulario de cliente</h1>
    </hgroup>
    <div class="with-padding"> 
        <?php echo $this->Form->create(NULL, array('id' => 'formID','url' => array('controller' => 'Ventasdistribuidor','action' => 'registra_cliente'))) ?>
        <?php echo $this->Form->hidden("Cliente.id");?>
        <div class="columns">
            <div class="new-row six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('Cliente.nombre', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="six-columns new-row-mobile twelve-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Direccion<small>(requerido)</small></label>
                    <?php echo $this->Form->text('Cliente.direccion', array('class' => 'input full-width')); ?>
                </p>  
            </div>

            <div class="three-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Celular<small>(requerido)</small></label>
                    <?php echo $this->Form->text('Cliente.celular', array('class' => 'input full-width')); ?>
                </p>
            </div>

            <div class="three-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Zona<small>(requerido)</small></label>
                    <?php echo $this->Form->text('Cliente.zona', array('class' => 'input full-width')); ?>                       
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Mercado<small>(requerido)</small></label>
                    <?php echo $this->Form->text('Cliente.mercado', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Ruta<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('Cliente.ruta_id', $rutas, array('class' => 'select full-width', 'required')); ?>
                </p>
            </div>

            <div class="new six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Inspector<small>(requerido)</small></label>
                    <?php echo $this->Form->text('Cliente.inspector', array('class' => 'input full-width')) ?>

                </p>
            </div>

            

            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Lugar<small>(Requerido)</small></label>
                    <?php echo $this->Form->select("Cliente.lugare_id",$lugares,['class' => 'select full-width','id' => 'validation-select']);?>
                </p>
            </div>
            

            <div class="six-columns new-row-mobile twelve-columns">

                <button type="submit" class="button glossy mid-margin-right" onClick="javascript:verificar()">
                    <span class="button-icon"><span class="icon-tick"></span></span>
                    Guardar
                </button>

                <button type="button" class="button glossy" onclick="window.location.href = '<?php echo $this->Html->url($this->request->referer());?>';">
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

<?php echo $this->element('sidebar/distribuidor'); ?>
