<section role="main" id="main">
    
    <div class="with-padding">
<h3>
    Fomulario de deposito 
</h3>
<?php 
echo $this->Form->create('Tienda', array('action' => 'registrardeposito', 'class' => 'columns', 'id' => 'formID'));
echo $this->Form->hidden('Deposito.user_id', array('value'=>$this->Session->read('Auth.User.id')));
echo $this->Form->hidden('Deposito.sucursal_id', array('value'=>$this->Session->read('Auth.User.sucursal_id')));
?>

<div class="six-columns six-columns-tablet twelve-columns-mobile">
    <h3 class="thin underline">
        Ingresar datos de registro
    </h3>
    <fieldset class="fieldset">
        
        <legend class="legend">
            Deposito
        </legend>
       
        <p class="button-height inline-label">
            <label for="input-text" class="label">
               Monto banco
            </label>
            <?php echo $this->Form->text('Deposito.banco', array('value'=>'0.0', 'class' => 'input validate[custom[number]]')) ?>
            
        </p>
        <p class="button-height inline-label">
            <label for="input-text" class="label">
               Nombre banco
            </label>
            <?php echo $this->Form->text('Deposito.nombrebanco', array('class'=>'input')) ?>
            
        </p>
        <p class="button-height inline-label">
            <label for="input-text" class="label">
               # de cuenta
            </label>
            <?php echo $this->Form->text('Deposito.cuenta', array('class'=>'input')) ?>
            
        </p>
        <p class="button-height inline-label">
            <label for="input-text" class="label">
                Comprobante deposito
            </label>
            <?php echo $this->Form->text('Deposito.comprobante', array('class' => 'input')) ?>
        </p>
        
       <p class="button-height inline-label">
            <label for="input-text" class="label">
                Monto en efectivo
            </label>
            <?php echo $this->Form->text('Deposito.efectivo', array('value'=>'0.0','class' => 'validate[custom[number]] input')) ?>
        </p>
        <p class="button-height inline-label">
            <label for="input-text" class="label">
                Recibo
            </label>
            <?php echo $this->Form->text('Deposito.recibo', array('class' => 'input')) ?>
        </p>

    </fieldset>
    <div class="button-height">
        <button class="button blue-gradient" type="submit">Registrar</button>
    </div>
</div>
        </div>
</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/tienda'); ?>
<!-- End sidebar/drop-down menu --> 
<script>
    $(document).ready(function() {
        $("#formID").validationEngine();
    });
</script>