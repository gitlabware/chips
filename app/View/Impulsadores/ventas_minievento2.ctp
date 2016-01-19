<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Minievento <?php echo $minievento['Minievento']['direccion'] ?> </h1>
    </hgroup>
    <div class="with-padding">
        <h4><?php echo 'Impulsador: ' . $ususario['Persona']['nombre'] . ' ' . $ususario['Persona']['ap_paterno'] . ' ' . $ususario['Persona']['ap_materno'] ?> </h4>
        <!--<a class="button black-gradient full-width"  href="<?php //echo $this->Html->url(array('action' => 'reporte_ventas_dist', $persona, $fecha_ini, $fecha_fin));    ?>" target="_blank">IMPRIMIR</a>-->
        <br><br>
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>                      
                    <th>Id</th>
                    <th>Cant.</th>
                    <th>Telefono</th>
                    <th>Factura</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chips as $chip): ?>
                  <tr>
                      <td><?php echo $chip['Chip']['id'] ?></td>
                      <td><?php echo $chip['Chip']['cantidad'] ?></td>
                      <td><?php echo $chip['Chip']['telefono'] ?></td>
                      <td><?php echo $chip['Chip']['factura'] ?></td>
                      <td>
                          <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'ajax_venta_chips', $minievento['Minievento']['id'], $chip['Chip']['id'], $ususario['Persona']['id'])); ?>')" class="button green-gradient glossy">Venta</a>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <br>
        <table class="table responsive-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Cantidad Actual</th>
                    <th>Vendidos</th>
                    <th>Prec.Vendidos</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php $precio_v = 0.00; ?>
                <?php foreach ($productos as $pro): ?>
                  <?php $precio_v = $precio_v + $pro['Totale']['precio_vendidos']; ?>
                  <tr>
                      <td><?php echo $pro['Producto']['nombre'] ?></td>
                      <td><?php echo $pro['Producto']['tipo_producto'] ?></td>
                      <td><?php echo $pro['Totale']['total'] ?></td>
                      <td><?php echo $pro['Totale']['vendidos'] ?></td>
                      <td><?php echo $pro['Totale']['precio_vendidos'] . ' Bs.' ?></td>
                      <td>
                          <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'ajax_venta', $minievento['Minievento']['id'], $pro['Producto']['id'], $ususario['Persona']['id'])); ?>')" class="button green-gradient glossy">Venta</a>
                      </td>
                  </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>TOTAL</td>
                    <td><?php echo $precio_v ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table responsive-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Numero</th>
                    <th>Cliente</th>
                    <th>P. Chip</th>
                    <th>Premio</th>
                    <th>P. Premio</th>
                    <th>Referencia</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <?php $p_total_c = 0.00; ?>
                <?php foreach ($ventas_i as $key => $ve): ?>
                  <?php $p_total_c = $p_total_c + $ve['Ventasimpulsadore']['precio_chip']; ?>
                  <tr>
                      <td><?php echo $key + 1 ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['numero'] ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['nombre_cliente'] ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['precio_chip'] ?></td>
                      <td><?php echo $ve['Producto']['nombre'] ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['precio_producto'] ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['tel_referencia'] ?></td>
                      <td>
                          <?php echo $this->Html->link("Eliminar", array('action' => 'cancela_venta_chip', $ve['Ventasimpulsadore']['id']), array('class' => 'button red-gradient glossy', 'confirm' => 'Esta seguro de eliminar la venta del chip ' . $ve['Ventasimpulsadore']['numero'])) ?>
                      </td>
                  </tr>
                <?php endforeach; ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>TOTAL CHIPS</td>
                    <td><?php echo $p_total_c ?></td>
                    <td></td>
                    <td class="green"><b>TOTAL</b> </td>
                    <td class="green"><b><?php echo $p_total_c + $precio_v ?> Bs.</b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <br>
        <div class="columns">
            <div class="four-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <button class="button orange-gradient full-width" type="button" onclick="open_pago_d();">REGISTRAR PAGOS</button>
                </p>
            </div>
            <div class="four-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <button class="button green-gradient full-width" type="button" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Cajachicas','action' => 'ajax_pagos_dist',$idUser)); ?>');">PAGOS</button>
                </p>
            </div>
        </div>
        <br>
        <?php $pagos = $this->requestAction(array('controller' => 'Cajachicas', 'action' => 'get_pagos_imp', $idUser, $minievento['Minievento']['id'])) ?>

        <?php if (!empty($pagos)): ?>
          <div class="columns">
              <div class="six-columns">
                  <table class="simple-table responsive-table" style="width: 100%;">
                      <tr>
                          <td>TOTAL VENTAS</td>
                          <td><?php echo $p_total_c + $precio_v ?> Bs</td>
                      </tr>
                      <?php foreach ($pagos['bancos'] as $ba): ?>
                        <tr>
                            <td><?php echo $ba['nombre'] ?> Bs</td>
                            <td><?php echo $ba['monto'] ?> Bs</td>
                        </tr>
                      <?php endforeach; ?>
                      <tr>
                          <td>FALTANTE</td>
                          <td><?php echo $pagos['faltante'] ?> Bs</td>
                      </tr>
                      <tr>
                          <td>OTROS INGRESOS</td>
                          <td><?php echo $pagos['otro_ingreso'] ?> Bs</td>
                      </tr>
                      <tr>
                          <td>OBSERVACIONES</td>
                          <td><?php echo $pagos['observaciones'] ?></td>
                      </tr>
                      <tr>
                          <td>TOTAL</td>
                          <td><?php echo $p_total_c + $precio_v + $pagos['otro_ingreso'] ?> Bs</td>
                      </tr>
                  </table>
              </div>
              <div class="six-columns">
                  <p class="block-label button-height">
                      <label for="block-label-1" class="label">&nbsp;</label>


                  </p>
              </div>
          </div>

        <?php endif; ?>
    </div>
</section>	
<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu -->
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'TARJETAS'): ?>
  <?php echo $this->element('sidebar/tarjetas'); ?>
  <?php elseif ($this->Session->read('Auth.User.Group.name') == 'Recargas'): ?>
  <?php echo $this->element('sidebar/recargas'); ?>
<?php endif; ?>

<script>
  function open_pago_d() {
      cargarmodal('<?php echo $this->Html->url(array('controller' => 'Cajachicas', 'action' => 'pago_dist', $idUser, ($p_total_c + $precio_v), date('Y-m-d'), $idMiniEvento)); ?>');
  }
</script>