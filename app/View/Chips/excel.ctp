<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Entregas a <?php echo $distribuidor['Persona']['nombre'] . ' ' . $distribuidor['Persona']['ap_paterno'] . ' ' . $distribuidor['Persona']['ap_materno'] ?> de <?php echo $fecha; ?></h1>
    </hgroup>
    <div class="with-padding">
        <div class="columns">
            <div class="three-columns">
                <a href="<?php echo $this->Html->url(array('action' => 'genera_excel_1', $fecha_entrega, $idDistribuidor));?>" class="button full-width">
                    <span class="button-icon"><span class="icon-download"></span></span>
                    Sin asignaciones
                </a>
            </div>
            <div class="three-columns">
                <a href="<?php echo $this->Html->url(array('action' => 'genera_excel_2', $fecha_entrega, $idDistribuidor));?>" class="button full-width">
                    <span class="button-icon green-gradient"><span class="icon-download"></span></span>
                    Solo Asignados
                </a>
            </div>
        </div>
        <table class="table responsive-table">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Sim</th>
                    <th>Telefono</th>
                    <th>Fecha</th>
                    <th>Fecha de entrega</th>
                    <th>Codigo</th>
                    <th>Subdealer</th>
                    <th>Cod.Merc</th>
                    <th>Distribuidor</th>
                    <th>Ciudad</th>
                    <th>Firma</th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($chips as $ch): ?>
                  <tr>
                      <td><?php echo $ch['Chip']['cantidad']; ?></td>
                      <td><?php echo $ch['Chip']['sim']; ?></td>
                      <td><?php echo $ch['Chip']['telefono']; ?></td>
                      <td><?php echo $ch[0]['fecha_f']; ?></td>
                      <td><?php echo $ch[0]['fecha_entrega_d_f']; ?></td>
                      <td><?php echo $ch['Cliente']['cod_dealer']; ?></td>
                      <td><?php echo $ch['Cliente']['nombre']; ?></td>
                      <td><?php echo $ch['Cliente']['cod_mercado']; ?></td>
                      <td><?php echo $ch['Chip']['nom_distribuidor']; ?></td>
                      <td><?php echo $ch['Chip']['ciudad_dist']; ?></td>
                      <td></td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

