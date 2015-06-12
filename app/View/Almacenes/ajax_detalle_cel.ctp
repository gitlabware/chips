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
                  <td><?php echo $mov['Ventascelulare']['created'];?></td>
                  <td><?php echo $mov['Ventascelulare']['entrada'];?></td>
                  <td><?php echo $mov['Ventascelulare']['salida'];?></td>
                  <td><?php echo $mov['Ventascelulare']['total'];?></td>
                  <td>
                      <?php if($ultimo['Ventascelulare']['transaccion'] == $mov['Ventascelulare']['transaccion']):?>
                    <?php echo $this->Html->link("Eliminar",array('action' => 'elimina_movimiento',$mov['Ventascelulare']['transaccion']),array('class' => 'tag red-bg','confirm' => 'Esta seguro de eliminar el registro???'))?>
                      <?php endif;?>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>