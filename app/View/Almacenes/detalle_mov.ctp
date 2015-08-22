<div class="with-padding">
    <table class="simple-table responsive-table" id="sorting-example2">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingreso</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $mov): ?>
              <tr>
                  <td><?php echo $mov['Movimiento']['created']; ?></td>
                  <td><?php echo $mov['Movimiento']['ingreso']; ?></td>
                  <td>
                      <?php echo $this->Html->link("Eliminar", array('action' => 'elimina_movimiento', $mov['Movimiento']['transaccion'], $almacen), array('class' => 'tag red-bg', 'confirm' => 'Esta seguro de eliminar el registro???')) ?>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>