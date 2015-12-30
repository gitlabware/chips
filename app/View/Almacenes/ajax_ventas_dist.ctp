<table class="simple-table responsive-table">
    <thead>
        <tr>
            <th style="text-align: center;">Producto</th>
            <th style="text-align: center;">Saldo Anterior</th>
            <th style="text-align: center;">Ingreso</th>
            <th style="width: 35%; text-align: center;">Ventas</th>
            <th style="text-align: center;">Bs.</th>
            <th style="text-align: center;">Saldo Actual</th>
            <th style="text-align: center;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_bs = 0.00; ?>
        <?php foreach ($productos as $pro): ?>
          <?php
          $venta_total = 0.00;
          $venta_prec_total = 0.00;
          $entregado = 0;
          $datos = $this->requestAction(array('action' => 'get_ventas_dist', $fecha_ini, $fecha_fin, $persona, $pro['Producto']['id']));
          $datos2 = $this->requestAction(array('action' => 'get_precios_prod', $fecha_ini, $fecha_fin, $persona, $pro['Producto']['id']));
          if (!empty($datos)) {
            $da = $datos[0];
            foreach ($datos2 as $dato) {
              $venta_total = $venta_total + $dato[0]['vendidos'];
              $venta_prec_total = $venta_prec_total + $dato[0]['precio_total'];
            }
            $saldo = $pro['Productosprecio']['total_s'] - $da[0]['entregado'] + $venta_total;

            $entregado = $da[0]['entregado'];
          } else {
            $da = NULL;
            $saldo = $pro['Productosprecio']['total_s'];
          }
          ?>
          <tr>
              <td style="text-align: center;"><?php echo $pro['Producto']['nombre']; ?></td>

              <td style="text-align: center;"><?php echo $saldo ?></td>
              <td style="text-align: center;"><?php echo $entregado ?></td>
              <td>
                  <table style="width: 100%;">
                      <?php foreach ($datos2 as $dato): ?>
                        <tr>
                            <td> <?php echo $dato['Productosprecio']['precio'] ?> Bs. </td>
                            <td> <?php echo $dato[0]['vendidos'] ?> vendidos</td>
                            <td> <?php echo $dato[0]['precio_total'] ?> Bs</td>
                        </tr>

                      <?php endforeach; ?>
                  </table>
              </td>
              <?php
              $total_bs = $total_bs + $venta_prec_total;
              ?>
              <td style="text-align: center;"><?php echo $venta_prec_total ?></td>
              <td style="text-align: center;"><?php echo $pro['Productosprecio']['total_s'] ?></td>
              <td style="text-align: center;">
                  <a href="javascript:" class="button green-gradient compact icon-page-list" onclick="cargarmodal('<?php echo $this->Html->url(array('action' => 'ajax_venta', $fecha_ini, $fecha_fin, $persona, $pro['Producto']['id'])); ?>')" title="Rutas"></a>
                  <?php //echo $this->Html->link('Venta', array('controller' => 'Ventas', 'action' => 'listaentregas', $pro['Producto']['nombre'], 0), array('class' => 'button green-gradient compact icon-mailbox', 'title' => 'Registrar Venta')); ?>
              </td>
          </tr>
        <?php endforeach; ?>
        <?php $total_recarga = 0.00; ?>

        <?php
        $chips_r = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_num_chips_dist', $fecha_ini, $fecha_fin, $distribuidor['User']['id']));
        $c_ingresos = 0;
        $c_total_s = 0;
        if (!empty($chips_r)) {
          $c_ingresos = $chips_r[0]['Chip']['ingresado'];
          $c_total_s = $chips_r[0][0]['total_S'];
        }
        $precios_c = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_precios_ven'));
        ?>
        <tr>
            <td style="text-align: center;">Chips</td>

            <td style="text-align: center;"><?php echo $c_total_s - $c_ingresos ?></td>
            <td style="text-align: center;"><?php echo $c_ingresos ?></td>
            <td style="text-align: center;">
                <table style="width: 100%">
                    <tr>
                        <?php foreach ($precios_c as $preci): ?>
                          <td><?php echo $preci['Precio']['monto'] . ' Bs.' ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>

                        <?php
                        $num_chips_p_t = 0.00;
                        foreach ($precios_c as $preci):
                          ?>
                          <?php
                          $num_chips = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_num_vent_d', $fecha_ini, $fecha_fin, $distribuidor['User']['id'], $preci['Precio']['monto']));
                          $num_chips_p_t = $num_chips_p_t + ($num_chips * $preci['Precio']['monto']);
                          ?>
                          <td><?php echo $num_chips ?></td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;"><?php echo $num_chips_p_t; ?></td>
            <td style="text-align: center;"><?php echo $c_total_s ?></td>
            <td style="text-align: center;">


            </td>
        </tr>
        <tr>
            <td>Recarga</td>
            <td></td>
            <td></td>
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; text-align: center;">
                            OFICINA
                            <table style="width: 100%;">
                                <tr>
                                    <?php foreach ($porcentajes as $por): ?>
                                      <td><?php echo $por['Porcentaje']['nombre'] . '%' ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php foreach ($porcentajes as $por): ?>
                                      <?php $total_recarga = $total_recarga + $rec_por = $this->requestAction(array('controller' => 'Recargados', 'action' => 'get_recargas_dist', $fecha_ini, $fecha_fin, $persona, $por['Porcentaje']['id'])) ?>
                                      <td><?php echo $rec_por ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 50%; text-align: center;">
                            DISTRIBUIDOR
                            <table style="width: 100%;">
                                <tr>
                                    <?php foreach ($porcentajes as $por): ?>
                                      <td><?php echo $por['Porcentaje']['nombre'] . '%' ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php foreach ($porcentajes as $por): ?>
                                      <td><?php //echo $por['Porcentaje']['nombre'].'%'              ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="text-align: center;">
                TOTAL<br><br>
                <?php echo $total_recarga ?>
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL</td>
            <td style="text-align: center;"><?php echo $total_bs + $total_recarga ?></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>



<script>
  function mensaje_nota(titulo, texto) {
      notify(titulo, texto, {
          system: true,
          vPos: 'top',
          hPos: 'right',
          autoClose: true,
          icon: false ? 'img/demo/icon.png' : '',
          iconOutside: true,
          closeButton: true,
          showCloseOnHover: true,
          groupSimilar: true
      });
  }
</script>