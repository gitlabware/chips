<section role="main" id="main">
    <hgroup id="main-title" class="thin" align="center">
        <h1>FORMULARIO DE PEDIDO</h1>
    </hgroup>
    <div class="with-padding"> 
        <div class="columns">
            <div class="three-columns hidden-phone">

            </div>
            <div class="six-columns twelve-columns-mobile">
                <?php echo $this->Form->create(NULL, array('url' => array('controller' => 'Ventasdistribuidor', 'action' => 'registra_pedido'))); ?>
                <p class="block-label button-height">
                <fieldset class="fieldset">
                    <p class="block-label button-height">
                    <div class="columns">
                        <div class="twelve-columns">
                            <!--<p class="button-height inline-label">
                                <label class="label">Monto</label>
                                <?php //echo $this->Form->text("Dato.monto", array('class' => 'input')); ?>
                                <?php echo $this->Form->hidden("Dato.numero"); ?>
                            </p>-->
                            <?php $i = 0; ?>
                            <?php foreach ($productos as $pro): ?>
                              <?php
                              $valor_cantidad = '';
                              if (!empty($pedidos_c[$pro['Producto']['id']])) {
                                $valor_cantidad = $pedidos_c[$pro['Producto']['id']];
                              }
                              if (!empty($pedidos_i[$pro['Producto']['id']])) {
                                echo $this->Form->hidden("Pedido.$i.id", array('value' => $pedidos_i[$pro['Producto']['id']]));
                              }
                              ?>
                              <p class="button-height inline-label">
                                  <label class="label"><?php echo $pro['Producto']['nombre']; ?></label>
                                  <?php echo $this->Form->hidden("Pedido.$i.producto_id", array('value' => $pro['Producto']['id'])); ?>
                                  <?php echo $this->Form->text("Pedido.$i.cantidad", array('class' => 'input', 'value' => $valor_cantidad)); ?>
                              </p>
                              <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    </p>
                </fieldset>
                </p>
                <p class="block-label button-height">
                    <button type="submit" class="button anthracite-gradient glossy full-width">REGISTRAR PEDIDO</button>
                </p>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="three-columns hidden-phone">

            </div>
        </div>
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 
