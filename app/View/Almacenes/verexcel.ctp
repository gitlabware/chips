
<div id="main" class="contenedor">
    <hgroup id="main-title" class="thin">
        <h1>Listado de distribucion (<?php echo $excel['Excel']['nombre_original']; ?>)</h1>
    </hgroup>
    <div class="with-padding">
        <table class="table responsive-table">
            <thead>
                <tr>                      
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Tienda</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($distribuciones as $dis): ?>
                  <?php
                  $estilo = '';
                  if ($dis['Distribucione']['estado'] == 'No Correcto') {
                    $estilo = 'style="background-color: #FFDACC;"';
                  }
                  ?>
                  <tr <?php echo $estilo; ?>>
                      <td><?php echo $dis['Distribucione']['id']; ?></td>
                      <td><?php echo $dis['Distribucione']['nombre_producto']; ?></td>
                      <td><?php echo $dis['Distribucione']['nombre_tienda']; ?></td>
                      <td><?php echo $dis['Distribucione']['cantidad']; ?></td>
                      <td><?php echo $dis['Distribucione']['estado']; ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    </div>
</div>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>