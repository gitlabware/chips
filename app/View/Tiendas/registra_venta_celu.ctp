<?php $tipo_cambio = $this->Session->read('Auth.User.Sucursal.tipo_cambio'); ?>
<script>
  var numero_p = [];
  var tipo_cambio = <?php echo $tipo_cambio; ?>;
  var precio_dolar = 0.00;
  var precio_bolivianos = 0.00;
  function calcula_bol(key) {
      precio_dolar = parseFloat($('#precio-' + key + '-dol').val());
      precio_bolivianos = precio_dolar * tipo_cambio;
      $('#precio-' + key + '-bol').val(precio_bolivianos.toFixed(2));
  }
  function calcula_dol(key) {
      precio_bolivianos = parseFloat($('#precio-' + key + '-bol').val());
      precio_dolar = precio_bolivianos / tipo_cambio;
      $('#precio-' + key + '-dol').val(precio_dolar.toFixed(2));
  }
  function calcula_tipo_cambio() {
      numerocelulares = <?php echo count($celulares); ?>;
      tipo_cambio = parseFloat($('#tipocambio').val());
      $('#tipocambio2').val(tipo_cambio);
      for (i = 0; i < numerocelulares; i++) {
          calcula_bol(i);
          /*precio_dolar = parseFloat($('#precio-' + i + '-dol').val());
           precio_bolivianos = precio_dolar * tipo_cambio;
           $('#precio-' + i + '-bol').val(precio_bolivianos);*/
      }
  }
  function calc_pag_bol(key) {
      precio_dolar = parseFloat($('#idmonto-' + key).val());
      precio_bolivianos = precio_dolar * tipo_cambio;
      $('#idmonto-bol-' + key).val(precio_bolivianos.toFixed(2));
  }
  function calc_pag_dol(key) {
      precio_bolivianos = parseFloat($('#idmonto-bol-' + key).val());
      precio_dolar = precio_bolivianos / tipo_cambio;
      $('#idmonto-' + key).val(precio_dolar.toFixed(2));
  }
</script>
<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>VENTA A <?php echo strtoupper($this->request->data['Tienda']['cliente']); ?></h1>
    </hgroup>
    <div class="with-padding"> 
        <div class="columns">
            <div class="ten-columns">
                <?php echo $this->Form->create('Tienda', array('action' => 'registra_venta_celu_2')); ?>
                <div class="columns">
                    <div class="three-columns">
                        <p class="button-height inline-label">
                            <label  class="label">Tipo de Cambio</label>
                            <?php echo $this->Form->text('Sucursal.tipo_cambio2', array('class' => 'input', 'required', 'type' => 'number', 'step' => 'any', 'value' => $tipo_cambio, 'id' => 'tipocambio', 'onkeyup' => 'calcula_tipo_cambio();')); ?>
                            <?php echo $this->Form->hidden("Sucursal.tipo_cambio",array('id' => 'tipocambio2'));?>
                        </p>
                    </div>
                </div>
                <?php foreach ($celulares as $key => $cel): ?>
                  <script>
                      numero_p[<?php echo $key ?>] = 0;</script>
                  <?php echo $this->Form->hidden("Ventascelulare.$key.producto_id", array('value' => $cel['Producto']['id'])); ?>
                  <?php echo $this->Form->hidden("Ventascelulare.$key.cliente", array('value' => $this->request->data['Tienda']['cliente'])); ?>
                  <?php //echo $this->Form->hidden("Ventascelulare.$key.precio", array('value' => $cel['precio'])); ?>
                  <p class="block-label button-height">
                  <fieldset class="fieldset">
                      <p class="block-label button-height">
                      <div class="columns">
                          <div class="six-columns" align="center">
                              <img src="<?php echo $this->webroot  . $cel['Producto']['url_imagen'] ?>" alt="Smiley face" height="200" width="200">
                          </div>
                          <div class="six-columns">
                              <p class="button-height inline-label">
                              <h4><?php echo strtoupper($cel['Producto']['nombre']); ?></h4>
                              </p>
                              <p class="button-height inline-label">
                                  <label  class="label"><?php echo $cel['Marca']['nombre'] ?></label>
                              </p>
                              <p class="button-height inline-label">
                                  <label class="label">Precio Dolares: </label>
                                  <?php echo $this->Form->text("Ventascelulare.$key.precio", array('class' => 'input', 'value' => $cel['precio'], 'id' => "precio-$key-dol", 'onkeyup' => "calcula_bol($key);")); ?>
                              </p>
                              <p class="button-height inline-label">
                                  <label class="label">Precio Bolivianos: </label>
                                  <?php echo $this->Form->text("Ventascelulare.$key.precio_bol", array('class' => 'input', 'id' => "precio-$key-bol", 'onkeyup' => "calcula_dol($key);")); ?>
                              </p>
                              <script>
                                //calcula_tipo_cambio_bol(<?php echo $key; ?>);
                              </script>
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
                          <div class="two-columns">
                              <label class="label">Codigo</label>
                              <input type="text" name="data[][]" class="input full-width" id="idcodigo-<?php echo $key; ?>">
                          </div>
                          <div class="two-columns">
                              <label class="label">Monto Dolares</label>
                              <input type="text" name="data[][]" class="input full-width" id="idmonto-<?php echo $key; ?>" onkeyup="calc_pag_bol(<?php echo $key; ?>);">
                          </div>
                          <div class="two-columns">
                              <label class="label">Monto Bolivianos</label>
                              <input type="text" name="data[][]" class="input full-width" id="idmonto-bol-<?php echo $key; ?>" onkeyup="calc_pag_dol(<?php echo $key; ?>);">
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
      var monto_bol = $('#idmonto-bol-' + key).val();
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
              + '   <label class="label">Monto Dolares</label>'
              + '   <input type="text" name="data[Ventascelulare][' + key + '][Pago][' + numero_p[key] + '][monto]" class="input" value="' + monto + '">'
              + ' </div>'
              + ' <div class="three-columns">'
              + '   <label class="label">Monto Bolivianos</label>'
              + '   <input type="text" name="data[Ventascelulare][' + key + '][Pago][' + numero_p[key] + '][monto_bol]" class="input" value="' + monto_bol + '">'
              + '   <input type="hidden" name="data[Ventascelulare][' + key + '][Pago][' + numero_p[key] + '][tipo_cambio]" class="input" value="' + tipo_cambio + '">'
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
      $('#idmonto-bol-'+key).val('');
      $('#tipocambio').attr('disabled',true);
  }
  function quita(key) {
      if (numero_p[key] > 0) {
          $('#block-' + key + '-' + numero_p[key]).remove();
          numero_p[key]--;
      }
  }
  function calcula_tipo_cambio_bol(key) {
      var tipo_cambio = <?php echo $tipo_cambio; ?>;
      var precio_dolar = parseFloat($('#precio-' + key + '-dol').val());
      var precio_bolivianos = precio_dolar * tipo_cambio;
      $('#precio-' + key + '-bol').val(precio_bolivianos);
  }
  function calcula_tipo_cambio_dol(key) {
      var tipo_cambio = <?php echo $tipo_cambio; ?>;
      var precio_bolivianos = parseFloat($('#precio-' + key + '-bol').val());
      var precio_dolar = precio_bolivianos / tipo_cambio;
      $('#precio-' + key + '-dol').val(precio_dolar);
  }
  calcula_tipo_cambio();
</script>