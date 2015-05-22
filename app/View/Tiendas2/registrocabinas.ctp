<section role="main" id="main">

    <div class="with-padding">
        <h3>
            Fomulario de deposito 
        </h3>
        <?php
        echo $this->Form->create('Tienda', array('action' => 'registrocabinas', 'class' => 'columns', 'id' => 'formID'));
        echo $this->Form->hidden('Movimientoscabina.user_id', array('value' => $this->Session->read('Auth.User.id')));
        echo $this->Form->hidden('Movimientoscabina.sucursal_id', array('value' => $this->Session->read('Auth.User.sucursal_id')));
        ?>

        <div class="six-columns six-columns-tablet twelve-columns-mobile">
            <h3 class="thin underline">
                Ingresar datos de registro
            </h3>
            <fieldset class="fieldset">

                <legend class="legend">
                    Cabina
                </legend>
                <p class="button-height">
                    <label for="input-text" class="label">
                        Seleccione la cabina
                    </label>
                    
                    <select class="select auto-open blue-gradient" name="data[Movimientoscabina][cabina_id]">
                        <option value="">...</option>
                        <?php foreach ($cabinas as $c):?>
                        
                        <option value="<?php echo $c['Cabina']['id']?>"><?php echo $c['Cabina']['nombre']?></option>
                        
                        <?php endforeach;?>
                        
                    </select>
                </p>
                <p>
                    <label for="input-text" class="label">
                        Seleccione el registro
                    </label>
                    <input type="radio" name="data[Movimientoscabina][tipo]" id="radio-1" value="1" class="radio mid-margin-left"> <label for="radio-1" class="label">Recarga</label>
                    <input type="radio" name="data[Movimientoscabina][tipo]" id="radio-2" value="0" class="radio mid-margin-left"> <label for="radio-1" class="label">Cierre</label>
                </p>
                <div style="display: none" id ="combo1">
                    <p class="button-height">
                    <label for="input-text" class="label">
                        Seleccione con que cargo
                    </label>
                    
                        <select class="select auto-open blue-gradient" name="data[Movimientoscabina][producto_id]">
                        <option value="">...</option>
                        <?php foreach ($tarjetas as $c):?>
                        
                        <option value="<?php echo $c['Producto']['id']?>"><?php echo $c['Producto']['nombre']?></option>
                        
                        <?php endforeach;?>
                        
                    </select>
                </p>
                    <p class="button-height inline-label">
                        <label for="input-text" class="label">
                            Cuantas tarjetas fueron usadas
                        </label>
                        <?php echo $this->Form->text('Movimientoscabina.cantidad', array('class' => 'input')) ?>
                    </p>    
                </div>
                <div style="display: none" id="combo2">
                    <p class="button-height inline-label">
                        <label for="input-text" class="label">
                            Sobrante actual
                        </label>
                        <?php echo $this->Form->text('Movimientoscabina.saldo', array('class' => 'input')) ?>

                    </p>    
                </div>
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
        $("#radio-1").change(function() {
            console.log('click en recarga');
            $("#combo2").hide('slow');
            $("#combo1").toggle('slow');
        });
        $("#radio-2").change(function() {
            console.log('click en cierre');
            $("#combo1").hide('slow');
            $("#combo2").toggle('slow');
        });
    });
</script>