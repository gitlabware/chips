<table class="simple-table responsive-table" id="sorting-example2">
    <thead>
        <tr>
            <th>
                No.
            </th>
            <th>
                Prod
            </th>
            <th>
                Cant.
            </th>
            <th>
            </th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td colspan="5">
                6 entries found
            </td>
        </tr>
    </tfoot>
    <tbody>
        <?php $c = 0; ?>
        <?php foreach ($ventas as $v): ?>
          <tr>
              <th scope="row">
                  <?php echo $c; ?>
              </th>
              <td>
                  <?php echo $v['Producto']['nombre']; ?>
              </td>
              <td>
                  1
              </td>
              <td class="align-right vertical-center">
                  <span class="button-group compact">
                      <a href="#" class="button icon-trash with-tooltip confirm" title="Eliminar"></a>
                      <?php
                      $nombre = $p['Producto']['nombre'];
                      echo $this->Ajax->link($nombre, array(
                        'controller' => 'Productosprecios',
                        'action' => 'ajaxpidetienda', $p['Producto']['id']), array(
                        'update' => 'cargaDatos',
                        'escape' => false,
                        'class' => 'button green-gradient glossy',
                        'style' => 'margin-bottom: 10px; text-transform: uppercase; font-size: 150%; padding: 10px 15px 10px 15px'));
                      ?>
                  </span>
              </td>					
          </tr>
  <?php $c++; ?>
        <?php endforeach; ?>
        <tr>
            <th scope="row">
                1
            </th>
            <td>
                V10
            </td>
            <td>
                3
            </td>
            <td class="align-right vertical-center">
                <span class="button-group compact">
                    <a href="#" class="button icon-trash with-tooltip confirm" title="Delete"></a>
                </span>
            </td>
        </tr>
    </tbody>
</table>