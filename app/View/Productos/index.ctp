<style>

</style>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Productos</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="tabla-json">

            <thead>
                <tr>
                    <th scope="col" width="4%">Precios</th>
                    <th scope="col" width="5%">Imagen</th>
                    <th scope="col" width="10%">Categoria</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Nombre</th>
                    <th scope="col" width="5%" class="align-center hide-on-mobile">Precio compra</th>
                    <th scope="col" width="10%" class="align-center hide-on-mobile-portrait">proveedor</th>  
                    <th scope="col" width="8%" class="align-center hide-on-mobile-portrait">Fecha Ingreso</th>  
                    <th scope="col" width="15%" class="align-center">Acciones</th>
                </tr>
            </thead>          

            <tbody>

            </tbody>
        </table>     <br>    
        <div class="columns">
            <div class="twelve-columns">
                <?php echo $this->Form->create('Producto', array('action' => 'registra_excel_pro', 'id' => 'formActi', 'enctype' => 'multipart/form-data')); ?>
                <div class="field-block button-height">							
                    <label for="login" class="label"><b>Seleccionar Excel:</b></label>
                    <span class="input file">
                        <span class="file-text"></span>
                        <span class="button compact blue-gradient">Seleccione</span>
                        <input type="file" name="data[Excel][excel]" id="special-input-1" value="" class="file withClearFunctions" required="" />
                    </span>
                    <button type="submit" class="button blue-gradient glossy">SUBIR EXCEL</button> 
                    <button type="button" class="button glossy mid-margin-right" onclick="openModal2();">
                        <span class="button-icon"><span class="icon-search"></span></span>
                        Ver Formato Productos
                    </button>
                    <a href="<?= $this->webroot; ?>formatos/productos.xlsx" class="button"><span class="button-icon"><span class="icon-download"></span></span> Formato</a>
                </div> 
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="new-row twelve-columns">
                <?php echo $this->Form->create('Producto', array('action' => 'registra_excel_cel', 'id' => 'formActicel', 'enctype' => 'multipart/form-data')); ?>
                <div class="field-block button-height">							
                    <label for="login" class="label"><b>Seleccionar Excel:</b></label>
                    <span class="input file">
                        <span class="file-text"></span>
                        <span class="button compact green-gradient">Seleccione</span>
                        <input type="file" name="data[Excel][excel]" id="special-input-1" value="" class="file withClearFunctions" required="" />
                    </span>
                    <button type="submit" class="button green-gradient glossy">SUBIR EXCEL</button> 
                    <button type="button" class="button glossy mid-margin-right" onclick="openModal3();">
                        <span class="button-icon green-gradient"><span class="icon-search"></span></span>
                        Ver Formato Celulares
                    </button>
                    <a href="<?= $this->webroot; ?>formatos/celulares.xlsx" class="button"><span class="button-icon green-gradient"><span class="icon-download"></span></span> Formato</a>
                </div> 
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section>
<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => 'index.json')); ?>';

  filtro_c = [
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"}
  ];

  $(document).ready(function () {
      $("#formID").validationEngine();
  });
  function precios_productos(idproducto)
  {
      /*$.modal({
       title: 'Iframe content',
       url: '<?php echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'ajax_precios')); ?>/' + idproducto,
       useIframe: true,
       width: 600,
       height: 400
       });*/



      $.modal({
          content: '<div id="idmodal"></div>',
          title: 'PRECIOS DEL PRODUCTO',
          width: 600,
          height: 400,
          actions: {
              'Close': {
                  color: 'red',
                  click: function (win) {
                      win.closeModal();
                  }
              }
          },
          buttonsLowPadding: true
      });
      $('#idmodal').load('<?php echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'ajax_precios')); ?>/' + idproducto);
  }

</script>

<?php if ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <!-- Sidebar/drop-down menu -->
  <?php echo $this->element('sidebar/almacenero'); ?>
  <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
<!-- End sidebar/drop-down menu --> 
<script>
  function mensaje_nota(titulo, texto) {
      notify(titulo, texto, {
          system: true,
          vPos: 'top',
          hPos: 'right',
          autoClose: true,
          icon: false ? 'img/demo/icon.png' : '',
          iconOutside: true,
          closeButton: true,
          showCloseOnHover: true,
          groupSimilar: true
      });
  }
  function editar_p(idproducto) {
      window.location = '<?php echo $this->Html->url(array('action' => 'editar')); ?>/' + idproducto;
  }
  function elimina_p(idproducto) {
      if (confirm('Esta seguro de eliminar el producto??')) {
          window.location = '<?php echo $this->Html->url(array('action' => 'delete')); ?>/' + idproducto;
      }
  }
  function openModal2()
  {
      //console.log('hizo click');
      $.modal({
          title: 'Formato del Archivo',
          content: '<?php echo $this->Html->image('iconos/productos.png'); ?>',
          center: true,
          width: 1000,
          height: 450,
      });
  }
  function openModal3()
  {
      //console.log('hizo click');
      $.modal({
          title: 'Formato del Archivo',
          content: '<?php echo $this->Html->image('iconos/excelCelulares.png'); ?>',
          center: true,
          width: 570,
          height: 160,
      });
  }
</script>