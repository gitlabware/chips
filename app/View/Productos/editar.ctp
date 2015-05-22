<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Editar Producto</h1>
    </hgroup>
    <?php echo $this->Form->create('Producto', array('id' => 'formID', 'enctype' => 'multipart/form-data'), array('type' => 'file')); ?>
    <div class="with-padding"> 

        <div class="columns">

            <div class="new-row four-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="four-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Precio<small>(requerido)</small></label>
                    <?php echo $this->Form->text('precio_compra', array('class' => 'input full-width')); ?>
                </p>  
            </div>

            <div class="four-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Proveedor<small>(requerido)</small></label>
                    <?php echo $this->Form->text('proveedor', array('class' => 'input full-width')); ?>
                </p>  
            </div>

            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Producto <small>(requerido)</small></label>

                    <select id="validation-select" name="data[Cliente][lugar_id]" class="select validate[required]" class="input full-width" style="width: 300px">
                        <?php foreach ($tiposproductos as $t): ?>
                          <?php if ($t['Tiposproducto']['id'] == $this->request->data['Producto']['tiposproducto_id']): ?>
                            <option value="<?php echo $t['Tiposproducto']['id'] ?>" selected="selected">
                                <?php echo $t['Tiposproducto']['nombre'] ?>
                            </option>
                          <?php else: ?>
                            <option value="<?php echo $t['Tiposproducto']['id'] ?>">
                                <?php echo $t['Tiposproducto']['nombre'] ?>
                            </option>
                          <?php endif; ?>    
                        <?php endforeach; ?>
                    </select>
                </p>  
            </div>

            <div class="eight-columns" id="iddivimagen">
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Imagen</label>
                    <?php echo $this->Form->text('imagen', array('class' => 'file full-width', 'type' => 'file')); ?>
                </p>
            </div>
            <div class="four-columns" style="display: none;" id="iddivmarca">
                <p class="block-label button-height">
                    <label class="label">Marca</label>
                    <?php echo $this->Form->select('marca_id', $marcas, array('class' => 'select full-width')); ?>
                </p>
            </div>
            <div class="new-row twelve-columns">
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Observaciones<small>(Requerido)</small></label>
                    <textarea name="data[Producto][observaciones]" id="ckeditor"><?php echo $this->request->data['Producto']['observaciones']?></textarea>
                    <?php //echo $this->Form->text('observaciones', array('class' => 'input full-width', 'id' => 'ckeditor')); ?>
                </p>
            </div>

            <div class="new-row twelve-columns">

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
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 
<script>
  var categoria = [];
<?php foreach ($tiposproductos as $tip): ?>
    categoria[<?php echo $tip['Tiposproducto']['id'] ?>] = '<?php echo $tip['Tiposproducto']['nombre'] ?>';
<?php endforeach; ?>
  $(document).ready(function () {
      $('#validation-select').change(function () {
          muestra_marcas();
      });
      function muestra_marcas() {
          if (categoria[$('#validation-select').val()] == 'CELULARES') {
              $('#iddivimagen').removeClass('eight-columns');
              $('#iddivimagen').addClass('four-columns');
              $('#iddivmarca').show(200);
          } else {
              $('#iddivimagen').removeClass('four-columns');
              $('#iddivimagen').addClass('eight-columns');
              $('#iddivmarca').hide(200);
          }
      }
      $("#formID").validationEngine();
      muestra_marcas();
  });
</script>

<!-- CKEditor -->
<script src="<?php echo $this->webroot; ?>js/libs/ckeditor/ckeditor.js"></script>

<script>

// Call template init (optional, but faster if called manually)
  $.template.init();

// CKEditor
  CKEDITOR.replace('ckeditor', {
      height: 300
  });

</script>