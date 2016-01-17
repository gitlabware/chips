<h3 id="tit-entregas">
    Fomulario de ventas Chips <?php echo date('Y-m-d'); ?>
</h3>

<div class="twelve-columns" id="mod-normal">
    <?php echo $this->Form->create('Chip', array('class' => 'columns', 'id' => 'form-reg')) ?>
    <fieldset class="fieldset">

        <p class="button-height inline-label">
            <label for="input-text " class="label">
                Cliente
            </label>
            <?php echo $this->Form->text("Ventasimpulsadore.nombre_cliente", array('class' => 'input full-width', 'required')) ?>
        </p>
        <p class="button-height inline-label">
            <label for="input-text " class="label">
                # <?php echo $chip['Chip']['telefono'] ?>
            </label>
            <?php echo $this->Form->select("Ventasimpulsadore.precio_chip", $precios_chip, array('class' => 'select full-width', 'required', 'empty' => 'Seleccione el Precio del chip')) ?>
        </p>
        <p class="button-height inline-label">
            <label for="input-text " class="label">
                Premio
            </label>
            <select class="select full-width" name="premio" id="sel-premio">
                <option value="">Seleccione el Premio</option>
                <?php foreach ($premios as $key => $pre): ?>
                  <option value="<?php echo $key ?>"><?php echo '(' . $pre['pro']['precio'] . ')', '(' . $pre['tot']['total'] . ') ' . $pre['productos']['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php //echo $this->Form->select("Ventasimpulsadore.premio_id", $premios, array('class' => 'select full-width', 'required', 'empty' => 'Seleccione el Precio del chip')) ?>
        </p>
        <p class="button-height inline-label">
            <label for="input-text " class="label">
                Referencia
            </label>
            <?php echo $this->Form->text("Ventasimpulsadore.tel_referencia", array('class' => 'input full-width', 'placeholder' => 'Ingrese la referencia')) ?>
        </p>

        <div class="button-height">
            <button class="button blue-gradient full-width" type="submit">Registrar</button>
        </div>
    </fieldset>
    <?php echo $this->Form->hidden("Ventasimpulsadore.producto_id", array('id' => 'idproducto')); ?>
    <?php echo $this->Form->hidden("Ventasimpulsadore.precio_producto", array('id' => 'idprecio_prod')); ?>
    <?php echo $this->Form->hidden("Ventasimpulsadore.minievento_id", array('value' => $idMiniEvento)); ?>
    <?php echo $this->Form->hidden("Ventasimpulsadore.numero", array('value' => $chip['Chip']['telefono'])); ?>
    <?php echo $this->Form->hidden("Ventasimpulsadore.chip_id", array('value' => $chip['Chip']['id'])); ?>
    <?php //echo $this->Form->hidden("Ventasimpulsadore.user_id", array('value' => $this->Session->read('Auth.User.id'))); ?>
    <?php echo $this->Form->end(); ?>
</div>


<script>
  var premios = [];
<?php foreach ($premios as $key => $pre): ?>
    premios[<?php echo $key ?>] = [];
    premios[<?php echo $key ?>]['precio'] = <?php echo $pre['pro']['precio']; ?>;
    premios[<?php echo $key ?>]['producto_id'] = <?php echo $pre['productos']['id']; ?>;
<?php endforeach; ?>
  $('#sel-premio').change(function () {
      if ($('#sel-premio').val() != '') {
          $('#idprecio_prod').val(premios[$('#sel-premio').val()]['precio']);
          $('#idproducto').val(premios[$('#sel-premio').val()]['producto_id']);
      }
  });

  /* $("#form-reg").submit(function (e)
   {
   var postData = $(this).serializeArray();
   var formURL = '<?php //echo $this->Html->url(array('controller' => 'Chips', 'action' => 'registra_ventachips'));           ?>';
   $.ajax(
   {
   url: formURL,
   type: "POST",
   data: postData,
   success: function (data, textStatus, jqXHR)
   {
   if ($.parseJSON(data).correcto != '') {
   mensaje_nota('Excelente!!', $.parseJSON(data).correcto);
   } else {
   mensaje_nota('Error!!', $.parseJSON(data).incorrecto);
   }
   
   $('#idmodal').load('<?php //echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'ajax_venta', $fecha_ini, $fecha_fin, $persona, $idProducto));           ?>');
   //data: return data from server
   //$("#div-ventas").html(data);
   },
   error: function (jqXHR, textStatus, errorThrown)
   {
   //if fails   
   alert("error");
   }
   });
   e.preventDefault(); //STOP default action
   //e.unbind(); //unbind. to stop multiple form submit.
   });*/
</script>