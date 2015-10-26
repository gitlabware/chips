<!-- Main content -->
<div id="main" class="contenedor">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Tienda <?php echo $this->Session->read("Auth.User.Sucursal.nombre") ?></h1>
    </hgroup>
    <style>
        .dataTables_wrapper, .dataTables_header, .dataTables_footer {
            background: -webkit-linear-gradient(top, #b1dc64, #58b104 50%, #499400 50%, #5eb80a);
            border-color: #6d960c;
        }
        .paginate_enabled_previous:hover, .paginate_enabled_next:hover, .paging_full_numbers a:hover{
            background: -webkit-linear-gradient(top, #b1dc64, #58b104 50%, #499400 50%, #5eb80a);
            border-color: #6d960c;
        }
        .paginate_disabled_previous, .paginate_enabled_previous, .paginate_disabled_next, .paginate_enabled_next, .paging_full_numbers a{
            background: -webkit-linear-gradient(top, #b1dc64, #58b104 50%, #499400 50%, #5eb80a);
            border-color: #6d960c;
        }
        .paging_full_numbers a.paginate_active, .paging_full_numbers a.paginate_active.first, .paging_full_numbers a.paginate_active.last{
            background: -webkit-linear-gradient(top, #499400, #5eb80a);
            border-color: #6d960c;
        }
    </style>
    <div class="with-padding">
        <div class="columns">
            <div class="seven-columns twelve-columns-mobile twelve-columns-tablet">
                <table class="table responsive-table verde" id="sorting-advanced">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Marca</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Imagen</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $pro): ?>
                          <tr>
                              <td><?php echo $pro['Producto']['nombre'] ?></td>
                              <td><?php echo $pro['Productosprecio']['marca']?></td>
                              <td><?php echo $pro['Producto']['tipo_producto'] ?></td>
                              <td><?php echo $pro['Productosprecio']['precio'] ?></td>
                              <td><?php echo $pro['Productosprecio']['total'] ?></td>
                              <td>
                                  <?php if (!empty($pro['Producto']['url_imagen'])): ?>
                                    <a href="javascript:" onclick="openModal(<?= $pro['Producto']['id'] ?>,'<?= $pro['Producto']['nombre'] ?>');"><img src="<?php echo $this->webroot . '' . $pro['Producto']['url_imagen'] ?>" height="51" width="51"></a>
                                  <?php endif; ?>
                              </td>
                              <td>
                                  <a href="javascript:" class="button anthracite-gradient glossy" onclick="add_venta(<?php echo $pro['Producto']['id']; ?>, '<?php echo $pro['Producto']['nombre']; ?>',<?php echo $pro['Productosprecio']['precio']; ?>)" title="Adicionar"><span class="icon-cart"></span></a>
                              </td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!--
                                <div class="standard-tabs margin-bottom">
                                    <ul class="tabs">
                <?php foreach ($categorias as $llave => $c): ?>
                  <?php
                  $t_activo = '';
                  if ($llave == 0) {
                    $t_activo = 'active';
                  }
                  ?>
                                                        <li class="<?php echo $t_activo; ?>">
                                                            <a href="#tab-<?php echo $llave + 1; ?>">
                  <?php echo $c['Tiposproducto']['nombre']; ?>
                                                            </a>
                                                        </li>
                <?php endforeach; ?>
                                    </ul>
                
                                    <div class="tabs-content">
                <?php foreach ($categorias as $llave => $c): ?>
                  <?php
                  $color = 'white';
                  if (!empty($c['Tiposproducto']['desc'])) {
                    $color = $c['Tiposproducto']['desc'];
                  }
                  $tab_activo = '';

                  if ($llave == 0) {
                    $tab_activo = 'tab-active';
                    //debug($tab_activo);
                  }
                  ?>
                                                        <div id="tab-<?php echo $llave + 1; ?>" class="with-padding <?php echo $tab_activo; ?>">
                  <?php foreach ($productos as $p): ?>
                    <?php if ($c['Tiposproducto']['id'] == $p['Producto']['tiposproducto_id']): ?> 
                                                                                            <a href="javascript:" class="<?php echo "button $color-gradient glossy"; ?>" onclick="add_venta(<?php echo $p['Producto']['id']; ?>, '<?php echo $p['Producto']['nombre']; ?>',<?php echo $p['Productosprecio']['precio']; ?>)" style="margin-bottom: 10px; text-transform: uppercase; font-size: 150%; padding: 10px 15px 10px 15px"><?php echo $p['Producto']['nombre']; ?></a>
                      <?php
                      /* $nombre = $p['Producto']['nombre'];
                        echo $this->Ajax->link(
                        $nombre, array(
                        'controller' => 'Tiendas',
                        'action' => 'ajaxpidetienda', $p['Productosprecio']['id'], $p['Producto']['id'], $p['Productosprecio']['precio']), array(
                        'update' => 'cargaDatos',
                        'escape' => false,
                        'class' => "button $color-gradient glossy",
                        'style' => 'margin-bottom: 10px; text-transform: uppercase; font-size: 150%; padding: 10px 15px 10px 15px'
                        )
                        ); */
                      ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                                                        </div>
                <?php endforeach; ?>
                                    </div>
                                </div>-->
            </div>
            <div class="five-columns new-row-mobile new-row-tablet twelve-columns-mobile twelve-columns-tablet">
                <div class="simpler">                     
                    <div id="cargaDatos" class="table-header button-height">
                        <span id="spancantprod"></span>
                        <table class="simple-table responsive-table responsive-table-on" id="sorting-example2">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Precio.</th>
                                    <th>Quitar</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td>TOTAL</td>
                                    <td id="idcanttotal">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php echo $this->Form->create('Tienda', array('action' => 'registra_venta_t', 'id' => 'idformventa')); ?>
                        <button class="button green-gradient glossy full-width" type="submit">REGISTRAR</button>
                        <?php echo $this->Form->end() ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 
<?php echo $this->Html->script(array('developr.modal'), array('block' => 'js_add')) ?>
<?php echo $this->Html->css(array('styles/modal.css?v=1'), array('css')); ?>
<script>
  function openModal(idProducto,nombre)
  {
      $.modal({
          title: nombre,
          content: '<div id="idmodal"></div>',
          center: true,
          width: 450,
          height: 450,
      });
      $('#idmodal').load('<?php echo $this->Html->url(array('action' => 'ajax_img_prod')); ?>/'+idProducto);
  }
  filtro_c = [
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"}
  ];
  var productos = [];
  var v_total = 0.00;
  function add_venta(id_producto, nombre_producto, precio) {
      $('#spancantprod').load('<?php echo $this->Html->url(array('action' => 'ajax_cantidad_prod')); ?>/' + id_producto);
      if (productos[id_producto] != null) {
          productos[id_producto]['cantidad']++;
          $('#idrcant-' + id_producto).html(productos[id_producto]['cantidad']);
          v_total = v_total + precio;
          $('#idinpprod-' + id_producto).val(productos[id_producto]['cantidad']);
      } else {
          v_total = v_total + precio;
          productos[id_producto] = [];
          productos[id_producto]['nombre'] = nombre_producto;
          productos[id_producto]['cantidad'] = 1;
          nueva_fila = ''
                  + '<tr id="idrow-' + id_producto + '">'
                  + '  <td id="idrprod-' + id_producto + '">' + nombre_producto + '</td>'
                  + '  <td><span class="tag green-bg" id="idrcant-' + id_producto + '">1</span></td>'
                  + '  <td id="idrprec-' + id_producto + '">' + precio + '</td>'
                  + '  <td><a href="javascript:" class="tag red-bg" onclick="quita_venta(' + id_producto + ',' + precio + ');">Quitar</a></td>'
                  + '</tr>';
          $('#sorting-example2 > tbody:last').append(nueva_fila);
          formulario = '<input type="hidden" name="data[productos][' + id_producto + '][cantidad]" value="1" id="idinpprod-' + id_producto + '">'
                  + '<input type="hidden" name="data[productos][' + id_producto + '][precio]" value="' + precio + '" id="idinpreprod-' + id_producto + '">';
          $('#idformventa').append(formulario);
      }
      $('#idcanttotal').html(v_total);
  }
  function quita_venta(id_producto, precio) {
      productos[id_producto]['cantidad']--;
      if (productos[id_producto]['cantidad'] == 0) {
          v_total = v_total - precio;
          $('#idrow-' + id_producto).remove();
          productos[id_producto] = null;
      } else {
          v_total = v_total - precio;
          $('#idrcant-' + id_producto).html(productos[id_producto]['cantidad']);
      }
      $('#idinpprod-' + id_producto).val(productos[id_producto]['cantidad']);
      $('#idcanttotal').html(v_total);
  }
</script>
<?php
echo $this->Html->script(array('developr.tabs'), array('block' => 'js_add'));
?>