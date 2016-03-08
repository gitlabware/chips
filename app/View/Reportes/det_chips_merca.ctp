<tr id="tablar-<?php echo $idCliente; ?>">
    <td colspan="5" style="margin: 0px !important; border: 0px !important; padding: 0px !important;">
        <table class="table" style="background-color: seashell; margin: 0px !important;">
            <tr>
                <td>Telefono</td>
                <td>F. entrega</td>
                <td>F. Activacion</td>
                <td>Comercial</td>
            </tr>
            <?php foreach ($chips_entregados as $che): ?>

              <tr>
                  <td><?php echo $che['Chip']['telefono']; ?></td>
                  <td><?php echo $che['Chip']['fecha_entrega_c']; ?></td>
                  <td><?php echo $che['Chip']['fecha_activacion']; ?></td>
                  <td><?php echo $che['Chip']['comercial']; ?></td>
              </tr>
            <?php endforeach; ?>
        </table>
    </td>
</tr>