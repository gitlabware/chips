<!-- glDatePicker -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Clientes de <?php echo $user['Persona']['nombre'] . ' ' . $user['Persona']['ap_paterno'] . ' ' . $user['Persona']['ap_materno']." en fecha ".$venta['Ventasdistribuidore']['fecha']; ?></h1>
    </hgroup>

    <div class="with-padding">       

        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <td>CODIGO</td>
                    <td>NOMBRE</td>
                    <td>MERCADO</td>
                    <td>ACCION</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cli): ?>
                  <tr>
                      <td><?php echo $cli['Cliente']['cod_dealer'] ?></td>
                      <td><?php echo $cli['Cliente']['nombre'] ?></td>
                      <td><?php echo $cli['Cliente']['mercado'] ?></td>
                      <td>
                          <button class="button green-gradient glossy" onclick="cargarmodal('<?php echo $this->Html->url(array('action' => 'venta',$idVenta,$cli['Cliente']['id'])); ?>')">VENTA</button>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</section>	

<!-- Sidebar/drop-down menu -->

<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

<!-- End sidebar/drop-down menu --> 

<script>

  filtro_c = [
      {type: "text"},
      {type: "text"},
      {type: "text"}
  ];
</script>