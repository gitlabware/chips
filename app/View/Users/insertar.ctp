
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Insertar Nuevo Usuario</h1>
    </hgroup>
    <div class="with-padding"> 
        <?php echo $this->Form->create('User' ,array('id'=>'formID')); ?>

        <form method="post" action="" class="columns" onsubmit="return false" name="formulario">                               
            <!--<div class="new-row-desktop four-columns six-columns-tablet twelve-columns-mobile">-->
            <div class="new-row twelve-columns">                
                <h3 class="thin underline">&nbsp;</h3>                                          

                <fieldset class="fieldset fields-list">

                    <legend class="legend">Formulario Registro de Usuario </legend>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Nombre :</b></label>
                        <?php echo $this->Form->text('Persona.nombre', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Apellido Paterno :</b></label>
                        <?php echo $this->Form->text('Persona.ap_paterno', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Apellido Materno :</b></label>
                        <?php echo $this->Form->text('Persona.ap_materno'); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Ci :</b></label>
                        <?php echo $this->Form->text('Persona.ci', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Direccion :</b></label>
                        <?php echo $this->Form->text('Persona.direccion', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Telefono :</b></label>
                        <?php echo $this->Form->text('Persona.telefono'); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Celular :</b></label>
                        <?php echo $this->Form->text('Persona.celular', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Usuario :</b></label>
                        <?php echo $this->Form->text('username', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>
                    <div class="field-block button-height">							
                        <label for="login" class="label"><b>Ingrese su Password :</b></label>
                        <?php echo $this->Form->password('password', array('class' => 'span12', 'required')); ?>
                        <!--<input type="text" name="login" id="login" value="" class="input">-->
                    </div>

                    <div class="field-block button-height">
                        <label for="validation-select1" class="label"><b>Tipo de Usuario :</b></label>
                        <select id="validation-select1" name="data[User][group_id]" class="select expandable-list anthracite-gradient glossy validate[required]" style="width: 200px" >

                            <option value="">
                                Seleccione el tipo de Usuario
                            </option>
                            <?php foreach ($groups as $g): ?>
                                <option value="<?php echo $g['Group']['id'] ?>">
                                    <?php echo $g['Group']['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    									
                    <div id="mostrartienda" style="display: none">
                        <div class="field-block button-height">
                            <label for="validation-select" class="label"><b>Tienda en la que trabaja:</b></label>
                            <select id="validation-select12" name="data[User][sucursal_id]" class="select"  style="width: 200px"  >
                                <option value="" >
                                    Seleccione la tienda
                                </option>
                                <?php foreach ($tiendas as $g): ?>
                                    <option value="<?php echo $g['Sucursal']['id'] ?>">
                                        <?php echo $g['Sucursal']['nombre'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            
                        </div>
                    </div>
                    
                    <div id="mostrarruta" style="display: none">
                        <div class="field-block button-height">
                            <label for="validation-select" class="label"><b>Ruta:</b></label>
                            <?php echo $this->Form->select('ruta_id', $rutas, array('class' => 'select', 'required')); ?>
                        </div>
                    </div>
                    
                    </fieldset>
                    <div class="field-block button-height">
                        
                        <button type="submit" class="button glossy mid-margin-right" onClick="javascript:verificar()">
                            <span class="button-icon"><span class="icon-tick"></span></span>
                            Guardar Usuario
                        </button>

                        <button type="submit" class="button glossy">
                            <span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>
                            Cancelar
                        </button>

                    </div>

                
            </div>

        </form>

    </div>

</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 
<script>
$(document).ready(function(){
       $("#validation-select1").change(function(){
           if(this.value == 5){
            $('#mostrartienda').show();
           }else{
            $('#mostrartienda').hide();
           }
           alert(this.value);
           if(this.value == 2){
               
            $('#mostrarruta').show();
           }
       });
   });
</script>
<script>
$(document).ready(function(){
       $("#validation-select1").change(function(){
           if(this.value == 2){
               
            $('#mostrarruta').show();
           }else{
            $('#mostrarruta').hide();
           }
       });
   });
</script>
<script>
    $(document).ready(function() {

        $("#formID").validationEngine();

        
    });
</script>
