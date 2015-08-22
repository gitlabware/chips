<section role="main" id="main">

    <div class="with-padding">
        <h3>
            Fomulario de registro de control de recargas solicitadas desde viva
        </h3>
        <?php
        echo $this->Form->create('Almacenes', array('action' => 'registrarecarga', 'class' => 'columns', 'id' => 'formID'));
        echo $this->Form->hidden('Movimientosrecarga.user_id', array('value' => $this->Session->read('Auth.User.id')));
        echo $this->Form->hidden('Movimientosrecarga.fecha', array('value' => date('Y-m-d')));
        ?>

        <div class="six-columns six-columns-tablet twelve-columns-mobile">
            <h3 class="thin underline">
                Registre la recarga del dia
            </h3>
            <fieldset class="fieldset">
                <p class="button-height inline-label">
                    <label for="input-text" class="label">
                        Monto recarga
                    </label>
                    <?php echo $this->Form->text('Movimientosrecarga.solicita', array('required')) ?>
                </p>
                <p class="button-height inline-label">
                    <label for="input-text" class="label">
                        Monto con ganancia de viva
                    </label>
                    <?php echo $this->Form->text('Movimientosrecarga.ingreso', array('required')) ?>
                </p>
            </fieldset>
           
        </div>
         <div class="field-block button-height">
                        <button type="submit" class="button glossy mid-margin-right">
                            <span class="button-icon"><span class="icon-tick"></span></span>
                            Guardar
                        </button>

                        <button type="submit" class="button glossy">
                            <span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>
                            Cancelar
                        </button>
                        &nbsp;
                        <button type="button" class="button glossy mid-margin-right" id="btMuestraFAsignaciones" onclick="openIframe()"> 
                            <span class="button-icon"><span class="icon-search"></span></span>
                            Ver Recarga 
                        </button>
                    </div>
    </div>
</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 
<script>
    $(document).ready(function() {
        $("#formID").validationEngine();
    });

// Demo Iframe loading
    function openIframe()
    {
        $.modal({
            title: 'Saldo recarga',
            url: '<?php echo $this->Html->url(array('action' => 'estadorecargas')) ?>',
            useIframe: true,
            width: 400,
            height: 200
        });
    }
</script>