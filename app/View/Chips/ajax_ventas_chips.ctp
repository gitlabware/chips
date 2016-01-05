<h3 id="tit-entregas">
    Fomulario de entregas Chips <?php echo $fecha_ini ?>
</h3>

<div class="twelve-columns" id="mod-normal">
    <?php echo $this->Form->create('Chip', array('class' => 'columns', 'id' => 'form-reg', 'url' => array('controller' => 'Chips', 'action' => 'registra_ventachips'))) ?>
    <fieldset class="fieldset">

        <legend class="legend">
            Precios
        </legend>
        <?php foreach ($precios as $key => $pre): ?>
          <p class="button-height inline-label">
              <label for="input-text" class="label">
                  Precio <?php echo $pre['Precio']['monto'] . ' Bs.' ?>
              </label>
              <?php echo $this->Form->text("Ventaschip.$key.cantidad", array('class' => 'input validate[required,custom[integer]] clase-cantidad', 'id' => 'salida-' . $key, 'onkeyup' => 'calc_total(' . "$key," . $pre['Productosprecio']['precio'] . ')')) ?>
              <strong> TOTAL <label id="tlabel-<?php echo $key ?>">0</label> Bs.</strong>
          </p>
          <?php echo $this->Form->hidden("Ventaschip.$key.user_id", array('value' => $this->Session->read('Auth.User.id'))); ?>

          <?php echo $this->Form->hidden("Ventaschip.$key.distribuidor_id", array('value' => $idDistribuidor)); ?>
          <?php echo $this->Form->hidden("Ventaschip.$key.precio", array('value' => $pre['Precio']['monto'])); ?>
          <?php echo $this->Form->hidden("Ventaschip.$key.fecha", array('value' => $fecha_ini)); ?>
        <?php endforeach; ?>
        <div class="button-height">
            <button class="button blue-gradient full-width" type="submit">Registrar</button>
        </div>
    </fieldset>
    <?php echo $this->Form->hidden("Dato.fecha", array('value' => $fecha_ini)); ?>
    <?php echo $this->Form->hidden("Dato.distribuidor_id", array('value' => $idDistribuidor)); ?>
    <?php echo $this->Form->hidden("Dato.cantidad_total", array('id' => 'idcantidad_total')); ?>
    <?php echo $this->Form->end(); ?>
</div>

<br>
<div class="with-padding">
    <table class="simple-table responsive-table" id="sorting-example2">
        <thead>
            <tr>
                <th>Creado</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ventas as $mov): ?>
              <tr>
                  <td><?php echo $mov['Ventaschip']['created']; ?></td>
                  <td><?php echo $mov['Ventaschip']['precio']; ?></td>
                  <td><?php echo $mov['Ventaschip']['cantidad']; ?></td>
                  <td>
                      <?php echo $this->Html->link("Eliminar", array('action' => 'elimina_chip_dis', $mov['Ventaschip']['id']), array('class' => 'tag red-bg', 'confirm' => 'Esta seguro de eliminar el registro???')) ?>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
  $('.clase-cantidad').keyup(function () {
      var cantidad_t = 0;
      $('.clase-cantidad').each(function (i, elemento) {

          if ($(elemento).val() != '') {
              cantidad_t = cantidad_t + parseInt($(elemento).val());
          }

      });
      $('#idcantidad_total').val(cantidad_t);
  });



  function calc_total(key, precio) {

      var cantidad = parseInt($('#salida-' + key).val());
      var total = parseFloat(cantidad * parseFloat(precio));
      total = Math.round(total * 100) / 100;
      $('#tlabel-' + key).html(total);
      //$('#tprecio-' + key).val(total);

  }

  /* $("#form-reg").submit(function (e)
   {
   var postData = $(this).serializeArray();
   var formURL = '<?php //echo $this->Html->url(array('controller' => 'Chips', 'action' => 'registra_ventachips'));  ?>';
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
   
   $('#idmodal').load('<?php //echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'ajax_venta', $fecha_ini, $fecha_fin, $persona, $idProducto));  ?>');
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