<script>
  var tipo_cambio = <?php echo $tipo_cambio; ?>;
  var precio_dolar = 0.00;
  var precio_bolivianos = 0.00;
  function calcula_bol() {
      precio_dolar = parseFloat($('#precio' + '-dol').val());
      precio_bolivianos = precio_dolar * tipo_cambio;
      $('#precio' + '-bol').val(precio_bolivianos.toFixed(2));
  }
  function calcula_dol() {
      precio_bolivianos = parseFloat($('#precio' + '-bol').val());
      precio_dolar = precio_bolivianos / tipo_cambio;
      $('#precio' + '-dol').val(precio_dolar.toFixed(2));
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
  function calc_pag_bol() {
      precio_dolar = parseFloat($('#idmonto').val());
      precio_bolivianos = precio_dolar * tipo_cambio;
      $('#idmonto-bol').val(precio_bolivianos.toFixed(2));
  }
  function calc_pag_dol() {
      precio_bolivianos = parseFloat($('#idmonto-bol').val());
      precio_dolar = precio_bolivianos / tipo_cambio;
      $('#idmonto').val(precio_dolar.toFixed(2));
  }
</script>
<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>MODIFICAR VENTA</h1>
    </hgroup>
    <div class="with-padding"> 
        <div class="columns">
            <div class="twelve-columns">
                <?php echo $this->Form->create('Tienda'); ?>
                <?php echo $this->Form->hidden("Ventascelulare.id"); ?>
                <div class="columns">
                    <div class="six-columns">
                        <p class="button-height inline-label">
                            <label  class="label">Tipo de Cambio</label>
                            <?php echo $this->Form->text('Sucursal.tipo_cambio2', array('class' => 'input', 'required', 'type' => 'number', 'step' => 'any', 'value' => $tipo_cambio, 'id' => 'tipocambio', 'onkeyup' => 'calcula_tipo_cambio();')); ?>
                            <?php echo $this->Form->hidden("Sucursal.tipo_cambio", array('id' => 'tipocambio2')); ?>
                        </p>
                    </div>
                    <div class="six-columns">
                        <p class="button-height inline-label">
                            <label  class="label">Cliente</label>
                            <?php echo $this->Form->text('Ventascelulare.cliente', array('class' => 'input', 'required')); ?>

                        </p>
                    </div>
                </div>

                <?php //echo $this->Form->hidden("Ventascelulare.producto_id", array('value' => $cel['Producto']['id'])); ?>
                <?php //echo $this->Form->hidden("Ventascelulare.cliente", array('value' => $this->request->data['Tienda']['cliente'])); ?>
                <?php //echo $this->Form->hidden("Ventascelulare.$key.precio", array('value' => $cel['precio'])); ?>
                <p class="block-label button-height">
                <fieldset class="fieldset">
                    <p class="block-label button-height">
                    <div class="columns">
                        <div class="six-columns" align="center">
                            <img src="<?php echo $this->webroot . $venta['Producto']['url_imagen'] ?>" alt="Smiley face" height="200" width="200">
                        </div>
                        <div class="six-columns">
                            <p class="button-height inline-label">
                            <h4><?php echo strtoupper($venta['Producto']['nombre']); ?></h4>
                            </p>
                            <p class="button-height inline-label">
                                <label  class="label"><?php echo $venta['Ventascelulare']['marca'] ?></label>
                            </p>
                            <p class="button-height inline-label">
                                <label class="label">Precio Dolares: </label>
                                <?php echo $this->Form->text("Ventascelulare.precio", array('class' => 'input', 'value' => $venta['Ventascelulare']['precio'], 'id' => "precio-dol", 'onkeyup' => "calcula_bol();")); ?>
                            </p>
                            <p class="button-height inline-label">
                                <label class="label">Precio Bolivianos: </label>
                                <?php echo $this->Form->text("Ventascelulare.precio_bol", array('class' => 'input', 'id' => "precio-bol", 'onkeyup' => "calcula_dol();")); ?>
                            </p>
                            <script>
                              //calcula_tipo_cambio_bol(<?php //echo $key;            ?>);
                            </script>
                            <p class="button-height inline-label">
                                <label class="label">Numero Serie</label>
                                <?php echo $this->Form->text("Ventascelulare.num_serie", array('class' => 'input')); ?>
                            </p>
                            <p class="button-height inline-label">
                                <label class="label">Imei</label>
                                <?php echo $this->Form->text("Ventascelulare.imei", array('class' => 'input')); ?>
                            </p>
                        </div>
                    </div>
                    </p>
                    <p class="block-label button-height">
                        <button type="submit" class="button anthracite-gradient glossy full-width">REGISTRAR VENTA</button>
                    </p>
                    <?php echo $this->Form->end(); ?>
                    <p class="block-label button-height">
                        <?php echo $this->Form->create('Tienda', array('action' => 'registra_pago_v')); ?>
                        <?php echo $this->Form->hidden('Pago.ventascelulare_id', array('value' => $venta['Ventascelulare']['id'])) ?>
                        <?php echo $this->Form->hidden('Pago.moneda', array('value' => "Bolivianos", 'id' => 'idtipomoneda')) ?>
                    <div class="columns"   id="block-0">
                        <div class="two-columns">
                            <label class="label">Tipo pago</label>
                            <select name="data[Pago][tipo]" class="select blue-gradient full-width" id="tipopago">
                                <option value="Voucher">Voucher</option>
                                <option value="Ticket">Ticket</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                            </select>
                        </div>
                        <div class="two-columns">
                            <label class="label">Codigo</label>
                            <input type="text" name="data[Pago][codigo]" class="input full-width" id="idcodigo">
                        </div>
                        <div class="one-column">
                            <label class="label" id="l-monto-d" onclick="$('#l-monto-b').removeClass('tag');
                                  $('#l-monto-d').addClass('tag');
                                $('#idtipomoneda').val('Dolares');"><span id="l-monto-d" >Monto$</span></label>
                            <input type="text" name="data[Pago][monto_dolar]" required="true" class="input full-width" id="idmonto" onkeyup="calc_pag_bol();">
                        </div>
                        <div class="one-column">
                            <label class="label" onclick="$('#l-monto-d').removeClass('tag');
                                  $('#l-monto-b').addClass('tag');
                                $('#idtipomoneda').val('Bolivianos');"><span id="l-monto-b" class="tag">MontoBs</span></label>
                            <input type="text" name="data[Pago][monto]" class="input full-width" id="idmonto-bol" onkeyup="calc_pag_dol();">
                        </div>
                        <div class="two-columns">
                            <label class="label">Nombre</label>
                            <input type="text" name="data[Pago][nombre]" class="input full-width" id="id-nombre">
                        </div>
                        <div class="two-columns">
                            <label class="label">Celular</label>
                            <input type="text" name="data[Pago][celular]" class="input full-width" id="id-celular">
                        </div>
                        <div class="two-columns"><br>
                            <button type="submit" class="button green-gradient glossy" >ADICIONAR</button> 
                        </div>
                    </div>
<?php echo $this->Form->end() ?>
                    </p>
                </fieldset>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tipo Pafo</th>
                            <th>Codigo</th>
                            <th>Monto $</th>
                            <th>Monto Bs</th>
                            <th>Nombre</th>
                            <th>Celular</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_d = 0.00; ?>
                        <?php $total_b = 0.00; ?>
                        <?php foreach ($pagos as $pa): ?>
                          <?php $total_d += $pa['Pago']['monto_dolar']; ?>
                          <?php $total_b += ($pa['Pago']['monto']); ?>
                          <?php
                          $clase_b = '';
                          $clase_d = '';
                          if ($pa['Pago']['moneda'] == 'Bolivianos') {
                            $clase_b = 'style="color: green; font-weight: bold;"';
                          } else {
                            $clase_d = 'style="color: green; font-weight: bold;"';
                          }
                          ?>
                          <tr>
                              <td><?= $pa['Pago']['tipo'] ?></td>
                              <td><?= $pa['Pago']['codigo'] ?></td>
                              <td <?= $clase_d ?>><?= $pa['Pago']['monto_dolar'] ?></td>
                              <td <?= $clase_b ?>><?= $pa['Pago']['monto'] ?></td>
                              <td><?= $pa['Pago']['nombre'] ?></td>
                              <td><?= $pa['Pago']['celular'] ?></td>
                              <td>
                          <?php echo $this->Html->link('Eliminar', array('action' => 'eliminar_pago_v', $pa['Pago']['id']), array('class' => 'button red-gradient', 'confirm' => 'Esta seguro de eliminar el pago?')); ?>
                              </td>
                          </tr>
<?php endforeach; ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b><?= $total_d ?></b></td>
                            <td><b><?= $total_b ?></b></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                </p>

            </div>
        </div>
    </div>
</section>	

<script>
  calcula_bol();
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 