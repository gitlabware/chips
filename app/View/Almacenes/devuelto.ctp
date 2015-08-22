<style>

    .CSSTableGenerator {
        margin:0px;padding:0px;
        width:100%;
        border:1px solid #000000;

        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;

        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;

        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;

        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }.CSSTableGenerator table{
        border-collapse: collapse;
        border-spacing: 0;
        width:100%;
        height:100%;
        margin:0px;padding:0px;
    }.CSSTableGenerator tr:last-child td:last-child {
        -moz-border-radius-bottomright:0px;
        -webkit-border-bottom-right-radius:0px;
        border-bottom-right-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:first-child {
        -moz-border-radius-topleft:0px;
        -webkit-border-top-left-radius:0px;
        border-top-left-radius:0px;
    }
    .CSSTableGenerator table tr:first-child td:last-child {
        -moz-border-radius-topright:0px;
        -webkit-border-top-right-radius:0px;
        border-top-right-radius:0px;
    }.CSSTableGenerator tr:last-child td:first-child{
        -moz-border-radius-bottomleft:0px;
        -webkit-border-bottom-left-radius:0px;
        border-bottom-left-radius:0px;
    }.CSSTableGenerator tr:hover td{
        background-color:#ffffff;


    }
    .CSSTableGenerator td{
        vertical-align:middle;

        background-color:#ffffff;

        border:1px solid #000000;
        border-width:0px 1px 1px 0px;
        padding:5px;
        font-size:10px;
        font-family:Arial;
        font-weight:bold;
        color:#000000;
    }.CSSTableGenerator tr:last-child td{
        border-width:0px 1px 0px 0px;
    }.CSSTableGenerator tr td:last-child{
        border-width:0px 0px 1px 0px;
    }.CSSTableGenerator tr:last-child td:last-child{
        border-width:0px 0px 0px 0px;
    }
</style>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>FORMULARIO DE DEVUELTO <small> HASTA HOY <?php echo date('d-m-Y') ?></small></h1>
    </hgroup>

    <div class="with-padding"> 
        <div class="columns">
            <div class="twelve-columns">
                <h2>DISTRIBUIDOR <?php echo $distribuidor['Persona']['nombre'] . ' ' . $distribuidor['Persona']['ap_paterno'] . ' ' . $distribuidor['Persona']['ap_materno'] ?></h2>
            </div>
        </div>
        <div class="columns">
            <div class="twelve-columns">
                <button type="button" class="button black-gradient glossy full-width" onclick="$('#reporte-dist').toggle(200);" id="boton-reporte">REPORTE</button>
            </div>
            <div class="new-row twelve-columns" id="reporte-dist" style="display: none;">
                <table class="CSSTableGenerator" >
                    <tr>
                        <td>Producto</td>
                        <td>Entregado</td>
                        <td>Por Precios</td>
                        <td>Venta Total</td>
                        <td>Precio Total (Bs)</td>
                        <td>Saldo Anterior</td>
                        <td>Quedan Total</td>
                    </tr>
                    <?php foreach ($datos as $da): ?>
                      <?php
                      $venta_total = 0;
                      $venta_prec_total = 0;
                      $precio_total = 0.00;
                      ?>
                      <tr>
                          <td><?php echo $da['Producto']['nombre'] ?></td>
                          <td><?php echo $da[0]['entregado'] ?></td>
                          <td>
                              <table>
                                  <?php foreach ($da['precios'] as $dato): ?>
                                    <tr>
                                        <td><?php echo $dato['Movimiento']['precio_uni'] ?> Bs</td>
                                        <td><?php echo $dato[0]['vendidos'] ?> vendidos</td>
                                        <td><?php echo $dato[0]['precio_total'] ?> Bs</td>
                                    </tr>
                                    <?php $venta_total = $venta_total + $dato[0]['vendidos']; ?>
                                    <?php $venta_prec_total = $venta_prec_total + $dato[0]['precio_total']; ?>
                                  <?php endforeach; ?>
                              </table>
                          </td>
                          <td><?php echo $venta_total ?></td>
                          <td><?php echo $venta_prec_total ?></td>
                          <td><?php echo $da['Movimiento']['total_s'] - $da[0]['entregado'] + $venta_total ?></td>
                          <td><?php echo $da['Movimiento']['total_s'] ?></td>
                      </tr>
                      <?php $precio_total = $precio_total + $venta_prec_total; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>TOTAL</td>
                        <td><?php echo $precio_total; ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table> 
                <br>
                <table class="CSSTableGenerator">
                    <tr>
                        <td align="center">RECARGAS</td>
                    </tr>
                </table>
                <table class="CSSTableGenerator" style="margin-top: -1px;">
                    <tr>
                        <td>Fecha</td>
                        <td>Numero Telefono</td>
                        <td>Monto</td>
                    </tr>
                    <?php $total_rec = 0.00; ?>
                    <?php foreach ($recargas as $re): ?>
                      <?php
                      $total_rec = $total_rec + $re['Recargado']['salida'];
                      ?>
                      <tr>
                          <td><?php echo $re['Recargado']['created'] ?></td>
                          <td><?php echo $re['Recargado']['num_celular'] ?></td>
                          <td><?php echo $re['Recargado']['salida'] ?></td>
                      </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td>TOTAL</td>
                        <td><?php echo $total_rec; ?></td>
                    </tr>
                </table>
                <br>
                <table class="CSSTableGenerator">
                    <tr>
                        <td>MONTO TOTAL</td>
                        <td><?php echo ($precio_total + $total_rec) ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php echo $this->Form->create('Almacene', array('action' => 'registra_devuelto/' . $distribuidor['Persona']['id'])); ?>
        <table class="simple-table responsive-table">
            <thead>
                <tr>
                    <th>Desde</th>
                    <th>Producto</th>
                    <th>Entregado</th>
                    <th style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ult_movimientos as $key => $ul): ?>
                  <tr>
                      <td><?php echo $ul['Movimiento']['created']; ?></td>
                      <td><?php echo $ul['Producto']['nombre']; ?></td>
                      <td><?php echo $ul[0]['entregado']; ?></td>
                      <?php echo $this->Form->hidden("Devuelto.$key.producto_id", array('value' => $ul['Producto']['id'])) ?>
                      <?php echo $this->Form->hidden("Devuelto.$key.persona_id", array('value' => $distribuidor['Persona']['id'])) ?>
                      <?php echo $this->Form->hidden("Devuelto.$key.encargado_id", array('value' => $this->Session->read('Auth.User.id'))); ?>
                      <?php echo $this->Form->hidden("Devuelto.$key.total", array('value' => $ul['Movimiento']['total_s'])); ?>
                      <td><?php echo $this->Form->text("Devuelto.$key.cantidad", array('value' => $ul['Movimiento']['total_s'], 'class' => 'input full-width')); ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br>
        <div class="columns">
            <div class="six-columns">
                <?php echo $this->Html->link('REGRESAR', $this->request->referer(), array('class' => 'button orange-gradient glossy full-width')); ?>
            </div>
            <div class="six-columns">
                <button type="submit" class="button blue-gradient glossy full-width">REGISTRAR</button>
            </div>
        </div>
        <h3>Listado de ultimos devueltos</h3>
        <table class="simple-table responsive-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($devueltos as $dev): ?>
                  <tr>
                      <td><?php echo $dev['Devuelto']['created'] ?></td>
                      <td>
                          <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('action' => 'detalle_devuelto',)); ?>')">Detalle</a>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php echo $this->element('sidebar/administrador'); ?>
<script>
$('#boton-reporte').text("REPORTE TOTAL BS(<?php echo ($precio_total + $total_rec) ?>)");
</script>