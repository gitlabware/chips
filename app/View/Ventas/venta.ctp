<div class="with-padding">
    <?php echo $this->Form->create('Venta', array('action' => "registra_venta_cli/$idVenta")); ?>
    <?php echo $this->Form->hidden("Ventascliente.ventasdistribuidore_id", array('value' => $idVenta)) ?>
    <?php echo $this->Form->hidden("Ventascliente.cliente_id", array('value' => $idCliente)) ?>
    <div class="columns">

        <fieldset class="fieldset">
            <legend class="legend"><?php echo $cliente['Cliente']['nombre'] . " (" . $venta['Ventasdistribuidore']['fecha'] . ")"; ?></legend>
            <p class="button-height inline-large-label">
                <label class="label">Estado del punto</label>
                <?php echo $this->Form->select('Ventascliente.estado_pdv', $estados, array('class' => 'select full-width')); ?>
            </p>
            <p class="button-height inline-large-label">
                <label class="label">Capacitacion</label>
                <?php echo $this->Form->select('Ventascliente.cap', $capacitacion, array('class' => 'select full-width')); ?>
            </p>
            <?php foreach ($productos as $key => $pro): ?>
              <?php if (!empty($pro['Ventasproducto']['id'])): ?>
                <?php $this->request->data['Ventasproducto'][$key] = $pro['Ventasproducto']; ?>
              <?php endif; ?>
              <p class="button-height inline-large-label">
                  <label class="label"><?php echo $pro['Producto']['nombre']; ?></label>
                  <?php echo $this->Form->hidden("Ventasproducto.$key.id") ?>
                  <?php echo $this->Form->hidden("Ventasproducto.$key.ventasdistribuidore_id", array('value' => $idVenta)) ?>
                  <?php echo $this->Form->hidden("Ventasproducto.$key.cliente_id", array('value' => $idCliente)) ?>
                  <?php echo $this->Form->hidden("Ventasproducto.$key.producto_id", array('value' => $pro['Producto']['id'])) ?>
                  <?php echo $this->Form->text("Ventasproducto.$key.cantidad", array('class' => 'input full-width', 'placeholder' => 'cantidad', 'type' => 'number')); ?>
              </p>
            <?php endforeach; ?>
            <p class="button-height inline-large-label">
                <label class="label">Recarga</label>
                <?php echo $this->Form->text('Ventascliente.recarga', array('class' => 'input full-width', 'type' => 'number')); ?>
            </p>
            <p class="button-height inline-large-label">
                <label class="label"># Recarga</label>
                <?php echo $this->Form->text('Ventascliente.n_recarga', array('class' => 'input full-width', 'type' => 'number')); ?>
            </p>
            <p class="button-height inline-large-label">
                <label class="label">Linea Abonable</label>
                <?php echo $this->Form->text('Ventascliente.linea_abonable', array('class' => 'input full-width', 'type' => 'number')); ?>
            </p>
            <p class="button-height">
                <button type="submit" class="button green-gradient glossy full-width">REGISTRAR</button>
            </p>
        </fieldset>

    </div>
    <?php echo $this->Form->end(); ?>
</div>
