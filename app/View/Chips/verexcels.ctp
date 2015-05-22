<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de excels subidos</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col" width="5%" class="align-center hide-on-mobile">Nro.</th>
                    <th scope="col" width="10%" class="align-center hide-on-mobile">Nombre archivo</th>
                    <th scope="col" width="15%" class="align-center hide-on-mobile">Fecha</th>
                </tr>
            </thead>          

            <tbody>
                <?php $i=1; foreach ($excels as $p): ?>
                    <tr>
                        <td><?php echo $i; $i++; ?></td>                      
                        <td><?php echo $p['Excel']['nombre_original']; ?></td>
                        <td><?php echo $p['Excel']['created']; ?></td>
                        <td>
                        <?php echo $this->Html->link('detalle', array('action'=>'simsentregados', $p['Excel']['id']))?>
                        </td>
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table>   
        <td class="low-padding align-center">
<?php echo $this->Html->link('INSERTAR NUEVO PRODUCTO',array('action'=>'insertar'),array('class'=>'button blue-gradient'));?>
</td>    
    </div>
</section>	

<script>
$(document).ready(function(){$("#formID").validationEngine();});
</script>
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 
