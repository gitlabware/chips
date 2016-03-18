<?php
$meses = array(
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Sepetiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Disciembre'
);
?>
<script>
    var idExcel_c = 0;
</script>
<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Comisiones</h1>
    </hgroup>
    <div class="with-padding">
        <div id="muestraFormAsignaciones">
            <?php echo $this->Form->create('Comisione', array('action' => 'guardaexcel', 'id' => 'formAsig', 'enctype' => 'multipart/form-data')); ?>
            <!--        <form method="post" action="" class="columns" onsubmit="return false">                               -->
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <!--                <h3 class="thin underline">&nbsp;</h3>                                          -->
                <fieldset class="fieldset">

                    <div class="columns">
                        <div class="four-columns">
                            <p class="button-height">
                                <span class="input file full-width">
                                    <span class="file-text"></span>
                                    <span class="button compact black-gradient">Seleccione</span>
                                    <input type="file" name="data[Excel][excel]" id="special-input-1" class="file withClearFunctions" required />
                                </span>
                            </p>
                        </div>
                        <div class="four-columns">
                            <p class="block-label button-height">
                                <?php echo $this->Form->year('Dato.gestion', date('Y') - 2, date('Y') + 2, array('class' => 'select full-width', 'value' => date('Y'), 'required', 'empty' => 'Seleccione la gestion'));
                                ?>
                            </p>
                        </div>
                        <div class="four-columns">
                            <p class="block-label button-height">
                                <?php echo $this->Form->select('Dato.mes', $meses, array('class' => 'select full-width', 'required', 'value' => date('m'), 'empty' => 'Seleccione mes')); ?>
                            </p>
                        </div>
                    </div>


                    <div class="field-block button-height">
                        <button type="submit" id="btAsig" class="button glossy mid-margin-right">
                            <span class="button-icon black-gradient"><span class="icon-save"></span></span>
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
                    content: '<?php echo $this->Html->image('iconos/formato_activados.png'); ?>',
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
                    <th scope="col" class="align-center">Gestion</th>
                    <th scope="col" class="align-center">Fecha</th>
                    <th scope="col" class="align-center">Nombre</th>
                    <th scope="col" class="align-center">Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($excels as $e): ?>
                    <?php
                    $gestion = unserialize($e['Excel']['detalles']);
                    ?>
                    <?php if ($e['Excel']['total_registros'] > 0 && $e['Excel']['total_registros'] > $e['Excel']['puntero']): ?>
                    <script>
                        idExcel_c = <?php echo $e['Excel']['id']; ?>;
                    </script>
                <?php endif; ?>
                <tr>                
                    <td><?php echo $meses[(int) $gestion['mes']] . '-' . $gestion['gestion']; ?></td>                        
                    <td><?php echo $e['Excel']['created']; ?></td>                        
                    <td><?php echo $e['Excel']['nombre_original']; ?></td>
                    <td>
                        <?php echo $this->Html->link('Ver',array('action' => 'vercomisiones',$e['Excel']['id'])); ?>
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
echo $this->Html->script(array('developr.progress-slider', 'inicargaexcel2'), array('block' => 'js_add'))
?>
<script>


    function carga_reg_com(idExcel)
    {
        var timeout;
        $.modal({
            contentAlign: 'center',
            width: 240,
            title: 'Loading',
            content: '<div style="line-height: 25px; padding: 0 0 10px"><span id="modal-status">Iniciando Carga de registros...</span><br><span id="modal-progress">0%</span></div>',
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

                            var formURL = '<?php echo $this->Html->url(array('action' => 'registra_reg_com')); ?>/' + idExcel;
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
                                                        status.text('Creando registros de comisiones...');
                                                        progress.changeProgressBarColor('blue-gradient');
                                                    } else {
                                                        status.text('Creando registro (' + n_chip + '/' + total_c + ')...');
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


    function eliminar_act(idExcel, total_reg1)
    {
        var timeout;

        $.modal({
            contentAlign: 'center',
            width: 240,
            title: 'Loading',
            content: '<div style="line-height: 25px; padding: 0 0 10px"><span id="modal-status">Iniciando Eliminacion...</span><br><span id="modal-progress">0%</span></div>',
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

                            var formURL = '<?php echo $this->Html->url(array('action' => 'eliminar_ac')); ?>/' + idExcel;
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
                                            //var total_c = $.parseJSON(data).total;

                                            if (total_reg1 != 0) {
                                                var n_chip = total_reg1 - numero_chip;
                                                //alert(n_chip + ' ---- ' + total_c);
                                                loaded = parseInt((n_chip / total_reg1) * 100);
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
                                                        status.text('Eliminando registros de activacion...');
                                                        progress.changeProgressBarColor('blue-gradient');
                                                    } else {
                                                        status.text('Eliminando registro (' + n_chip + '/' + total_reg1 + ')...');
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
</script>