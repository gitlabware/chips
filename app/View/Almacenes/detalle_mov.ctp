<div class="with-padding">
    <table class="simple-table responsive-table" id="sorting-example2">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Ingreso</th>
                <th>Salida</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $mov): ?>
              <tr>
                  <td><?php echo $mov['Movimiento']['created'];?></td>
                  <td><?php echo $mov['Movimiento']['ingreso'];?></td>
                  <td><?php echo $mov['Movimiento']['salida'];?></td>
                  <td><?php echo $mov['Movimiento']['total'];?></td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>