
<div id="main" class="contenedor">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>LISTADO DE SIM'S SIN ASIGNAR</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Chip', array('action' => 'registra_asignado', 'id' => 'formID')); ?>
        <div class="columns">
            <div class="new-row four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Distribuidor/Impulsador</label>
                    <?php echo $this->Form->select('Dato.distribuidor_id', $distribuidores, array('class' => 'input validate[required] full-width select')); ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Rang. Inicial</label>
                    <?php echo $this->Form->text('Dato.rango_ini', array('class' => 'input validate[required] full-width input clase-form', 'id' => 'rinicio' )); ?>
                </p>
            </div>            
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Rang. Final</label>
                    <?php echo $this->Form->text('Dato.rango_fin', array('onkeyup' => 'calcula()', 'class' => 'full-width input clase-form', 'id' => 'rfin', 'value' => 0)); ?>
                </p>
            </div>            
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Cantidad</label>
                    <?php echo $this->Form->text('Dato.cantidad', array('class' => 'input validate[required] full-width input clase-form', 'id' => 'rtotal')); ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Cantidad</label>
                    <?php echo $this->Form->date('Dato.fecha_entrega_d', array('class' => 'input validate[required] full-width input clase-form','value' => date('Y-m-d'))); ?>
                </p>
            </div>
            <div class="new-row twelve-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">REGISTRAR</button>
                </p>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
        <div class="columns">
            <div class="new-row twelve-columns" id="div-numeros" style="font-weight: bold; color: green;">
        
            </div>
        </div>

        <table class="table responsive-table" id="tabla-json">

            <thead>
                <tr>                      
                    <th style="width: 10%;">Id</th>
                    <th style="width: 10%;">Cant.</th>
                    <th style="width: 20%;">SIM</th>
                    <th style="width: 15%;">IMSI</th>
                    <th style="width: 15%;">Telefono</th>
                    <th style="width: 10%;">Fecha</th>
                    <th style="width: 12%;">Factura</th>
                    <th style="width: 8%;">Caja</th>
                </tr>
            </thead>          

            <tbody>

            </tbody>
        </table> 
    </div>
</div>
<script>
  //urljsontabla = '<?php echo $this->Html->url(array('action' => 'asigna_distrib.json')); ?>';
</script>
<!-- Sidebar/drop-down menu -->
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
<script>
  function calcula() {
      console.log('digito');
      var total = 0;
      var inicio = $('#rinicio').val();
      var fin = $('#rfin').val();
      var res = fin - inicio;
      //console.log(res);
      $('#rtotal').val(Math.abs(res + 1));
  }
  filtro_c = [
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"},
      {type: "text"}
  ];
</script>
<script>
  $(document).ready(function () {

      $("#formID").validationEngine();


  });
  $('.clase-form').keyup(function () {
      var postData = $('#formID').serializeArray();
      var formURL = '<?php echo $this->Html->url(array('action' => 'rango_nuemros'));?>';
      $.ajax(
              {
                  url: formURL,
                  type: "POST",
                  data: postData,
                  beforeSend:function (XMLHttpRequest) {
                   $("#div-numeros").html("<span class='loader big working'></span>");
                   },
                   /*complete:function (XMLHttpRequest, textStatus) {
                   alert('despues de enviar');
                   },*/
                  success: function (data, textStatus, jqXHR)
                  {
                      //data: return data from server
                      $("#div-numeros").html(data);
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      //if fails   
                      alert("error");
                  }
              });
  });


</script>
<!-- End sidebar/drop-down menu -->