<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>HOJA DE RUTEO (<?php echo "$fecha_ini - $fecha_fin"; ?>)</h1>
    </hgroup>
    <div class="with-padding">    
        <div class="columns">
            <div class="six-columns">
                <a href="<?php echo $this->Html->url(array('controller' => 'Informes', 'action' => 'exc_hoja_ruteo_d',$fecha_ini,$fecha_fin)); ?>" class="button full-width">
                    <span class="button-icon"><span class="icon-download"></span></span>
                    Descargar excel
                </a>
            </div>
        </div>
        <div class="columns">
            <div class="twelve-columns " style="overflow: auto;">
                <table class="simple-table responsive-table" style="width: 2000px;">
                    <thead>
                        <tr>                      
                            <th>Nro</th>
                            <th>Fecha</th>
                            <th>Distribuidor</th>
                            <th>Codigo Subdealer</th>
                            <th>Nombre Subdealer</th>
                            <th>Codigo de Mercado</th>
                            <th>Mercado</th>
                            <th>CAP</th>
                            <th>Estado del punto</th>
                            <th>Cant SIM Movil</th>
                            <th>Cant SIM 4G</th>
                            <th>Tarjetas 10</th>
                            <th>Microrecarga</th>
                            <th># Recarga</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>          
                    <tbody>
                        <?php foreach ($ventas as $key => $ve): ?>
                          <tr>
                              <td><?php echo ($key + 1); ?></td>
                              <td><?php echo $ve['Movimiento']['created']; ?></td>
                              <td><?php echo $ve['Persona']['nombre']; ?></td>
                              <td><?php echo $ve['Cliente']['cod_dealer']; ?></td>
                              <td><?php echo $ve['Cliente']['nombre']; ?></td>
                              <td><?php echo $ve['Cliente']['cod_mercado']; ?></td>
                              <td><?php echo $ve['Cliente']['mercado']; ?></td>
                              <td><?php echo $ve['Movimiento']['capacitacion']; ?></td>
                              <td><?php echo $ve['Movimiento']['est_punt']; ?></td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td></td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> 
            </div>
        </div>

    </div>
</section>	

<?php echo $this->element('sidebar/administrador'); ?>