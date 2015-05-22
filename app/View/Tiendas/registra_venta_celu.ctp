<script>
  var numero_p = [];</script>
<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>VENTA A <?php echo strtoupper($this->request->data['Tienda']['cliente']); ?></h1>
    </hgroup>
    <div class="with-padding"> 
        <div class="columns">
            <div class="ten-columns">
                <?php echo $this->Form->create('Tienda', array('action' => 'registra_venta_celu_2')); ?>
                <?php foreach ($celulares as $key => $cel): ?>
                  <script>
                      numero_p[<?php echo $key ?>] = 0;</script>
                  <?php echo $this->Form->hidden("Ventascelulare.$key.producto_id", array('value' => $cel['Producto']['id'])); ?>
                  <?php echo $this->Form->hidden("Ventascelulare.$key.cliente", array('value' => $this->request->data['Tienda']['cliente'])); ?>
                  <?php echo $this->Form->hidden("Ventascelulare.$key.precio", array('value' => $cel['precio'])); ?>
                  <p class="block-label button-height">
                  <fieldset class="fieldset">
                      <p class="block-label button-height">
                      <div class="columns">
                          <div class="six-columns" align="center">
                              <img src="<?php echo '../' . $cel['Producto']['url_imagen'] ?>" alt="Smiley face" height="200" width="200">
                          </div>
                          <div class="six-columns">
                              <p class="button-height inline-label">
                              <h4><?php echo strtoupper($cel['Producto']['nombre']); ?></h4>
                              </p>
                              <p class="button-height inline-label">
                                  <label  class="label"><?php echo $cel['Marca']['nombre'] ?></label>
                              </p>
                              <p class="button-height inline-label">
                                  <label class="label">Precio: <?php echo $cel['precio'] ?></label>
                              </p>
                              <p class="button-height inline-label">
                                  <label class="label">Numero Serie</label>
                                  <?php echo $this->Form->text("Ventascelulare.$key.num_serie", array('class' => 'input')); ?>
                              </p>
                              <p class="button-height inline-label">
                                  <label class="label">Imei</label>
                                  <?php echo $this->Form->text("Ventascelulare.$key.imei", array('class' => 'input')); ?>
                              </p>
                          </div>
                      </div>
                      </p>
                      <p class="block-label button-height">
                      <div class="columns"   id="block-<?php echo $key; ?>-0">
                          <div class="three-columns">
                              <label class="label">Tipo pago</label>
                              <select name="data[][]" class="select blue-gradient full-width" id="tipopago-<?php echo $key; ?>">
                                  <option value="Boucher">Boucher</option>
                                  <option value="Ticket">Ticket</option>
                                  <option value="Efectivo">Efectivo</option>
                                  <option value="Tarjeta">Tarjeta</option>
                              </select>
                          </div>
                          <div class="three-columns">
                              <label class="label">Codigo</label>
                              <input type="text" name="data[][]" class="input" id="idcodigo-<?php echo $key; ?>">
                          </div>
                          <div class="three-columns">
                              <label class="label">Monto</label>
                              <input type="text" name="data[][]" class="input" id="idmonto-<?php echo $key; ?>">
                          </div>
                          <div class="three-columns"><br>
                              <button type="button" class="button green-gradient glossy" onclick="add_pago(<?php echo $key; ?>);">ADD</button> 
                              <button type="button" class="button red-gradient glossy" onclick="quita(<?php echo $key; ?>);">QUITA</button>
                          </div>
                      </div>
                      </p>
                  </fieldset>
                  </p>
                <?php endforeach; ?>
                <p class="block-label button-height">
                    <button type="submit" class="button anthracite-gradient glossy full-width">REGISTRAR VENTA</button>
                </p>
            </div>
        </div>
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 

<script>
  var nuevo_pago = '';
  function add_pago(key) {
      var tipopago = $('#tipopago-' + key).val();
      var codigo = $('#idcodigo-' + key).val();
      var monto = $('#idmonto-' + key).val();
      var optboucher = '     <option value="Boucher">Boucher</option>';
      var optticket = '     <option value="Ticket">Ticket</option>';
      var optefectivo = '     <option value="Efectivo">Efectivo</option>';
      var opttarjeta = '     <option value="Tarjeta">Tarjeta</option>';
      switch (tipopago) {
          case "Boucher":
              optboucher = '     <option value="Boucher" selected>Boucher</option>';
              break;
          case "Ticket":
              optticket = '     <option value="Ticket" selected>Ticket</option>';
              break;
          case "Efectivo":
              optefectivo = '     <option value="Efectivo" selected>Efectivo</option>';
              break;
          case "Tarjeta":
              opttarjeta = '     <option value="Tarjeta" selected>Tarjeta</option>';
              break;
      }
      numero_p[key]++;
      nuevo_pago = ''
              //+ '<p class="block-label button-height" id="block-' + key + '-' + numero_p + '">'
              + '<div class="columns" id="block-' + key + '-' + numero_p[key] + '">'
              + ' <div class="three-columns">'
              + '   <label class="label">Tipo pago</label>'
              + '   <select name="data[Ventascelulare][' + key + '][Pago][' + numero_p[key] + '][tipo]" class="select blue-gradient full-width" id="select-tipo-' + key + '-' + numero_p[key] + '">'
              + optboucher
              + optticket
              + optefectivo
              + opttarjeta
              + '   </select>'
              + ' </div>'
              + ' <div class="three-columns">'
              + '   <label class="label">Codigo</label>'
              + '   <input type="text" name="data[Ventascelulare][' + key + '][Pago][' + numero_p[key] + '][codigo]" class="input" value="' + codigo + '">'
              + ' </div>'
              + ' <div class="three-columns">'
              + '   <label class="label">Monto</label>'
              + '   <input type="text" name="data[Ventascelulare][' + key + '][Pago][' + numero_p[key] + '][monto]" class="input" value="' + monto + '">'
              + ' </div>'
              + ' <div class="three-columns">'
              + '   <label class="label">&nbsp;</label>'
              + ' </div>'
              + '</div>'
              //+ '</p>'
              + '';
      $('#block-' + key + '-' + (numero_p[key] - 1)).after(nuevo_pago);
      //alert(tipopago);
      /*var selector = '#select-tipo-' + key + '-' + numero_p[key] + ' > option[value=' + tipopago + ']';
       $(selector).attr("selected", true);*/
      //$('#tipopago-' + key).val('');
      $('#idcodigo-' + key).val('');
      $('#idmonto-' + key).val('');
  }
  function quita(key) {
      if (numero_p[key] > 0) {
          $('#block-' + key + '-' + numero_p[key]).remove();
          numero_p[key]--;
      }
  }

</script>