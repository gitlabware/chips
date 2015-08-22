<section role="main" id="main">
    <noscript class="message black-gradient simpler">
    Your browser does not support JavaScript! Some features won't work as expected...
    </noscript>
    <hgroup id="main-title" class="thin">
        <h1>
            Entregas
            <?php echo $nombre ?>
        </h1>
    </hgroup>
    <div class="with-padding">
        <div class="columns">
            <div class="twelve-columns">
                <h3 class="thin">Listado de ultimo pedido</h3>
                <table class="simple-table responsive-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pe): ?>
                          <tr>
                              <td><?php echo $pe['Pedido']['created']; ?></td>
                              <td><?php echo $pe['Producto']['nombre']; ?></td>
                              <td><?php echo $pe['Pedido']['cantidad']; ?></td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="columns">
            <div class="six-columns twelve-columns-tablet">
                <h3 class="thin">
                    Listado entregados
                </h3>
                <table class="table responsive-table" id="sorting-advanced">
                    <thead>
                        <tr>
                            <th scope="col" width="15%" class="align-center hide-on-mobile">
                                Producto
                            </th>
                            <th>
                                Proveedor
                            </th>
                            <th>
                                Cantidad
                            </th>
                            <th scope="col" width="30%" class="align-center">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($entregas as $entrega): ?>
                          <tr>
                              <td>
                                  <?php echo $entrega['Producto']['nombre']; ?>
                              </td>
                              <td>
                                  <?php echo $entrega['Producto']['proveedor']; ?>
                              </td>
                              <td>
                                  <?php echo $entrega['Totale']['total']; ?>
                              </td>
                              <td>
                                  <?php
                                  $idProducto = $entrega['Totale']['producto_id'];
                                  /*if ($entrega['Producto']['tiposproducto_id'] == 1):
                                    echo
                                    $this->Html->link('Rango&lote', array('action' => 'verdetalle', $idPersona, $almacen, $idProducto));
                                  endif;*/
                                  ?>
                                  <a href="javascript:" class="button anthracite-gradient" onclick="cargarmodal('<?php echo $this->Html->url(array('action' => 'detalle_mov',$idProducto,$idPersona,$almacen));?>','Detalle de <?php echo $entrega['Producto']['nombre']; ?>')">Detalle</a>
                                  <?php //echo $this->Html->link('Entregas', array('action' => 'verentregas', $idPersona, $almacen, $idProducto));?>
                              </td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div>
                    <?php
                    /* echo
                      $this->Ajax->link(
                      'entregar mas +', array(
                      'controller' => 'Almacenes',
                      'action' => 'ajaxrepartir', $idPersona, $almacen), array('update' => 'cargaForm',
                      'title' => 'Formulario de entregas','class'=>'button green-gradient')
                      ) */
                    ?>					
                </div>
            </div>
            <div class="six-columns twelve-columns-tablet" id="cargaForm">
                <h3 class="thin">Recarga formulario de entrega</h3>
                <p>en este espacio recarga el fomrulario para registro de nueva entrega.</p>
            </div>
        </div>
        <div class="columns">
            <div class="twelve-columns">
                
            </div>
        </div>
    </div>
</section>
<script>
  var urlentrega = '<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'ajaxrepartir', $idPersona, $almacen)); ?>';
</script>
<?php echo $this->Html->script(array('ini_entrega'), array('block' => 'js_add')) ?>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu -->
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
<?php echo $this->element('jsvalidador'); ?>