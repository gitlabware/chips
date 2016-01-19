<h3 id="tit-entregas">
    Fomulario de entregas
</h3>

<div class="six-columns six-columns-tablet twelve-columns-mobile" id="mod-normal">
    <?php echo $this->Form->create('Almacenes', array('class' => 'columns', 'id' => 'formID')) ?>
    <?php
    if ($almacen == 1) {
      echo $this->Form->hidden('Movimiento.almacene_id', array('value' => $idPersona));
    } else {
      echo $this->Form->hidden('Movimiento.persona_id', array('value' => $idPersona));
    }
    ?>
    <h3 class="thin underline">
        Ingresar datos de registro
    </h3>
    <fieldset class="fieldset">
        <legend class="legend">
            Datos de entrega
        </legend>
        <p class="button-height inline-label">
            <label for="validation-select" class="label">
                Fecha
            </label>
            <?php echo $this->Form->date('Movimiento.created', array("class" => 'input full-width validate[required]', 'value' => date('Y-m-d'))); ?>
        </p> 
        <p class="button-height inline-label">
            <label for="validation-select" class="label">
                Categor&iacute;as
            </label>
            <select id="validation-select1" name="data[Movimiento][categoria]" class="select validate[required]" style="width: 200px">
                <option value="">
                    Seleccione la categor&iacute;a
                </option>
                <?php foreach ($categorias as $categoria): ?>
                  <option value="<?php echo $categoria['Tiposproducto']['id'] ?>">
                      <?php echo $categoria['Tiposproducto']['nombre'] ?>
                  </option>
                <?php endforeach; ?>
            </select>
        </p>


        <div id="validation-select2">
            <p class="button-height inline-label">
                <label for="validation-select" class="label">
                    Productos
                </label>

                <select  name="data[Movimiento][producto_id]" class="select expandable-list anthracite-gradient glossy validate[required]" tabindex="2">
                    <option value="" >
                        Seleccione un producto
                    </option>
                </select>

            </p>
        </div>

        <p class="button-height inline-label">
            <label for="input-text" class="label">
                Cantidad
            </label>
            <?php echo $this->Form->text('Movimiento.ingreso', array('class' => 'input validate[required,custom[integer]]')) ?>
        </p>


        <div id="rangos" style="display: none;">
            <p class="button-height inline-label">
                <label for="input-text" class="label">
                    Rango inicial
                </label>
                <?php echo $this->Form->text('Detalle.rangoi', array("class" => 'input validate[required, custom[integer]]', 'value' => 0)) ?>
            </p>

            <p class="button-height inline-label">
                <label for="text" class="label">Rango final</label>
                <?php echo $this->Form->text('Detalle.rangof', array("class" => 'input validate[required, custom[integer]]', 'value' => 0)) ?>
            </p>
            <p class="button-height inline-label">
                <label for="text" class="label">Numero de Lote</label>
                <?php echo $this->Form->text('Detalle.lote', array("class" => 'input validate[required, custom[integer]]', 'value' => 0)) ?>
            </p>
        </div><br>
        <div class="button-height">
            <button class="button blue-gradient full-width" type="submit">Registrar</button>
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>




<script>
  $(document).ready(function () {
      
      $("#formID").validationEngine();
      
      $("#validation-select1").change(function () {
          if (this.value == 1) {
              $('#rangos').show();
              
          } else {
              $('#rangos').hide();
          }
          console.log('cambia productos');
          $('#validation-select2').load('<?php echo $this->Html->url(array('action' => 'ajaxproductos')) ?>/' + this.value + '/<?php echo $cent; ?>');
      });
      
      //para la segunda parte....
      /*$("#validation-select12").change(function () {
       console.log('cambia productos');
       $('#validation-select22').load('<?php //echo $this->Html->url(array('action' => 'ajaxproductos2'))   ?>/' + this.value + '/<?php echo $cent; ?>');
       });*/
      
      
  });
</script>
