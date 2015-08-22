<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Reportes Ventas Distribuidor</h1>
    </hgroup>
    <div class="with-padding">   
      <?php echo $this->Form->create(null, array('url'=>array('controller'=>'Reporventasdis', 'action'=>'nombredist')))?>
        <form method="post" action="" class="columns" onsubmit="return false">                               
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <h3 class="thin underline">&nbsp;</h3>                                          

                <fieldset class="fieldset fields-list">

                    <legend class="legend">Selecione un distribuidor para hacer el Reporte</legend>
<div class="field-block button-height">
                   <label for="validation-select" class="label"><b>Distribuidor</b></label>
                        <select id="validation-select1" name="data[Persona][id]" class="select" style="width: 200px">
					
                            <option value="">
						Seleccione un Distribuidor
					</option>
					<?php foreach($personas as $g): ?>
                    <option value="<?php echo $g['Persona']['id'] ?>">
                    <?php echo $g['Persona']['nombre'].' '.$g['Persona']['ap_paterno']?>
                    </option>
                    <?php endforeach; ?>
				</select>								
</div>
                    <div class="field-block button-height">

                        <button type="submit" class="button glossy mid-margin-right">
                            <span class="button-icon"><span class="icon-tick"></span></span>
                            mosmtrar reporte
                        </button>

                        </div>

                </fieldset>
            </div>

        </form>

    </div>

</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 