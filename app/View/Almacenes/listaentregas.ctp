<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>
            Entregas <?php echo $nombre ?>
        </h1>
    </hgroup>

    <div class="with-padding">
        <?php if ($this->Session->read('Auth.User.Group.id') == 1 || $this->Session->read('Auth.User.Group.id') == 4): ?>
          <?php if (!empty($pedidos)): ?>
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
          <?php endif; ?>
          <?php if ($almacen == 0 && $distribuidor['User']['group_id'] == 7 && !empty($minieventos)): ?>
            <table class="table responsive-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Evento Direccion</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($minieventos as $mi): ?>
                      <tr>
                          <td><?php echo $mi['Minievento']['fecha'] ?></td>
                          <td><?php echo $mi['Minievento']['direccion'] ?></td>
                          <td>
                              <?php echo $this->Html->link("Ingresar", array('controller' => 'Impulsadores', 'action' => 'ventas_minievento2', $mi['Minievento']['id'], $distribuidor['User']['id']), array('class' => 'button blue-gradient full-width', 'target' => '_blank')) ?>
                          </td>
                      </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>

          <?php endif; ?>
          <?php if ($distribuidor['User']['group_id'] == 7): ?>
            <div class="columns">
                <div class="four-columns new-row-mobile twelve-columns-mobile">
                    <p class="block-label button-height">
                        <?php echo $this->Html->link("ASIGNARLE CHIPS", array('controller' => 'Chips', 'action' => 'asigna_distrib', $distribuidor['User']['id']), array('class' => 'button blue-gradient full-width', 'target' => '_blank')) ?>
                    </p>
                </div>
                <div class="four-columns new-row-mobile twelve-columns-mobile">
                    <p class="block-label button-height">
                        <?php echo $this->Html->link("CHIPS ASIGNADOS", array('controller' => 'Chips', 'action' => 'asignados_imp', $distribuidor['User']['id']), array('class' => 'button black-gradient full-width', 'target' => '_blank')) ?>
                    </p>
                </div>
            </div>
          <?php endif; ?>
          <?php if ($almacen == 0 && $distribuidor['User']['group_id'] == 2): ?>
            <script>
              var total_pa_d = 0.00;
              var fecha_ini_d_v = '<?php echo date('Y-m-d') ?>';
              function open_pago_d() {
                  cargarmodal('<?php echo $this->Html->url(array('controller' => 'Cajachicas', 'action' => 'pago_dist', $distribuidor['User']['id'])); ?>/' + total_pa_d + '/' + fecha_ini_d_v);

              }
            </script>
            <div class="columns">
                <div class="twelve-columns">
                    <h3 class="thin">Listado de Ventas</h3>
                    <?php echo $this->Form->create(NULL, array('id' => 'form-ventas', 'url' => array('controller' => 'Almacenes', 'action' => 'ajax_ventas_dist'))); ?>
                    <div class="columns ocultar_impresion">
                        <div class="four-columns twelve-columns-mobile">
                            <p class="block-label button-height">
                                <label for="block-label-1" class="label">Fecha Inicial</label>
                                <span class="input">
                                    <span class="icon-calendar"></span>
                                    <?php echo $this->Form->text('Dato.fecha_ini', array('class' => 'input-unstyled datepicker', 'value' => date('Y-m-d'))); ?>
                                </span>
                            </p>
                        </div>
                        <div class="four-columns new-row-mobile twelve-columns-mobile">
                            <p class="block-label button-height">
                                <label for="block-label-1" class="label">Fecha Final</label>
                                <span class="input">
                                    <span class="icon-calendar"></span>
                                    <?php echo $this->Form->text('Dato.fecha_fin', array('class' => 'input-unstyled datepicker', 'value' => date('Y-m-d'))); ?>
                                </span>
                            </p>
                        </div>
                        <div class="four-columns new-row-mobile twelve-columns-mobile">
                            <p class="block-label button-height">
                                <label for="block-label-1" class="label">&nbsp;</label>
                                <button class="button green-gradient full-width" type="submit">VER VENTAS</button>
                            </p>
                        </div>
                    </div>
                    <?php echo $this->Form->hidden('Dato.persona_id', array('value' => $idPersona)); ?>
                    <?php echo $this->Form->end(); ?>
                    <script>
                      $("#form-ventas").submit(function (e)
                      {
                          carga_ventas_d_a();
                          e.preventDefault(); //STOP default action
                          //e.unbind(); //unbind. to stop multiple form submit.
                      });
                      function carga_ventas_d_a() {
                          var postData = $("#form-ventas").serializeArray();
                          var formURL = $("#form-ventas").attr("action");
                          $.ajax(
                                  {
                                      url: formURL,
                                      type: "POST",
                                      data: postData,
                                      /*beforeSend:function (XMLHttpRequest) {
                                       alert("antes de enviar");
                                       },
                                       complete:function (XMLHttpRequest, textStatus) {
                                       alert('despues de enviar');
                                       },*/
                                      success: function (data, textStatus, jqXHR)
                                      {
                                          //data: return data from server
                                          $("#div-ventas").html(data);
                                      },
                                      error: function (jqXHR, textStatus, errorThrown)
                                      {
                                          //if fails   
                                          alert("error");
                                      }
                                  });
                      }
                    </script>
                    <div id="div-ventas">

                    </div>

                    <div class="columns">
                        <div class="four-columns new-row-mobile twelve-columns-mobile">
                            <p class="block-label button-height">
                                <?php echo $this->Html->link("ASIGNARLE CHIPS", array('controller' => 'Chips', 'action' => 'asigna_distrib', $distribuidor['User']['id']), array('class' => 'button blue-gradient full-width', 'target' => '_blank')) ?>
                            </p>
                        </div>
                        <div class="four-columns new-row-mobile twelve-columns-mobile">
                            <p class="block-label button-height">
                                <button class="button orange-gradient full-width" type="button" onclick="open_pago_d();">REGISTRAR PAGOS</button>
                            </p>
                        </div>
                        <div class="four-columns new-row-mobile twelve-columns-mobile">
                            <p class="block-label button-height">
                                <button class="button green-gradient full-width" type="button" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Cajachicas', 'action' => 'ajax_pagos_dist', $distribuidor['User']['id'])); ?>');">PAGOS</button>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
          <?php endif; ?>
        <?php endif; ?>
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
                                Categoria
                            </th>
                            <th>
                                Marca
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
                                  <?php echo $entrega['Producto']['tipo_producto']; ?>
                              </td>
                              <td>
                                  <?php echo $entrega['Totale']['marca']; ?>
                              </td>
                              <td>
                                  <?php echo $entrega['Totale']['total']; ?>
                              </td>
                              <td>
                                  <?php
                                  $idProducto = $entrega['Totale']['producto_id'];
                                  /* if ($entrega['Producto']['tiposproducto_id'] == 1):
                                    echo
                                    $this->Html->link('Rango&lote', array('action' => 'verdetalle', $idPersona, $almacen, $idProducto));
                                    endif; */
                                  ?>
                                  <a href="javascript:" class="button anthracite-gradient" onclick="cargarmodal('<?php echo $this->Html->url(array('action' => 'detalle_mov', $idProducto, $idPersona, $almacen)); ?>', 'Detalle de <?php echo $entrega['Producto']['nombre']; ?>')">Detalle</a>
                                  <?php //echo $this->Html->link('Entregas', array('action' => 'verentregas', $idPersona, $almacen, $idProducto)); ?>
                                  <!--<a href="javascript:" class="button orange-gradient" title="Entregar"><span class="icon-up"></span></a>-->
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
<?php echo $this->Html->script(array('ini_entrega', 'libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add')) ?>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu -->
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'TARJETAS'): ?>
  <?php echo $this->element('sidebar/tarjetas'); ?>
  <?php elseif ($this->Session->read('Auth.User.Group.name') == 'Recargas'): ?>
  <?php echo $this->element('sidebar/recargas'); ?>
<?php endif; ?>
<?php echo $this->element('jsvalidador'); ?>

<?php
//echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1', 'ini_lg_datepicker'), array('block' => 'js_add'))
?>