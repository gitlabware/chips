<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <?php echo '<h1>Entrega a Tienda ' . $this->Session->read('Auth.User.Sucursal.nombre') . '</h1>'; ?>
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
            <div class="eight-columns">
                <table class="table responsive-table verde" id="tabla-json">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <th>Color</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>          
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="four-columns">
                <?php //debug($idAlmacen);exit;?>
                <?php echo $this->Form->create('Tienda', array('action' => 'registra_venta_celu/'.$idAlmacen, 'id' => 'idformventa')); ?>
                <p class="block-label button-height">
                    <label class="label">Cliente</label>
                    <?php echo $this->Form->text('cliente', array('class' => 'input full-width', 'placeholder' => 'Ingrese el nombre del cliente', 'required')); ?>
                </p>
                <p class="block-label button-height">
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
                </p>
                <p class="block-label button-height">
                    <button class="button blue-gradient full-width">REGISTRAR</button>
                </p>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

    </div>
</section>	
<?php echo $this->Html->script(array('developr.modal'), array('block' => 'js_add')) ?>
<?php echo $this->Html->css(array('styles/modal.css?v=1'), array('css')); ?>
<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => "lista_celulares.json")); ?>';

  filtro_c = [
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"}
  ];
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
  var productos = [];
  var v_total = 0.00;
  function add_venta(id_producto, nombre_producto, precio) {
      //$('#spancantprod').load('<?php //echo $this->Html->url(array('action' => 'ajax_cantidad_prod'));   ?>/' + id_producto);
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
          $('#idinpprod-' + id_producto).remove();
          $('#idinpreprod-' + id_producto).remove();
      } else {
          v_total = v_total - precio;
          $('#idrcant-' + id_producto).html(productos[id_producto]['cantidad']);
          $('#idinpprod-' + id_producto).val(productos[id_producto]['cantidad']);
      }
      
      $('#idcanttotal').html(v_total);
  }
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 

