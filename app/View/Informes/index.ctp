<!-- glDatePicker -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<section role="main" id="main">

    <hgroup id="main-title" class="thin">
        <h1>Formularios de informes</h1>
    </hgroup>

    <div class="with-padding">                   
        <div class="columns">
            <div class="twelve-columns">
                <?php echo $this->Form->create('Informe', array('action' => 'hoja_ruteo_d')); ?>
                <fieldset class="fieldset">
                    <legend class="legend">HOJA DE RUTEO CONSOLIDADO DISTRIBUIDORES</legend>
                    <div class="columns">
                        <div class="six-columns">
                            <p class="block-label button-height inline-label">
                                <label for="input-1" class="label">Fecha Inicial</label>
                                <span class="input">
                                    <span class="icon-calendar"></span>
                                    <input type="text" name="data[Aux][fecha_ini]" class="input-unstyled datepicker" value="">
                                </span>
                            </p>
                        </div>
                        <div class="six-columns">
                            <p class="block-label button-height inline-label">
                                <label for="input-1" class="label">Fecha Final</label>
                                <span class="input">
                                    <span class="icon-calendar"></span>
                                    <input type="text" name="data[Aux][fecha_fin]" class="input-unstyled datepicker" value="">
                                </span>
                            </p>
                        </div>
                        <div class="new-row twelve-columns">
                            <p class="inline-label">
                                <?php echo $this->Form->submit("GENERAR", array('class' => 'button anthracite-gradient glossy full-width')); ?>
                            </p>
                        </div>
                    </div>
                </fieldset>
                <?php echo $this->Form->end(); ?>
                <br>
                <?php echo $this->Form->create('Informe', array('action' => 'ruteo_diario')); ?>
                <fieldset class="fieldset">
                    <legend class="legend">HOJA DE RUTEO DIARIO DISTRIBUIDORES</legend>
                    <div class="columns">
                        <div class="six-columns">
                            <p class="block-label button-height inline-label">
                                <label for="input-1" class="label">Distribuidor</label>
                                <?= $this->Form->select('Dato.user_id', $distribuidores, ['class' => 'select full-width']); ?>
                            </p>
                        </div>
                        <div class="new-row twelve-columns">
                            <p class="inline-label">
                                <?php echo $this->Form->submit("GENERAR", array('class' => 'button anthracite-gradient glossy full-width')); ?>
                            </p>
                        </div>
                    </div>
                </fieldset>
                <?php echo $this->Form->end(); ?>
                <br>
                <?php echo $this->Form->create('Informe', array('action' => 'excel_ruteo_diario')); ?>
                <fieldset class="fieldset">
                    <legend class="legend">HOJA DE RUTEO DIARIO DISTRIBUIDORES NUEVO</legend>
                    <div class="columns">
                        <div class="six-columns">
                            <p class="block-label button-height inline-label">
                                <label for="input-1" class="label">Distribuidor</label>
                                <?= $this->Form->select('Dato.user_id', $distribuidores, ['class' => 'select full-width', 'id' => 'idfdist']); ?>
                            </p>
                        </div>
                        <div class="six-columns">
                            <p class="block-label button-height inline-label" id="cod_mercado">
                                <label for="input-1" class="label">Mercado</label>
                                <?= $this->Form->select('Dato.mercado', array(), ['class' => 'select full-width']); ?>
                            </p>
                        </div>
                        <div class="new-row twelve-columns">
                            <p class="inline-label">
                                <?php echo $this->Form->submit("GENERAR", array('class' => 'button anthracite-gradient glossy full-width')); ?>
                            </p>
                        </div>
                    </div>
                </fieldset>
                <?php echo $this->Form->end(); ?>
                <br>
                <?php echo $this->Form->create('Informe', array('action' => 'excel_rutas_semana')); ?>
                <fieldset class="fieldset">
                    <legend class="legend">CONTROL DE RUTAS Y FRECUENCIAS</legend>
                    <div class="columns">
                        <div class="six-columns">
                            <p class="block-label button-height inline-label">
                                <label for="input-1" class="label">Lugar</label>
                                <?= $this->Form->select('Dato.lugare_id', $lugares, ['class' => 'select full-width']); ?>
                            </p>
                        </div>
                        <div class="new-row twelve-columns">
                            <p class="inline-label">
                                <?php echo $this->Form->submit("GENERAR", array('class' => 'button anthracite-gradient glossy full-width')); ?>
                            </p>
                        </div>
                    </div>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section>	
<?php echo $this->element('sidebar/administrador'); ?>
<?php
echo $this->Html->script(array(
  'libs/glDatePicker/glDatePicker.min.js?v=1',
  'ini_lg_datepicker.js'
  ), array('block' => 'js_add'));
?>

<script>
  $('#idfdist').change(function () {
      $('#cod_mercado').load('<?php echo $this->Html->url(array('action' => 'ajax_mercado')); ?>/'+$(this).val());
  });
</script>