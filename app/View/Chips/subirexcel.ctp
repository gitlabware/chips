<script>
  var idExcel_c = 0;
</script>
<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Registro de Chips</h1>
    </hgroup>
    <div class="with-padding">        
        <a href="javascript:void(0)" class="button orange-gradient glossy" id="btMuestraFormAsignaciones">SUBIR EXCEL ASIGNACIONES</a>
        <a href="javascript:void(0)" class="button green-gradient glossy" id="btMuestraFormActivaciones">SUBIR EXCEL ACTIVACIONES</a>
        <p>&nbsp;</p>
        <div id="muestraFormAsignaciones">
            <?php echo $this->Form->create('Chips', array('action' => 'guardaexcel', 'id' => 'formAsig', 'enctype' => 'multipart/form-data')); ?>
            <!--        <form method="post" action="" class="columns" onsubmit="return false">                               -->
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <!--                <h3 class="thin underline">&nbsp;</h3>                                          -->
                <fieldset class="fieldset fields-list">
                    <legend class="legend orange-gradient">Formulario Subida Excel Asignaciones</legend>
                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Seleccionar Excel :</b></label>
                        <?php //echo $this->Form->text('Persona.nombre', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                        <span class="input file">
                            <span class="file-text"></span>
                            <span class="button compact orange-gradient">Seleccione</span>
                            <input type="file" name="data[Excel][excel]" id="special-input-1" class="file withClearFunctions" required />
                        </span>
                    </div>                                                                 

                    <div class="field-block button-height">
                        <button type="submit" id="btAsig" class="button glossy mid-margin-right">
                            <span class="button-icon orange-gradient"><span class="icon-save"></span></span>
                            Guardar Excel
                        </button>
                        &nbsp;
                        <button type="button" class="button glossy mid-margin-right" id="btMuestraFAsignaciones" onclick="openModal()"> 
                            <span class="button-icon"><span class="icon-search"></span></span>
                            Ver Formato
                        </button>
                        <a href="<?= $this->webroot; ?>formatos/primero.xlsx" class="button"><span class="button-icon"><span class="icon-download"></span></span> Formato</a>
                    </div>                                        
                </fieldset>
            </div>
            </form>
        </div>

        <script>
          $("#formAsig").on("submit", function (e) {

              $("#btAsig").replaceWith("<span class='loader big working'></span> Trabajando ;)");
          });

          function openModal()
          {
              //console.log('hizo click');
              $.modal({
                  content: '<div id="idmodal"></div>',
                  title: 'Formato del Archivo',
                  content: '<?php echo $this->Html->image('iconos/asignados.png'); ?>',
                          center: true,
                  width: 850,
                  height: 450,
              });
          }
          ;

        </script>

        <div id="muestraFormActivaciones" style="display: none;">
            <?php echo $this->Form->create('Chips', array('action' => 'guardaexcelactivados', 'id' => 'formActi', 'enctype' => 'multipart/form-data')); ?>
            <!--        <form method="post" action="" class="columns" onsubmit="return false">                               -->
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <!--                <h3 class="thin underline">&nbsp;</h3>                                          -->
                <fieldset class="fieldset fields-list">
                    <legend class="legend green-gradient">Formulario Subida Excel Activaciones</legend>
                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Seleccionar Excel :</b></label>
                        <?php //echo $this->Form->text('Persona.nombre', array('class' => 'span12', 'required'));   ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                        <span class="input file">
                            <span class="file-text"></span>
                            <span class="button compact green-gradient">Seleccione</span>
                            <input type="file" name="data[Excel][excel]" id="special-input-1" value="" class="file withClearFunctions" required="" />
                        </span>
                    </div>                                                                 

                    <div class="field-block button-height">
                        <button type="submit" id="btActi" class="button glossy mid-margin-right">
                            <span class="button-icon green-gradient"><span class="icon-save"></span></span>
                            Guardar Excel
                        </button>

                        <button type="button" class="button glossy mid-margin-right" onclick="openModal2();">
                            <span class="button-icon"><span class="icon-search"></span></span>
                            Ver Formato
                        </button>
                        <a href="<?= $this->webroot; ?>formatos/tercero.xlsx" class="button"><span class="button-icon"><span class="icon-download"></span></span> Formato</a>
                    </div>                                       

                </fieldset>
            </div>
            </form>
        </div>

        <script>
          $("#formActi").on("submit", function (e) {

              $("#btActi").replaceWith("<span class='loader big working'></span> Trabajando ;)");
          });

          $(document).ready(function () {
              $("#btMuestraFormAsignaciones").click(function () {
                  $("#muestraFormAsignaciones").show('slow');
                  $("#muestraFormActivaciones").hide('slow');
              });

              $("#btMuestraFormActivaciones").click(function () {
                  $("#muestraFormActivaciones").show('slow');
                  $("#muestraFormAsignaciones").hide('slow');
              });
          });

          function openModal2()
          {
              //console.log('hizo click');
              $.modal({
                  title: 'Formato del Archivo',
                  content: '<?php echo $this->Html->image('iconos/activados.png'); ?>',
                  center: true,
                  width: 1190,
                  height: 450,
              });
          }
          ;
        </script>
        <p>&nbsp;</p>
        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr> 
                    <th scope="col" class="align-center hide-on-mobile">ID</th>
                    <th scope="col" class="align-center hide-on-mobile">Nombre</th>
                    <th scope="col" class="align-center hide-on-mobile">Fecha</th>
                    <th scope="col" class="align-center hide-on-mobile-portrait">Tipo</th>     
                    <th scope="col" class="align-center hide-on-mobile-portrait">Estado</th>     
                    <th scope="col" class="align-center hide-on-mobile-portrait">Acciones</th> 
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($excels as $e): ?>
                  <?php if ($e['Excel']['total_registros'] > 0 && $e['Excel']['total_registros'] > $e['Excel']['puntero']): ?>
                <script>
                  idExcel_c = <?php echo $e['Excel']['id']; ?>;
                </script>
              <?php endif; ?>
              <tr>                      
                  <td><?php echo $e['Excel']['id']; ?></td>                        
                  <td><?php echo $e['Excel']['nombre_original']; ?></td>                        
                  <td><?php echo $e['Excel']['created']; ?></td>
                  <td><?php echo $e['Excel']['tipo']; ?></td>       
                  <td>
                      <?php if ($e['Excel']['tipo'] == 'asignacion'): ?>
                        <?php echo $this->requestAction(array('action' => 'get_estado_chips_exc', $e['Excel']['id'])); ?>
                      <?php endif; ?>
                  </td>   
                  <td>
                      <?php if ($e['Excel']['tipo'] == 'asignacion'): ?>
                        <?php echo $this->Html->link("Detalle", array('action' => 'verexcel', $e['Excel']['id']), array('class' => 'button blue-gradient glossy')) ?>
                        <?php echo $this->Html->link("Asignados", array('action' => 'excel_asignados', $e['Excel']['id']), array('class' => 'button black-gradient glossy')) ?>
                        <a title="Descargar Excel" href="<?php echo $this->Html->url(array('action' => 'genera_excel_3', $e['Excel']['id'])); ?>" class="button green-gradient glossy">
                            <span class="icon-download"></span>
                        </a>
                        <?php echo $this->Html->link('<span class="icon-trash"></span>', array('action' => 'eliminar_as', $e['Excel']['id']), array('class' => 'button red-gradient glossy', 'confirm' => 'Esta seguro de eliminar el excel??', 'escape' => false, 'title' => 'Eliminar Excel Chips')) ?>
                      <?php elseif ($e['Excel']['tipo'] == 'activacion'): ?>
                        <button type="button" class="button blue-gradient glossy" title="Regularizar Chips Activados" onclick="regularizar_chips(<?php echo $e['Excel']['id']; ?>)"><span class="icon-cycle"></span></button>
                        <a title="Descargar Excel" href="<?php echo $this->Html->url(array('action' => 'genera_excel_3', $e['Excel']['id'])); ?>" class="button green-gradient glossy">
                            <span class="icon-download"></span>
                        </a>
                        <?php echo $this->Html->link('<span class="icon-trash"></span>', array('action' => 'eliminar_ac', $e['Excel']['id']), array('class' => 'button orange-gradient glossy', 'confirm' => 'Esta seguro de eliminar el excel??', 'title' => 'Eliminar Excel Activacion', 'escape' => FALSE)) ?>
                        <?php echo $this->Html->link('<span class="icon-trash"></span>', array('action' => 'eliminar_as', $e['Excel']['id']), array('class' => 'button red-gradient glossy', 'confirm' => 'Esta seguro de eliminar el excel??', 'escape' => false, 'title' => 'Eliminar Excel Chips')) ?>
                      <?php endif; ?>
                  </td>                       
              </tr>  

            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu -->
<?php
echo $this->Html->css(array('styles/progress-slider.css?v=1'), array('block' => 'css'));
echo $this->Html->script(array('developr.progress-slider', 'inicargaexcel'), array('block' => 'js_add'))
?>
<script>

  function envia_sol_reg(idExcel) {
      //var postData = $('#form_precio').serializeArray();
      var formURL = '<?php echo $this->Html->url(array('action' => 'regulariza_chips_act')); ?>/' + idExcel;
      var numero_chip = 0;
      $.ajax(
              {
                  url: formURL,
                  type: "POST",
                  //data: postData,
                  /*beforeSend:function (XMLHttpRequest) {
                   alert("antes de enviar");
                   },
                   complete:function (XMLHttpRequest, textStatus) {
                   alert('despues de enviar');
                   },*/
                  success: function (data, textStatus, jqXHR)
                  {
                      handleData($.parseJSON(data).numero);
                      //alert(numero_chip);

                      //$('#idmodal').load('<?php //echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'ajax_precios', $idProducto));               ?>');
                      //data: return data from server
                      //$("#parte").html(data);
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      //if fails   
                      alert("error");
                  }
              });
      //alert(numero_chip);
      //return numero_chip;
  }



  function carga_reg_chips(idExcel)
  {
      var timeout;

      $.modal({
          contentAlign: 'center',
          width: 240,
          title: 'Loading',
          content: '<div style="line-height: 25px; padding: 0 0 10px"><span id="modal-status">Iniciando regularizacion...</span><br><span id="modal-progress">0%</span></div>',
          buttons: {},
          scrolling: false,
          actions: {
              'Cancel': {
                  color: 'red',
                  click: function (win) {
                      win.closeModal();
                  }
              }
          },
          onOpen: function ()
          {
              // Progress bar
              var progress = $('#modal-progress').progress(100, {
                  size: 200,
                  style: 'large',
                  barClasses: ['anthracite-gradient', 'glossy'],
                  stripes: true,
                  darkStripes: false,
                  showValue: false
              }),
                      // Loading state
                      loaded = 0,
                      // Window
                      win = $(this),
                      // Status text
                      status = $('#modal-status'),
                      // Function to simulate loading

                      //total_c = envia_sol_reg(idExcel),
                      simulateLoading = function ()
                      {

                          var formURL = '<?php echo $this->Html->url(array('action' => 'registra_reg_chips')); ?>/' + idExcel;
                          var numero_chip = 0;
                          $.ajax(
                                  {
                                      url: formURL,
                                      type: "POST",
                                      //data: postData,
                                      /*beforeSend:function (XMLHttpRequest) {
                                       alert("antes de enviar");
                                       },
                                       complete:function (XMLHttpRequest, textStatus) {
                                       alert('despues de enviar');
                                       },*/
                                      success: function (data, textStatus, jqXHR)
                                      {
                                        //alert('ssss');
                                          var numero_chip = $.parseJSON(data).numero;
                                          var total_c = $.parseJSON(data).total;
                                          //alert(numero_chip + ' ---- ' + total_c);
                                          if (total_c != 0) {
                                              var n_chip = numero_chip;
                                              
                                              loaded = parseInt((n_chip / total_c) * 100);
                                              //++loaded;
                                              //alert(loaded);
                                              progress.setProgressValue(loaded + '%', true);
                                              if (loaded === 100)
                                              {
                                                  progress.hideProgressStripes().changeProgressBarColor('green-gradient');
                                                  status.text('Listo!');
                                                  /*win.getModalContentBlock().message('Content loaded!', {
                                                   classes: ['green-gradient', 'align-center'],
                                                   arrow: 'bottom'
                                                   });*/
                                                  setTimeout(function () {
                                                      win.closeModal();
                                                      window.location.href = window.location.pathname;
                                                  }, 1500);
                                              }
                                              else
                                              {
                                                  if (n_chip === 1) {
                                                      status.text('Creando registros de chip...');
                                                      progress.changeProgressBarColor('blue-gradient');
                                                  } else {
                                                      status.text('Creado registro (' + n_chip + '/' + total_c + ')...');
                                                  }

                                                  timeout = setTimeout(simulateLoading, 10);
                                              }
                                          } else {
                                              progress.hideProgressStripes().changeProgressBarColor('green-gradient');
                                              status.text('Listo!');
                                              /*win.getModalContentBlock().message('Content loaded!', {
                                               classes: ['green-gradient', 'align-center'],
                                               arrow: 'bottom'
                                               });*/
                                              setTimeout(function () {
                                                  win.closeModal();
                                              }, 1500);
                                          }
                                      },
                                      error: function (jqXHR, textStatus, errorThrown)
                                      {
                                          //if fails   
                                          alert("error");
                                      }
                                  });



                      };

              // Start
              timeout = setTimeout(simulateLoading, 400);
          },
          onClose: function ()
          {
              // Stop simulated loading if needed
              clearTimeout(timeout);
          }
      });
  }


  function regularizar_chips(idExcel)
  {
      var timeout;

      $.modal({
          contentAlign: 'center',
          width: 240,
          title: 'Loading',
          content: '<div style="line-height: 25px; padding: 0 0 10px"><span id="modal-status">Iniciando regularizacion...</span><br><span id="modal-progress">0%</span></div>',
          buttons: {},
          scrolling: false,
          actions: {
              'Cancel': {
                  color: 'red',
                  click: function (win) {
                      win.closeModal();
                  }
              }
          },
          onOpen: function ()
          {
              // Progress bar
              var progress = $('#modal-progress').progress(100, {
                  size: 200,
                  style: 'large',
                  barClasses: ['anthracite-gradient', 'glossy'],
                  stripes: true,
                  darkStripes: false,
                  showValue: false
              }),
                      // Loading state
                      loaded = 0,
                      // Window
                      win = $(this),
                      // Status text
                      status = $('#modal-status'),
                      // Function to simulate loading

                      //total_c = envia_sol_reg(idExcel),
                      simulateLoading = function ()
                      {

                          var formURL = '<?php echo $this->Html->url(array('action' => 'regulariza_chips_act')); ?>/' + idExcel;
                          var numero_chip = 0;
                          $.ajax(
                                  {
                                      url: formURL,
                                      type: "POST",
                                      //data: postData,
                                      /*beforeSend:function (XMLHttpRequest) {
                                       alert("antes de enviar");
                                       },
                                       complete:function (XMLHttpRequest, textStatus) {
                                       alert('despues de enviar');
                                       },*/
                                      success: function (data, textStatus, jqXHR)
                                      {

                                          var numero_chip = $.parseJSON(data).numero;
                                          var total_c = $.parseJSON(data).total;

                                          if (total_c != 0) {
                                              var n_chip = total_c - numero_chip;
                                              //alert(n_chip + ' ---- ' + total_c);
                                              loaded = parseInt((n_chip / total_c) * 100);
                                              //++loaded;
                                              //alert(loaded);
                                              progress.setProgressValue(loaded + '%', true);
                                              if (loaded === 100)
                                              {
                                                  progress.hideProgressStripes().changeProgressBarColor('green-gradient');
                                                  status.text('Listo!');
                                                  /*win.getModalContentBlock().message('Content loaded!', {
                                                   classes: ['green-gradient', 'align-center'],
                                                   arrow: 'bottom'
                                                   });*/

                                                  setTimeout(function () {
                                                      win.closeModal();
                                                      
                                                  }, 1500);
                                              }
                                              else
                                              {
                                                  if (n_chip === 1) {
                                                      status.text('Creando registros de chip...');
                                                      progress.changeProgressBarColor('blue-gradient');
                                                  } else {
                                                      status.text('Creado registro (' + n_chip + '/' + total_c + ')...');
                                                  }

                                                  timeout = setTimeout(simulateLoading, 200);
                                              }
                                          } else {
                                              progress.hideProgressStripes().changeProgressBarColor('green-gradient');
                                              status.text('Listo!');
                                              /*win.getModalContentBlock().message('Content loaded!', {
                                               classes: ['green-gradient', 'align-center'],
                                               arrow: 'bottom'
                                               });*/
                                              setTimeout(function () {
                                                  win.closeModal();
                                                  
                                              }, 1500);
                                          }
                                      },
                                      error: function (jqXHR, textStatus, errorThrown)
                                      {
                                          //if fails   
                                          alert("error");
                                      }
                                  });



                      };

              // Start
              timeout = setTimeout(simulateLoading, 4000);
          },
          onClose: function ()
          {
              // Stop simulated loading if needed
              clearTimeout(timeout);
          }
      });
  }
  ;
</script>