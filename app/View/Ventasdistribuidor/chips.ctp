<div id="main" class="contenedor">


    <div class="with-padding">
        <details class="details margin-bottom" >
            <summary><b><?php echo strtoupper($cliente['Cliente']['nombre']); ?></b></summary>
            <div class="with-padding">
                <p><?php echo $cliente['Cliente']['direccion'] ?></p>
                <?php $entregados = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_chips_cli_v_ent', $cliente['Cliente']['id'])); ?>
                <p><?php echo '<span class="tag">' . $entregados . '</span> chips entregados en el mes.'; ?></p>
                <?php $vendidos = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_chips_cli_v_ven', $cliente['Cliente']['id'])); ?>
                <p><?php echo '<span class="tag">'.$vendidos.'</span>  chips vendidos en el mes'; ?></p>
                <p><?php echo '<span class="tag">'.($entregados-$vendidos).'</span>  chips restantes'; ?></p>
            </div>
        </details>
        <?php echo $this->Form->create(NULL, array('url' => array('controller' => 'Ventasdistribuidor', 'action' => 'registra_asignado'))); ?>
        <?php echo $this->Form->hidden('Dato.cliente_id', array('value' => $idCliente)); ?>

        <h4 class="green underline">Sim's Disponibles Asignacion</h4>

        <div class="columns">
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Rang. Inicial</label>
                    <?php echo $this->Form->text('Dato.rango_ini', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Cantidad</label>
                    <?php echo $this->Form->text('Dato.cantidad', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">ASIGNAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <table class="table responsive-table" id="tabla-json">
            <thead>
                <tr>                      
                    <th style="width: 10%;">Id</th>
                    <th style="width: 10%;" class="hide-on-mobile">Cant.</th>
                    <th style="width: 20%;" class="hide-on-mobile">SIM</th>
                    <th style="width: 15%;" class="hide-on-mobile">IMSI</th>
                    <th style="width: 15%;">Telefono</th>
                    <th style="width: 10%;" class="hide-on-mobile">Fecha</th>
                </tr>
            </thead>          

            <tbody>

            </tbody>
        </table> 
    </div>
</div>
<script>
    urljsontabla = '<?php echo $this->Html->url(array('action' => 'chips.json')); ?>';
    datos_tabla2 = {};
    datos_tabla2 = {
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
        }, "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $('td:eq(1)', nRow).addClass('hide-on-mobile');
            $('td:eq(2)', nRow).addClass('hide-on-mobile');
            $('td:eq(3)', nRow).addClass('hide-on-mobile');
            $('td:eq(5)', nRow).addClass('hide-on-mobile');
        }
    };
</script>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 