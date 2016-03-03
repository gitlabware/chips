<?php
$meses = array(
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Sepetiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Disciembre'
);
?>

<table class="table">
    <thead>
        <tr>
            <th colspan="4" style="text-align: center;"><?php echo $ano.' - '.$meses[$mes]?></th>
        </tr>
        <tr>
            <th>Codigo</th>
            <th>Mercado</th>
            <th>Meta</th>
            <th>Ventas</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($metas as $me): ?>
          <tr>
              <td><?php echo $me['Ruta']['cod_ruta']; ?></td>
              <td><?php echo $me['Ruta']['nombre']; ?></td>
              <td><?php echo $me['Meta']['meta']; ?></td>
              <td><?php echo $me['Meta']['ventas']; ?></td>
          </tr>
        <?php endforeach; ?>
    </tbody>
</table>