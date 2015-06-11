<div class="with-padding">
    <table class="simple-table responsive-table" id="sorting-example2">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Total</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $mov): ?>
              <tr>
                  <td><?php echo $mov['Movimiento']['created'];?></td>
                  <td><?php echo $mov['Movimiento']['ingreso'];?></td>
                  <td><?php echo $mov['Movimiento']['salida'];?></td>
                  <td><?php echo $mov['Movimiento']['total'];?></td>
                  <td>
                      <?php if($ultimo['Movimiento']['transaccion'] == $mov['Movimiento']['transaccion']):?>
                    <?php echo $this->Html->link("Eliminar",array('action' => 'elimina_movimiento',$mov['Movimiento']['transaccion']),array('class' => 'tag red-bg','confirm' => 'Esta seguro de eliminar el registro???'))?>
                      <?php endif;?>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>