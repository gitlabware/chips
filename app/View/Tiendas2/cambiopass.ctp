<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Editar Usuario</h1>
    </hgroup>
    <div class="with-padding"> 
    <?php echo $this->Form->create('User'); ?>

        <form method="post" action="" class="columns" onsubmit="return false">                               
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <h3 class="thin underline">&nbsp;</h3>                                          

                <fieldset class="fieldset fields-list">

                    <legend class="legend">Formulario Registro de Usuario </legend>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Nuevo Password :</b></label>
                        <?php echo $this->Form->password('password', array('placeholder'=>'Inserte Nuevo Password','class' => 'span12', 'required', 'value'=>'')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>								

                    <div class="field-block button-height">

                        <button type="submit" class="button glossy mid-margin-right">
                            <span class="button-icon"><span class="icon-tick"></span></span>
                            Cambiar Password
                        </button>

                        <?php echo $this->Html->link('ATRAS',array('action'=>'index'),array('class'=>'button glossy mid-margin-right'));?>

                    </div>

                </fieldset>
            </div>

        </form>

    </div>

</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 