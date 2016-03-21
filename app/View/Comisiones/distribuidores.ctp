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
        <h1>Comisiones de <?php echo $meses[(int) $gestion['mes']] . ' - ' . $gestion['gestion']; ?></h1>
    </hgroup>
    <div class="with-padding">
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th scope="col" class="align-center">Distribuidor</th>
                    <th scope="col" class="align-center">Acciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($distribuidores as $di): ?>
                <tr>
                    <td><?php echo $di['User']['nombre_completo']; ?></td>
                    <td>
                        <?php echo $this->Html->link('<span class="icon-down-fat"></span>', array('action' => 'genera_excel_1', $excel['Excel']['id'],$di['User']['id']), array('class' => 'button blue-gradient glossy', 'escape' => false, 'title' => 'Descargar Excel Comisiones')) ?>
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