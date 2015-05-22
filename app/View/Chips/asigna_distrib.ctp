<div id="main" class="contenedor">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>LISTADO DE SIM'S SIN ASIGNAR</h1>
    </hgroup>
    <div class="with-padding">
        <?php echo $this->Form->create('Chip', array('action' => 'registra_asignado')); ?>
        <div class="columns">
            <div class="new-row four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Distribuidor</label>
                    <?php echo $this->Form->select('Dato.distribuidor_id', $distribuidores, array('class' => 'full-width select')); ?>
                </p>
            </div>
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Rang. Inicial</label>
                    <?php echo $this->Form->text('Dato.rango_ini', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Cantidad</label>
                    <?php echo $this->Form->text('Dato.cantidad', array('class' => 'full-width input')); ?>
                </p>
            </div>
            <div class="two-columns-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">&nbsp;</label>
                    <button class="button green-gradient full-width" type="submit">REGISTRAR</button>
                </p>
            </div>
        </div>
        <br>
        <?php echo $this->Form->end(); ?>
        <table class="table responsive-table" id="tabla-json">

            <thead>
                <tr>                      

                    <th style="width: 10%;">Id</th>
                    <th style="width: 10%;">Cant.</th>
                    <th style="width: 20%;">SIM</th>
                    <th style="width: 15%;">IMSI</th>
                    <th style="width: 15%;">Telefono</th>
                    <th style="width: 10%;">Fecha</th>
                    <th style="width: 20%;">Excel</th>
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
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu -->