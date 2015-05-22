<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Ingresar Datos de Deposito</h1>
    </hgroup>

    <div class="with-padding"> 
        <?php
        echo $this->Form->create('Almacenes', array('action' => 'deposito', 'id' => 'formID'));
        echo $this->Form->hidden('Deposito.user_id', array('value' => $this->Session->read('Auth.User.id')));
        echo $this->Form->hidden('Deposito.persona_id', array('value' => $this->Session->read('Auth.User.persona_id')));
        ?>
        <div class="columns">
            <?php if ($this->Session->read('Auth.User.Group.name') == 'Administradores'):?>
            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label"> Quien entrega <small>(requerido)</small></label>
                    <select id="validation-select1" name="data[Deposito][persona_id]" class="select" style="width: 200px">
                        <option value="">
                            Seleccione el distribuidor...
                        </option>
                        <?php foreach ($distribuidores as $d): ?>
                            <option value="<?php echo $d['User']['persona_id'] ?>">
                                <?php echo $d['Persona']['nombre'] . ' ' . $d['Persona']['ap_paterno'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>
            
            <?php endif; ?>
            <div class="new-row three-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Banco<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('Deposito.banco_id', $bancos, array('class' => 'select', 'required')); ?>
                </p>
            </div>

            <div class="three-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Deposito<small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('Deposito.banco', array('value' => '0.0', 'class' => 'input validate[custom[number]]')) ?>
                </p>
            </div>


            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Monto en Efectivo<small>(Requerido)</small></label>
                    <?php echo $this->Form->text('Deposito.efectivo', array('value' => '0.0', 'class' => 'validate[custom[number]] input')) ?>
                </p>
            </div>

            <div class="threee-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Comprobante<small>(requerido)</small></label>
                    <?php echo $this->Form->text('Deposito.comprobante', array('class' => 'input')) ?>
                </p>
            </div>

            <div class="new-row six-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Recibo <small>(Requerido)</small></label>
                    <?php echo $this->Form->text('Deposito.recibo', array('class' => 'input full-width')) ?>
                </p>
            </div>

            <div class="new-row six-columns">

                <button type="submit" class="button glossy mid-margin-right" onClick="javascript:verificar()">
                    <span class="button-icon"><span class="icon-tick"></span></span>
                    Guardar
                </button>

                <button type="submit" class="button glossy">
                    <span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>
                    Cancelar
                </button>

            </div>
        </div>

    </div>
</section>
<?php if ($this->Session->read('Auth.User.Group.name')=='Distribuidores'):?>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 
<?php elseif($this->Session->read('Auth.User.Group.name')=='Administradores'):?>
<?php echo $this->element('sidebar/administrador'); ?>
<?php endif;?>       
<script>
    $(document).ready(function () {
        $("#formID").validationEngine();
    });
</script>