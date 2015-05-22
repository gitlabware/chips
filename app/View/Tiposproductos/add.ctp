<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nueva Categoria</h1>
    </hgroup>
    <?php echo $this->Form->create('Tiposproducto', array('id' => 'formID')); ?>
    <div class="with-padding"> 

        <div class="columns">

            <div class="new-row six-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width', 'placeholder' => 'Ingrese el nombre de la categoria', 'value' => "", 'required')); ?>
                </p>
            </div>
            <div class="six-columns">                
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Color Categoria<small>(requerido)</small></label>
                    <select id="validation-select" name="data[Tiposproducto][desc]" class="select validate[required] full-width">
                        <option value="black">Negro</option>
                        <option value="anthracite">Plomo</option>
                        <option value="grey">Gris</option>
                        <option value="white">Blanco</option>
                        <option value="red">Rojo</option>
                        <option value="orange">Anaranjado</option>
                        <option value="green">Verde</option>
                        <option value="blue">Azul</option>
                    </select>
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





