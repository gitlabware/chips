
<div id="main" class="contenedor">
    <hgroup id="main-title" class="thin">
        <h1>TODOS LOS CHIPS</h1>
    </hgroup>
    <div class="with-padding">
        <table class="table responsive-table" id="tabla-json">
            <thead>
                <tr>                      
                    <th>Id</th>
                    <th>Cant.</th>
                    <th>Telefono</th>
                    <th>Factura</th>
                    <th>Caja</th>
                    <th>Fecha</th>
                    <th>SIM</th>
                    <th>IMSI</th>
                    <th>Ver</th>
                </tr>
            </thead>          

            <tbody>

            </tbody>
        </table> 
    </div>
</div>
<script>
  urljsontabla = '<?php echo $this->Html->url(array('action' => 'todos.json')); ?>';
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
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

  datos_tabla2 = {
      "oLanguage": {
          "oPaginate": {
              "sPrevious": "Anterior",
              "sNext": "Siguiente",
              "sFirst": "Primero",
              "sLast": "Ultimo"
          },
          "sSearch": "Buscar",
          "sLengthMenu": "Mostrar _MENU_ registros",
          "sInfo": "Tiene un total de _TOTAL_ registros para mostrar (_START_ to _END_)"
      },
      'sPaginationType': 'full_numbers',
      'sDom': '<"dataTables_header"lfr>t<"dataTables_footer"ip>',
      'bProcessing': true,
      'sAjaxSource': urljsontabla,
      'sServerMethod': 'POST',
      "order": [],
      'fnInitComplete': function (oSettings)
      {
          // Style length select
          table2.closest('.dataTables_wrapper').find('.dataTables_length select').addClass('select blue-gradient glossy').styleSelect();
          tableStyled = true;
      }
  };
  
  function infochip(idchip){
    cargarmodal('<?php echo $this->Html->url(array('action' => 'info_chip'));?>/'+idchip,'Informacion del Chip');
  }
</script>

<!-- End sidebar/drop-down menu -->