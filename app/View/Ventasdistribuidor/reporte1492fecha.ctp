<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>REPORTE POR FECHA</h1>
    </hgroup>
    <div class="with-padding"> 
    <?php echo $this->Form->create('Ventasdistribuidor'); ?>

        <form method="post" action="" class="columns" onsubmit="return false">                               
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <h3 class="thin underline">&nbsp;</h3>                                          

                <fieldset class="fieldset fields-list">


                    <div class="field-block button-height">	 						
                        <label for="login" class="label"><b>Ingrese la fecha:</b></label>
                        <?php echo $this->Form->date('fecha', array('required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>								

                    <div class="field-block button-height">

                        <button type="submit" class="button glossy mid-margin-right">
                            <span class="button-icon"><span class="icon-tick"></span></span>
                            Generar Reporte
                        </button>

                        <?php echo $this->Html->link('ATRAS',array('action'=>'pidecodigo'),array('class'=>'button glossy mid-margin-right'));?>

                    </div>

                </fieldset>
            </div>

        </form>

    </div>

</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 