<div class="with-padding">
    <?php echo $this->Form->create('Almacene', array('action' => 'registra_entrega')); ?>
    <div class="columns">
        <div class="eight-columns">
            <h3><?php echo $producto['Producto']['nombre']; ?></h3>
        </div>
        <div class="four-columns">
            <?php if ($almacen['Almacene']['central'] != 1): ?>
              <span class="tag red-bg">
                  <?php
                  if (!empty($ultimo)) {
                    echo 'Hay ' . $ultimo['Ventascelulare']['total'] . ' en almacen central';
                  } else {
                    echo 'Hay 0 en almacen central';
                  }
                  ?>
              </span>
            <?php endif; ?>
        </div>
        <div class="six-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">Cantidad a entregar<small>(requerido)</small></label> 
                <?php echo $this->Form->hidden('Ventascelulare.producto_id', array('value' => $idProducto)) ?>
                <?php echo $this->Form->hidden('Ventascelulare.almacene_id', array('value' => $almacen['Almacene']['id'])) ?>
                <?php echo $this->Form->hidden('Ventascelulare.sucursal_id', array('value' => $almacen['Almacene']['sucursal_id'])) ?>
                <?php echo $this->Form->hidden('Ventascelulare.user_id', array('value' => $this->Session->read('Auth.User.id'))) ?>
                <?php echo $this->Form->text('Ventascelulare.entrada', array('class' => 'input full-width', 'placeholder' => 'Ingrese la cantidad', 'value' => "", 'required')); ?>
            </p>
        </div>
        <div class="six-columns">
            <p class="block-label button-height">
                <label class="label">&nbsp;</label>
                <button class="button green-gradient full-width" type="submit">REGISTRAR</button>
            </p>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>

    <table class="simple-table responsive-table" id="sorting-example2">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movimientos as $mo): ?>
              <tr>
                  <td><?php echo $mo['Ventascelulare']['created'] ?></td>
                  <td><?php echo $mo['Ventascelulare']['entrada'] ?></td>
                  <td>
                      <a class="button red-gradient compact icon-cross-round" href="javascript:" onclick="quita_precio(<?php echo $mo['Ventascelulare']['id']; ?>)">Quitar</a>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>