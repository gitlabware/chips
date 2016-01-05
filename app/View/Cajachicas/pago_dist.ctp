
<h3 id="tit-entregas">
    Fomulario de Pago (Fecha: <?php echo $fecha_ini?>)
</h3>

<div class="twelve-columns" id="mod-normal">
    <?php echo $this->Form->create('Cajachica', array('class' => 'columns', 'id' => 'form-pago-d', 'action' => 'registra_pago_d')) ?>
    <fieldset class="fieldset">

        <p class="button-height inline-label">
        <h4>TOTAL VENTAS: <span><?php echo $total; ?></span> Bs.</h4>
        </p>
        <?php foreach ($bancos as $key => $ban): ?>
          <p class="button-height inline-label">
              <label for="input-text" class="label">
                  <?php echo $ban['Banco']['nombre'] ?>
              </label>
              <?php echo $this->Form->text("Cajachica.$key.monto", array('class' => 'input full-width validate[required,custom[integer]] to-monto', 'value' => 0)) ?>
          </p>
          <?php echo $this->Form->hidden("Cajachica.$key.user_id", array('value' => $this->Session->read('Auth.User.id'))); ?>
          <?php echo $this->Form->hidden("Cajachica.$key.tipo", array('value' => 'Ingreso')); ?>
          <?php echo $this->Form->hidden("Cajachica.$key.total", array('value' => 0)); ?>
          <?php echo $this->Form->hidden("Cajachica.$key.fecha", array('value' => $fecha_ini)); ?>
          <?php echo $this->Form->hidden("Cajachica.$key.cajadetalle_id", array('value' => $idDet)); ?>
          <?php echo $this->Form->hidden("Cajachica.$key.sucursal_id", array('value' => $idSucursal)); ?>
          <?php echo $this->Form->hidden("Cajachica.$key.banco_id", array('value' => $ban['Banco']['id'])); ?>
        <?php endforeach; ?>
        <p class="button-height inline-label">
            <label for="input-text" class="label">
                FALTANTE
            </label>
            <?php echo $this->Form->text("Distribuidorpago.faltante", array('class' => 'input full-width', 'type' => 'number', 'step' => 'any', 'value' => 0.00, 'id' => 'idfaltante-p')) ?>
        </p>
        <p class="button-height inline-label">
            <label for="input-text" class="label">
                OTRO INGRESO
            </label>
            <?php echo $this->Form->text("Distribuidorpago.otro_ingreso", array('class' => 'input full-width', 'type' => 'number', 'step' => 'any', 'value' => 0.00, 'id' => 'idotro-i-p')) ?>
        </p>

        <p class="button-height inline-label">
        <h4>TOTAL: <span id="span-total"><?php echo $total; ?></span> Bs.</h4>
        </p>
        
        <p class="button-height inline-label">
            <label for="input-text" class="label">
                OBSERVACION
            </label>
            <?php echo $this->Form->textarea("Distribuidorpago.observaciones", array('class' => 'input  full-width')) ?>
        </p>
        <div class="button-height">
            <button class="button green-gradient full-width" type="submit">Registrar</button>
        </div>
    </fieldset>
    <?php echo $this->Form->hidden("Distribuidorpago.distribuidor_id", array('value' => $idDistribuidor)) ?>
    <?php echo $this->Form->hidden("Distribuidorpago.fecha", array('value' => $fecha_ini)) ?>
    <?php echo $this->Form->hidden("Distribuidorpago.total", array('class' => 'input', 'type' => 'number', 'step' => 'any', 'value' => $total, 'id' => 'idtotal-p')) ?>
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

  /*$("#form-pago-d").submit(function (e)
   {
   var postData = $(this).serializeArray();
   var formURL = '<?php //echo $this->Html->url(array('controller' => 'Cajachicas', 'action' => 'registra_pago_d'));  ?>';
   $.ajax(
   {
   url: formURL,
   type: "POST",
   data: postData,
   beforeSend:function (XMLHttpRequest) {
   alert("antes de enviar");
   },
   complete:function (XMLHttpRequest, textStatus) {
   alert('despues de enviar');
   },
   success: function (data, textStatus, jqXHR)
   {
   if ($.parseJSON(data).correcto != '') {
   mensaje_nota('Excelente!!', $.parseJSON(data).correcto);
   } else {
   mensaje_nota('Error!!', $.parseJSON(data).incorrecto);
   }
   //$('')
   //$('#idmodal').load('<?php //echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'ajax_venta', $fecha_ini, $fecha_fin, $persona, $idProducto));  ?>');
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

  function calcula_suma() {
      var tot_monto_p = 0.00;
      $('.to-monto').each(function (e, elemento) {
          if ($(elemento).val() != '') {
              tot_monto_p = tot_monto_p + parseFloat($(elemento).val());
          }
      });
      var total_total = 0;
      if ($('#idtotal-p').val() != '') {
          total_total = parseFloat($('#idtotal-p').val());
          total_total = Math.round(total_total * 100) / 100;
      }
      var otro_ing = 0;
      if ($('#idotro-i-p').val() != '') {
          otro_ing = parseFloat($('#idotro-i-p').val());
          otro_ing = Math.round(otro_ing * 100) / 100;
      }
      $('#span-total').html(Math.round((total_total + otro_ing) * 100) / 100);
      if ((total_total - tot_monto_p) >= 0) {
          $('#idfaltante-p').val(Math.round((total_total - tot_monto_p) * 100) / 100);
          $('#idotro-i-p').val(0);
      } else {
          $('#idfaltante-p').val(0);
          $('#idotro-i-p').val(Math.round((tot_monto_p - total_total) * 100) / 100);
      }

      //alert(tot_monto_p);
  }
  $('.to-monto').keyup(function () {
      calcula_suma();
  });
  $('#idotro-i-p').keyup(function () {
      calcula_suma();
  });

</script>