<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nuevo Producto Cabina </h1>
    </hgroup>
    <div class="with-padding"> 

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    
         <?php echo $this->Form->create('Recargascabina',array('id'=>'formID')); ?>
        <form method="post" action="" class="columns" onsubmit="return false">                               
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <h3 class="thin underline">&nbsp;</h3>                                          

                <fieldset class="fieldset fields-list">

                    <legend class="legend">formulario </legend>
                    <div class="field-block button-height">
                    <p >
                        <label for="validation-select" class="label">
                            <b>Categoria</b>
                        </label>
                        <select id="validation-select1"  class="select validate[required]" >
                            <option value="">
                                Seleccione la categor&iacute;a
                            </option>
                            <?php foreach ($categoria as $cate): ?>
                                <option value="<?php echo $cate['Tiposproducto']['id'] ?>">
                                    <?php echo $cate['Tiposproducto']['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </p>									
                    </div>
                    <div  id="validation-select2" class="field-block button-height">							
                        <label class="label"><b>Producto</b></label>
                        <select class="select validate[required]">
                            <option value="">Seleccione producto</option>
                        </select>
                    </div>
                    
                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Monto</b></label>
                        <?php echo $this->Form->text('monto', array('class' => 'input','required','name'=>'data[Recargascabina][monto]')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>
                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Monto Recarga</b></label>
                        <?php echo $this->Form->text('monto_recarga', array('class' => 'input','required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>
                    

                   
                    <div class="field-block button-height">

                        <button type="submit" class="button glossy mid-margin-right">
                            <span class="button-icon"><span class="icon-tick"></span></span>
                            Guardar
                        </button>

                        <button type="submit" class="button glossy">
                            <span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>
                            Cancelar
                        </button>

                    </div>

                </fieldset>
            </div>

        </form>

    </div>

</section>

<script>
    $(document).ready(function() {
        $("#formID").validationEngine();
        $("#validation-select1").change(function() {
            $('#validation-select2').load('<?php echo $this->Html->url(array('action' => 'ajaxproductos')) ?>/' + this.value);
        });
    });
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 