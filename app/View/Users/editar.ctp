

<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Editar Usuario</h1>
    </hgroup>
    <?php echo $this->Form->create('User', array('id' => 'formID')); ?>
    <?php echo $this->form->hidden('Persona.id'); ?>
    <div class="with-padding"> 
        <div class="columns">
            <div class="new-row four-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('Persona.nombre', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="four-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Apellido Paterno <small>(requerido)</small></label>
                    <?php echo $this->Form->text('Persona.ap_paterno', array('class' => 'input full-width')); ?>
                </p>  
            </div>
            <div class="four-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Apellido Materno <small>(requerido)</small></label>
                    <?php echo $this->Form->text('Persona.ap_materno', array('class' => 'input full-width')); ?>
                </p>  
            </div>

            <div class="new-row two-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">C.I. <small>(requerido)</small></label>
                    <?php echo $this->Form->text('Persona.ci', array('class' => 'input full-width')); ?>
                </p>
            </div>

            <div class="six-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Direccion <small>(requerido)</small></label>
                    <?php echo $this->Form->text('Persona.direccion', array('class' => 'input full-width')); ?>                       
                </p>
            </div>

            <div class="two-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Telefono <small>(requerido)</small></label>
                    <?php echo $this->Form->text('Persona.telefono', array('class' => 'input full-width')) ?>

                </p>
            </div>

            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Celular <small>(requerido)</small></label>
                    <?php echo $this->Form->text('Persona.celular', array('class' => 'input full-width')); ?>
                </p>
            </div>

            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="validate-selec" class="label">Lugar<small>(Requerido)</small></label>

                    <?php echo $this->Form->select("User.lugare_id", $lugares, array('class' => 'select validate[required]')) ?>
                </p>
            </div>

            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Usuario <small>(requerido)</small></label>
                    <?php
                    //debug($this->request->data); 
                    $username = $this->request->data['User']['0']['username'];
                    $grupo = $this->request->data['User']['0']['group_id'];
                    //debug($grupo);
                    ?>
                    <?php echo $this->Form->text('User.username', array('class' => 'input full-width', 'value' => "$username")); ?>
                </p>
            </div>

            <div class="three-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Password <small>(requerido)</small></label>
                    <?php echo $this->Form->password('User.password2', array('class' => 'input full-width', 'placeholder' => 'Si desea cambiarlo')) ?>
                </p>
            </div>
            <div class="two-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Tipo <small>(requerido)</small></label>
                    <?php echo $this->Form->select("User.group_id", $groups, array('class' => 'select validate[required]', 'id' => 'validation-select1')) ?>
                </p>  
            </div>
            <div class="two-columns">
                <p class="block-label button-height" id="mostrartienda" style="display: none">
                    <label for="validation-select" class="label"><b>Tienda de trabajo:</b></label>
                    <?php echo $this->Form->select("User.sucursal_id", $tiendas, array('class' => 'select', 'id' => 'validation-select1')); ?>
                </p>
            </div>
            <div class=" new-row two-columns">
                <p class="block-label button-height" id="mostrarruta" style="<?php
                if ($grupo != 2) {
                  echo 'display: none';
                }
                ?>">
                    <label for="validation-select" class="label"><b>Ruta:</b></label>
                    <?php echo $this->Form->select('ruta_id', $rutas, array('class' => 'select', 'value' => $idPersona['User']['ruta_id'])); ?>
                </p>
            </div>
            <div class="new-row six-columns">

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
    </div>
</section>

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 
<script>
  $(document).ready(function () {

      $("#validation-select1").change(function () {
          if (this.value == 5) {
              $('#mostrartienda').show();
          } else {
              $('#mostrartienda').hide();
          }
      });

  });

  if (<?php echo $this->request->data['User']['group_id'] ?> == 5) {
      $('#mostrartienda').show();
  } else {
      $('#mostrartienda').hide();
  }
</script>
<script>
  $(document).ready(function () {
      $("#validation-select1").change(function () {
          if (this.value == 2) {
              $('#mostrarruta').show();
          } else {
              $('#mostrarruta').hide();
          }
      });
  });
  if (<?php echo $this->request->data['User']['group_id'] ?> == 2) {
      $('#mostrarruta').show();
  } else {
      $('#mostrarruta').hide();
  }
</script>
<script>
  $(document).ready(function () {
      $("#formID").validationEngine();
  });
</script>
