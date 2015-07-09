<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Nuevo Cliente</h1>
    </hgroup>
    <div class="with-padding"> 
        <?php echo $this->Form->create('Cliente', array('id' => 'formID')) ?>
        <div class="columns">
            <?php if($this->Session->read('Auth.User.Group.name') == 'Administradores'):?>
            <div class="new-row six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Codigo 149 <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('num_registro', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <?php endif;?>
            <div class="new-row six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre <small>(requerido)</small></label>                    
                    <?php echo $this->Form->text('nombre', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="six-columns new-row-mobile twelve-columns">                
                <p class="block-label button-height">
                    <label for="block-label-2" class="label">Direccion<small>(requerido)</small></label>
                    <?php echo $this->Form->text('direccion', array('class' => 'input full-width')); ?>
                </p>  
            </div>

            <div class="three-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Celular<small>(requerido)</small></label>
                    <?php echo $this->Form->text('celular', array('class' => 'input full-width')); ?>
                </p>
            </div>

            <div class="three-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Zona<small>(requerido)</small></label>
                    <?php echo $this->Form->text('zona', array('class' => 'input full-width')); ?>                       
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Mercado<small>(requerido)</small></label>
                    <?php echo $this->Form->text('mercado', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Ruta<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('ruta_id', $rutas, array('class' => 'select', 'style' => 'width: 222px', 'required')); ?>
                </p>
            </div>

            <div class="new six-columns new-row-mobile twelve-columns">

                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Inspector<small>(requerido)</small></label>
                    <?php echo $this->Form->text('inspector', array('class' => 'input full-width')) ?>

                </p>
            </div>

            

            <div class="three-columns new-row-mobile twelve-columns">
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Lugar<small>(Requerido)</small></label>
                    <select id="validation-select" name="data[cliente][lugare_id]" class="select" style="width: 222px">
                        <?php foreach ($lugares as $lug): ?>
                            <option value="<?php echo $lug['Lugare']['id'] ?>">
                                <?php echo $lug['Lugare']['nombre'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </p>
            </div>
            
            <div class="three-columns new-row-mobile twelve-columns">
                <?php echo $this->Form->text('lat', ['id' => 'frmlat']); ?>
                                <?php echo $this->Form->text('lng', ['id' => 'frmlng']); ?>
                <div id="mapa" style="width: 100%; height: 400px;"></div>
            </div>

            <div class="six-columns new-row-mobile twelve-columns">

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

<script>
    $(document).ready(function () {
        $("#formID").validationEngine();
    });
</script>
<script type="text/javascript">
  var map;

  function initialize() {
      var mapOptions = {
          zoom: 14,
          center: new google.maps.LatLng(-16.49, -68.12),
          mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

      var pos = new google.maps.LatLng(-16.49, -68.12);

      var marker = new google.maps.Marker({
          position: pos,
          map: map,
          title: "Arrastrar para mover",
          animation: google.maps.Animation.BOUNCE,
          draggable: true
      });

      function funcionArrastra() {
          var lat = marker.getPosition().lat();
          var lng = marker.getPosition().lng();
          //console.log(lat + '-' + lng);
          $('#frmlat').val(lat);
          $('#frmlng').val(lng);
      }

      google.maps.event.addListener(marker, 'drag', funcionArrastra);
      marker.setIcon('https://dl.dropboxusercontent.com/u/20056281/Iconos/male-2.png');
  }
  google.maps.event.addDomListener(window, 'load', initialize);

</script>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Distribuidores'): ?>
    <!-- Sidebar/drop-down menu -->
    <?php echo $this->element('sidebar/distribuidor'); ?>
    <!-- End sidebar/drop-down menu --> 
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
    <?php echo $this->element('sidebar/administrador'); ?>
<?php endif; ?>
