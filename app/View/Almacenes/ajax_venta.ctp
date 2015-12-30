<h3 id="tit-entregas">
    Fomulario de entregas
</h3>

<div class="twelve-columns" id="mod-normal">
    <?php echo $this->Form->create('Venstasdistribuidor', array('class' => 'columns', 'id' => 'form-reg', 'url' => 'Venstasdistribuidor/registra_venta_mayor_ajax')) ?>
    <fieldset class="fieldset">

        <legend class="legend">
            Precios
        </legend>
        <?php foreach ($precios as $key => $pre): ?>
          <p class="button-height inline-label">
              <label for="input-text" class="label">
                  Precio <?php echo $pre['Productosprecio']['precio'] . ' Bs.' ?>
              </label>
              <?php echo $this->Form->text("Movimiento.$key.salida", array('class' => 'input validate[required,custom[integer]]', 'id' => 'salida-' . $key, 'onkeyup' => 'calc_total(' . "$key," . $pre['Productosprecio']['precio'] . ')')) ?>
              <strong> TOTAL <label id="tlabel-<?php echo $key ?>">0</label> Bs.</strong>
          </p>
          <?php echo $this->Form->hidden("Movimiento.$key.user_id", array('value' => $this->Session->read('Auth.User.id'))); ?>
          <?php echo $this->Form->hidden("Movimiento.$key.producto_id", array('value' => $idProducto)); ?>
          <?php echo $this->Form->hidden("Movimiento.$key.cliente_id", array('value' => 0)); ?>
          <?php echo $this->Form->hidden("Movimiento.$key.nombre_prod", array('value' => $producto['Producto']['nombre'])); ?>
          <?php echo $this->Form->hidden("Movimiento.$key.escala", array('value' => 'MAYOR')); ?>
          <?php echo $this->Form->hidden("Movimiento.$key.precio_uni", array('value' => $pre['Productosprecio']['precio'])); ?>
          <?php echo $this->Form->hidden("Movimiento.$key.total_p", array('id' => 'tprecio-' . $key)); ?>
          <?php echo $this->Form->hidden("Movimiento.$key.persona_id", array('value' => $persona)); ?>
        <?php endforeach; ?>
        <div class="button-height">
            <button class="button blue-gradient full-width" type="submit">Registrar</button>
        </div>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>

<script>



  function calc_total(key, precio) {

      var cantidad = parseInt($('#salida-' + key).val());
      var total = parseFloat(cantidad * parseFloat(precio));
      total = Math.round(total * 100) / 100;
      $('#tlabel-' + key).html(total);
      $('#tprecio-' + key).val(total);

  }

  $("#form-reg").submit(function (e)
  {
      var postData = $(this).serializeArray();
      var formURL = '<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor','action' => 'registra_venta_mayor_ajax',$persona)); ?>';
      $.ajax(
              {
                  url: formURL,
                  type: "POST",
                  data: postData,
                  /*beforeSend:function (XMLHttpRequest) {
                   alert("antes de enviar");
                   },
                   complete:function (XMLHttpRequest, textStatus) {
                   alert('despues de enviar');
                   },*/
                  success: function (data, textStatus, jqXHR)
                  {
                      if ($.parseJSON(data).correcto != '') {
                          mensaje_nota('Excelente!!', $.parseJSON(data).correcto);
                      } else {
                          mensaje_nota('Error!!', $.parseJSON(data).incorrecto);
                      }

                      $('#idmodal').load('<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'ajax_venta', $fecha_ini, $fecha_fin, $persona, $idProducto)); ?>');
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
  });
</script>