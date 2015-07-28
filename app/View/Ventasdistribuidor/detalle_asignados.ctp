<section role="main" id="main">

    <hgroup id="main-title" class="thin">
        <h1>Detalle de chips de <?php echo $fecha; ?></h1>
    </hgroup>
    <div class="with-padding"> 
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Sim</th>
                    <th>Imsi</th>
                    <th>Telefono</th>
                    <th>Factura</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($entregados as $ent): ?>
                  <tr>
                      <td><?php echo $ent['Chip']['id'] ?></td>
                      <td><?php echo $ent['Chip']['cantidad'] ?></td>
                      <td><?php echo $ent['Chip']['tipo_sim'] ?></td>
                      <td><?php echo $ent['Chip']['sim'] ?></td>
                      <td><?php echo $ent['Chip']['imsi'] ?></td>
                      <td><?php echo $ent['Chip']['telefono'] ?></td>
                      <td><?php echo $ent['Chip']['factura'] ?></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 

