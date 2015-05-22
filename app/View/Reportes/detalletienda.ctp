<!-- glDatePicker -->
<?php echo $this->Html->css(array('developr.css?v=1')) ?>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Reportes Ventas Tienda (Detalle)</h1>
    </hgroup>
    <div class="with-padding">  
        <?php echo $this->Form->create(null, array('url' => array('controller' => 'Reportes', 'action' => 'detalletienda'))) ?>

        <div class="six-columns twelve-columns-tablet">

            <h3 class="thin underline">Formulario de Reporte</h3>

            <fieldset class="fieldset fields-list">

                <legend class="legend">Tiendas/Fecha</legend>

                <div class="field-block button-height">
                    <label for="validation-select" class="label"><b>Sucursal</b></label>
                    <?php echo $this->Form->select('Tienda.sucursal_id',$sucursales,array('class' =>'select','required'));?>
                    	
                </div>

                <div class="field-block button-height">
                    <label for="file" class="label"><b>Fecha</b></label>
                    <span class="input">
                        <span class="icon-calendar"></span>
                        <input type="text" name="data[Tienda][fecha]" id="mydate" class="input-unstyled datepicker" value="" required>
                    </span>                  
                </div>
                
                <div class="field-block button-height">

                    <button type="submit" class="button glossy mid-margin-right">
                        <span class="button-icon"><span class="icon-tick"></span></span>
                        Enviar
                    </button>

                </div>
        </div>
    </div>

</form>

</div>

</section>
<?php if($this->Session->read('Auth.User.Group.name')=='Almaceneros'):?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 
<?php elseif($this->Session->read('Auth.User.Group.name')=='Administradores'):?>
<?php echo $this->element('sidebar/administrador'); ?>
<?php endif;?>
<?php //echo $this->Html->script(array('libs/glDatePicker/glDatePicker.min.js?v=1')) ?>
<?php echo $this->Html->script(array('libs/glDatePicker/glDatePicker.js')) ?>

<script>
    // Call template init (optional, but faster if called manually)
    $.template.init();
    // Date picker
    $('#mydate').glDatePicker({
        zIndex: 100,
        selectableYears: true,
        selectableMonths: true, 
        allowMonthSelect: false,
        allowYearSelect: false
    });
    $('#mydate2').glDatePicker({
        zIndex: 100,
        selectableYears: true,
        selectableMonths: true, 
        allowMonthSelect: false,
        allowYearSelect: false
    });
    // Form validation
    //$('form').validationEngine();
</script>
