<h3 id="tit-entregas">
    Fomulario de entregas <?php echo $fecha_ini ?>
</h3>

<div class="twelve-columns" id="mod-normal">
    <?php echo $this->Form->create('Almacenes', array('class' => 'columns', 'id' => 'form-reg', 'url' => array('controller' => 'Ventasdistribuidor', 'action' => 'registra_venta_mayor_ajax', $persona))) ?>
    <fieldset class="fieldset">

        <legend class="legend">
            Precios <?php echo $producto['Producto']['nombre'] ?>
        </legend>
          <p class="button-height inline-label">
              <label for="input-text" class="label">
                  Cantidad
              </label>
              <?php echo $this->Form->text("Movimiento.$key.salida", array('class' => 'input validate[required,custom[integer]]', 'id' => 'salida-' . $key, 'onkeyup' => 'calc_total(' . "$key," . $pre['Productosprecio']['precio'] . ')')) ?>
              
          </p>
          <?php echo $this->Form->hidden("Movimiento.user_id", array('value' => $this->Session->read('Auth.User.id'))); ?>
          <?php echo $this->Form->hidden("Movimiento.producto_id", array('value' => $idProducto)); ?>
          <?php echo $this->Form->hidden("Movimiento.cliente_id", array('value' => 0)); ?>
          <?php //echo $this->Form->hidden("Movimiento.$key.nombre_prod", array('value' => $producto['Producto']['nombre'])); ?>
          <?php echo $this->Form->hidden("Movimiento.escala", array('value' => 'ENTREGA')); ?>
          <?php //echo $this->Form->hidden("Movimiento.$key.precio_uni", array('value' => $pre['Productosprecio']['precio'])); ?>
          <?php //echo $this->Form->hidden("Movimiento.$key.total_p", array('id' => 'tprecio-' . $key)); ?>
          <?php echo $this->Form->hidden("Movimiento.persona_id", array('value' => $persona)); ?>
          <?php echo $this->Form->hidden("Movimiento.created", array('value' => $fecha)); ?>

        <div class="button-height">
            <button class="button blue-gradient full-width" type="submit">Registrar</button>
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>
<br>
<div class="with-padding">
    <table class="simple-table responsive-table" id="sorting-example2">
        <thead>
            <tr>
                <th>Creado</th>
                <th>Precio</th>
                <th>Salida</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $mov): ?>
              <tr>
                  <td><?php echo $mov['Movimiento']['modified']; ?></td>
                  <td><?php echo $mov['Movimiento']['precio_uni']; ?></td>
                  <td><?php echo $mov['Movimiento']['salida']; ?></td>
                  <td>
                      <?php echo $this->Html->link("Eliminar", array('action' => 'elimina_venta_dis', $mov['Movimiento']['id']), array('class' => 'tag red-bg', 'confirm' => 'Esta seguro de eliminar el registro???')) ?>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>



  function calc_total(key, precio) {

      var cantidad = parseInt($('#salida-' + key).val());
      var total = parseFloat(cantidad * parseFloat(precio));
      total = Math.round(total * 100) / 100;
      $('#tlabel-' + key).html(total);
      $('#tprecio-' + key).val(total);

  }

  /*$("#form-reg").submit(function (e)
   {
   var postData = $(this).serializeArray();
   var formURL = '<?php //echo $this->Html->url(array('controller' => 'Ventasdistribuidor','action' => 'registra_venta_mayor_ajax',$persona));   ?>';
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
   
   $('#idmodal').load('<?php //echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'ajax_venta', $fecha_ini, $fecha_fin, $persona, $idProducto));   ?>');
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