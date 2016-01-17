<section role="main" id="main">

    <hgroup id="main-title" class="thin">
        <h1>Minievento <?php echo $minievento['Minievento']['direccion'] ?></h1>
    </hgroup>

    <div class="with-padding">
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
                          <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'ajax_venta_chips', $minievento['Minievento']['id'], $chip['Chip']['id'])); ?>')" class="button green-gradient glossy">Venta</a>
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
                          <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'ajax_venta', $minievento['Minievento']['id'], $pro['Producto']['id'])); ?>')" class="button green-gradient glossy">Venta</a>
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
    </div>
</section>	
<?php echo $this->element('sidebar/impulsador'); ?>
