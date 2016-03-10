<h3 id="tit-entregas">
    ULTIMOS PAGOS DE <?php echo $distribuidor['Persona']['nombre'].' '.$distribuidor['Persona']['ap_paterno']?>
</h3>

<div class="with-padding">
    <table class="simple-table responsive-table" id="sorting-example2">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto Pagado</th>
                <th>Faltante</th>
                <th>Otro Ingreso</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $pa): ?>
              <tr>
                  <td><?php echo $pa['Distribuidorpago']['fecha']; ?></td>
                  <td><?php echo $pa['Distribuidorpago']['monto_pagado']; ?></td>
                  <td><?php echo $pa['Distribuidorpago']['faltante']; ?></td>
                  <td><?php echo $pa['Distribuidorpago']['otro_ingreso']; ?></td>
                  <td>
                      <?php echo $this->Html->link("Eliminar", array('action' => 'elimina_pago_dist', $pa['Distribuidorpago']['id']), array('class' => 'tag red-bg', 'confirm' => 'Esta seguro de eliminar el registro???')) ?>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
