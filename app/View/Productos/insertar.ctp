<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nuevo Producto</h1>
    </hgroup>

    <?php echo $this->Form->create('Producto', array('id' => 'formID', 'enctype' => 'multipart/form-data'), array('type' => 'file')); ?>
    <div class="with-padding"> 

        <div class="columns">

            <div class="new-row four-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width input validate[required]', 'placeholder' => 'Ingrese el nombre del producto.', 'autofocus')); ?>
                </p>
            </div>
            <div class="four-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Precio Compra<small>(requerido)</small></label>
                    <?php echo $this->Form->text('precio_compra', array('class' => 'input full-width input validate[required]', 'placeholder' => 'Ingrese el precio.')); ?>
                </p>  
            </div>

            <div class="four-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Proveedor<small>(opcional)</small></label>
                    <?php echo $this->Form->text('proveedor', array('class' => 'input full-width', 'placeholder' => 'Ingrese el nombre del proveedor.')); ?>
                </p>  
            </div>

            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Producto <small>(requerido)</small></label>

                    <select id="validation-select" name="data[Producto][tiposproducto_id]" class="select input validate[required]" style="width: 310px">
                        <option value=""></option>  
                        <?php foreach ($tiposproductos as $tip): ?>
                          <option value="<?php echo $tip['Tiposproducto']['id'] ?>" data-valor="eynar">
                              <?php echo $tip['Tiposproducto']['nombre'] ?>
                          </option>
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
            <div id="divplus-escala" style="display: none;" class="new-row four-columns">
                <p class="block-label button-height">
                    <label class="label">Escala</label>
                    <?php echo $this->Form->select('Productosprecio.escala', array('DISTRIBUIDOR' => 'DISTRIBUIDOR', 'TIENDA' => 'TIENDA'), array('class' => 'select full-width input validate[required]')); ?>
                </p>
            </div>
            <div id="divplus-precio" style="display: none;" class="four-columns">
                <p class="block-label button-height">
                    <label class="label">Precio de venta ($u$)</label>
                    <?php echo $this->Form->text('precio_venta', array('class' => 'input full-width input validate[required]', 'type' => 'number', 'step' => 'any')); ?>
                </p>
            </div>
            <div id="divplus-cantidad" style="display: none;" class="four-columns">
                <p class="block-label button-height">
                    <label class="label">Cantidad en Almacen central</label>
                    <?php echo $this->Form->text('cantidad_central', array('class' => 'input full-width input validate[required]', 'type' => 'number', 'min' => 0)); ?>
                </p>
            </div>
            <div class="new-row twelve-columns">
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Observaciones<small>(Requerido)</small></label>
                    <textarea name="data[Producto][observaciones]" class="input full-width"></textarea>
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
          if (categoria[$('#validation-select').val()] == 'TARJETAS' || categoria[$('#validation-select').val()] == 'CHIPS') {
              $('#iddivimagen').removeClass('eight-columns');
              $('#iddivimagen').addClass('four-columns');
              $('#iddivmarca').show(200);
              $('#divplus-escala').show(200);
              $('#divplus-precio').show(200);
              $('#divplus-cantidad').show(200);
          } else {
              $('#iddivimagen').removeClass('four-columns');
              $('#iddivimagen').addClass('eight-columns');
              $('#iddivmarca').hide(200);
              $('#divplus-escala').hide(200);
              $('#divplus-precio').hide(200);
              $('#divplus-cantidad').hide(200);
          }
      });
      $("#formID").validationEngine();
  });
</script>
<?php echo $this->Html->script(array('libs/ckeditor/ckeditor','inickeditor'), array('block' => 'js_add'));?>