<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Minieventos</h1>
    </hgroup>

    <div class="with-padding">                   
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($minieventos as $mi): ?>
                <tr>
                    <td><?php echo $mi['Minievento']['fecha'];?></td>
                    <td><?php echo $mi['Minievento']['direccion'];?></td>
                    <td>
                      <?php echo $this->Html->link("Ventas",array('action' => 'ventas_minievento',$mi['Minievento']['id']));?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>	

<?php echo $this->element('sidebar/impulsador'); ?>