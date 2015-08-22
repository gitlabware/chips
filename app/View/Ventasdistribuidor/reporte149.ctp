<?php echo $this->Html->script(array('jquery-1.6.min','print'))?>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Reporte <?php echo date('d-m-Y') ?></h1>
    </hgroup>

    <div class="with-padding">
    <div id="areaImprimir">

        <div class="title-grid"><span>ventas del dia reporte por 149</span></div>
        <div class="content-gird">
            <div id="imprimir">
                <table class="simple-table responsive-table" id="sorting-example2">
                    <thead>
                    <th scope="col" width="15%">Distribuidor</th>
                    <th scope="col" width="15%"><?php echo $distribuidor; ?></th>
                    <th scope="col" width="15%">fecha</th>
                    <th scope="col" width="15%"><?php echo $hoy; ?></th>
                    </thead>
                </table>
                <div>
                    &nbsp;
                </div>   
                <div>
                    <?php if (!empty($ventas)): ?>
                        <table class="simple-table responsive-table" id="sorting-example2">
                            <thead>
                                <tr>
                                    <th scope="col" width="15%">149</th>
                                    <th scope="col" width="5%">Producto</th>
                                    <th scope="col" width="5%">Cantidad</th>
                                    <th scope="col" width="2%">escala</th>
                                    <th scope="col" width="2%" style="text-align: right">precio</th>
                                    <th scope="col" width="2%"style="text-align: right">Tot Bs</th>
                                </tr>

                            </thead>
                            
                            <tbody>
                                <?php
                                $totalventa = 0;
                                $totalrecargas = 0;
                                $totalparcial = 0;
                                ?>
                                <?php
                                $totalventa=0;
                                foreach ($ventas as $v): 
                                   
                                   $totalparcial += $v['Ventasdistribuidore']['total']; 
                                   $totalventa += $totalparcial;?>
                                    <tr>
                                        <!--impresion de las ventas-->
                                        
                                        <th scope="row">
                                        <?php echo $v['Cliente']['num_registro']; ?><br>
                                            <small><?php echo $v['Cliente']['nombre']; ?></small>
                                        </th>
                                        
                                        <td><?php echo $v['Producto']['nombre']; ?></td>
                                        <td><?php echo $v['Ventasdistribuidore']['cantidad']; ?></td>
                                        <td><?php echo $v['Ventasdistribuidore']['escala']; ?></td>
                                        <td scope="col" width="5%" style="text-align: right"><?php echo number_format($v['Ventasdistribuidore']['precio'],2, '.', ','); ?></td>
                                        <td style="text-align: right"><?php echo number_format($v['Ventasdistribuidore']['total'],2, '.', ','); ?></td>
                                        <?php $a = 1; ?>
                                    </tr>
                                 <?php endforeach; ?>
                            </tbody>
                        </table>
                        <table class="simple-table responsive-table" id="sorting-example3">
                            <tr>
                                <th width="95%">Total venta de hoy: </th>
                                <td><?php echo number_format($totalventa, '2', '.', ','); ?></td>
                            </tr>
                        </table>
<?php endif; ?>            
<?php if (!empty($recargas)): ?>
                    <h4>Detalle recargas</h4>
                        <table class="simple-table responsive-table" id="sorting-example4">
                            <thead>
                                <tr>
                                    <th scope="col" width="12%">
                                        cliente
                                    </th>
                                    <th scope="col" width="5%">
                                        numero
                                    </th>
                                    <th scope="col" width="5%">
                                        monto
                                    </th>
                                    <th scope="col" width="2%">
                                        porcentaje
                                    </th>
                                    <th scope="col" width="5%">
                                        recarga real
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php foreach ($recargas as $r): ?>
                                    <tr>
                                        <th scope="row">
                                        <?php echo $r['Cliente']['num_registro']; ?><br>
                                            <small><?php echo $r['Cliente']['nombre']; ?></small>
                                        </th>
                                        
                                        <td>
                                            <?php echo $r['Recarga']['numero'] ?>
                                        </td>
                                        <td>
                                            <?php echo $r['Recarga']['monto'] ?>
                                        </td>
                                        <td>
                                            <?php echo $r['Recarga']['porcentaje'] ?>
                                        </td>
                                        <td>
                                    <?php echo $r['Recarga']['total'] ?>
                                        </td>
                                    </tr>
                        <?php endforeach; ?>
                            </tbody>
                        </table>    
                <?php endif; ?>
                </div>
                <div class="grid-buttons">
                </div>
            </div><!--fin div contenedor -->
        </div>
    </div><!--fin div imprimir-->
</div>
<table>


  <a href="#" id="btnImprimir">IMPRIMIR</a>
  <?php echo $this->Html->link('ATRAS',array('action'=>'pidecodigo'),array('style'=>'text-aling: left; padding: 0 0 0 15px;'));?>

</table>


<script>
$(document).ready(function(){
    
    $("#btnImprimir").click(function() {
            console.log('<?php echo $this->webroot?>');
            //printElem({leaveOpen: true, printMode: 'popup'});
            printElem({ overrideElementCSS: ["<?php echo $this->webroot?>/css/imprimetabla.css"] });
        });
        
});
function printElem(options) {
        $('#areaImprimir').printElement(options);
    }
</script>