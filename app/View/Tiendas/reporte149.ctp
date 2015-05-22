<?php
App::Import('Model', 'Ventastienda');
$venta = new Ventastienda();
$totalventa = 0;
$totalrecargas = 0;
$ventashoy = 0;
?>
<div class="section">

    <hgroup id="main-title" class="thin">
        <h1>Reporte <?php echo $hoy ?></h1>
    </hgroup>
    <div id="areaImprimir">

        <div class="title-grid"><span>ventas del dia reporte por 149</span></div>
        <div class="content-gird">
            <table class="titulos">
                <thead>
                <th scope="col" width="15%">Sucursal(tienda)</th>
                <th scope="col" width="15%"><?php echo $nombre; ?></th>
                <th scope="col" width="15%">fecha</th>
                <th scope="col" width="15%"><?php echo $hoy; ?></th>
                </thead>
            </table>

            <table  id="sorting-example2">
                <thead>
                    <tr style="border: 1px black">
                        <th scope="col" rowspan="2" style="border: 1px black">149</th>
                        <?php foreach ($rows as $r): ?>
                            <th scope="col"  colspan="<?php echo $r['0']['cantidad'] ?>" style="text-align: center; border: 1px black">
                                <?php echo $r['Producto']['nombre'] ?>
                            </th>
                        <?php endforeach; ?>
                        <th rowspan="2">
                            Subtotal
                        </th>

                    </tr>
                    <tr>


                        <?php foreach ($precios as $precio): ?>

                            <th>
                                <?php echo $precio['Productosprecio']['precio'] ?>
                            </th>

                        <?php endforeach; ?>

                    </tr>
                </thead>

                <?php if (!empty($ventas)): ?>

                    <?php
    $totalventa = 0;
    
    foreach ($clientes as $c):
?>
                        <tr>
                            <th scope="row">
        <?php echo $c['Cliente']['num_registro']; ?><br>
                                <small><?php echo $c['Cliente']['nombre']; ?></small>
                            </th>

                            <?php
        $subtotal = 0;
        foreach ($precios as $p):
?>
                                <?php
                                
            $ventacliente = $venta->find('all', array('conditions' => array(
                    'Ventastienda.precio' => $p['Productosprecio']['precio'],
                    'Ventastienda.cliente_id' => $c['Cliente']['id'],
                    'Ventastienda.sucursal_id' => $sucursal,
                    'Ventastienda.created' => $hoy),
                'fields'=>array('sum(Ventastienda.cantidad) as cantidad', 'sum(Ventastienda.total) as total'),
                'group'=>array('Ventastienda.cliente_id')
                ));
            //debug($ventacliente);exit;
            
?>
                                <td>
                                    <?php if (!empty($ventacliente)): ?>
                                        <?php
                echo $ventacliente['0']['0']['cantidad'];
                $subtotal += $ventacliente['0']['0']['total'];
?>
            <?php else: ?>
                                        0
                                <?php endif; ?>
                                </td>


                                <?php endforeach; //fin de precios ?>
                            <td>
                                <?php
                echo $subtotal;
                $totalventa += $subtotal;
?>
                            </td>
                        </tr> 
        <?php endforeach; ?>
                    <tr>
                        <th colspan="5">
                            Total en ventas
                        </th>
                        <th>
                        <?php echo $totalventa ?>
                        </th>
                    </tr>
                </table>
                <div>
                    <?php echo $this->Form->button('detalle vertical', array('id' =>
'btnVertical')) ?>
                </div>
                <div id='vertical'>
                    <table class="simple-table responsive-table" id="sorting-example2">
                        <thead>
                            <tr>                      

                                <th rowspan="2" scope="col" width="15%">149</th>
                                <th scope="col" width="5%">Producto</th>
                                <th rowspan="2" scope="col" width="5%">Cantidad</th>
                                <th rowspan="2" scope="col" width="5%">Escala</th>
                                <th scope="col" width="2%" style="text-align: right">precio</th>
                                <th scope="col" width="2%"style="text-align: right">Tot Bs</th>
                            </tr>

                        </thead>  
                        <tbody>

                            <?php
                $totalventa2 = 0;
                $totalparcial = 0;
?>
                            <?php
                $totalventa2 = 0;
                foreach ($ventas as $v):

                    $totalparcial += $v['Ventastienda']['total'];
                    $totalventa2 += $totalparcial;
?>
                                <tr>
                                    <!--impresion de las ventas-->

                                    <th scope="row">
                                    <?php echo $v['Cliente']['num_registro']; ?><br>
                                        <small><?php echo $v['Cliente']['nombre']; ?></small>
                                    </th>

                                    <td><?php echo $v['Producto']['nombre']; ?></td>
                                    <td><?php echo $v['Ventastienda']['cantidad']; ?></td>
                                    <td><?php echo $v['Ventastienda']['escala']; ?></td>
                                    <td scope="col" width="5%" style="text-align: right"><?php echo
number_format($v['Ventastienda']['precio'], 2, '.', ','); ?></td>
                                    <td style="text-align: right"><?php echo
number_format($v['Ventastienda']['total'], 2, '.', ','); ?></td>
                                <?php $a = 1; ?>
                                </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    
            <?php endif; ?>            

            </div>
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
                        <?php
                    $totalrecargas = 0;
                    foreach ($recargas as $r):
                        $totalrecargas += $r['Recarga']['monto'];
?>
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
                        <tr>
                            <th colspan="2">
                                Total en recargas 
                            </th>
                            <td>
                            <?php echo $totalrecargas ?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                    </tbody>
                </table>    
                <?php endif; ?>
<?php
                //debug($totalrecargas);
                //debug($totalventa);
                $ventahoy = 0;
                $ventahoy = $totalrecargas + $totalventa;
                //debug($ventahoy);

?>
            <table>
                <th>
                    Total monto en Bs
                </th>
                <th>
<?php echo number_format($ventahoy, '2', '.', ',') ?>
                </th>
            </table>
        </div>
<?php if (!empty($deposito)): ?>
            <table>
                <tr>
                    <th>
                        Deposito Banco
                    </th>
                    <td>
    <?php echo number_format($deposito['Deposito']['banco'], '2', '.', ',') ?>
                    </td>
                    <td>
                        Comprobante <?php echo $deposito['Deposito']['comprobante'] ?>
                    </td>
                </tr>
                <tr>
                    <th>
                        Deposito Efectivo
                    </th>
                    <td>
    <?php echo number_format($deposito['Deposito']['efectivo'], '2', '.', ',') ?>
                    </td>    
                    <td>
                        Recibo <?php echo $deposito['Deposito']['recibo'] ?>
                    </td>
                </tr>

            </table>

<?php endif; ?>
    </div>
    <div>
        <a href="#" id="btnImprimir">IMPRIMIR</a>
        <a href="<?php echo $this->Html->url($this->request->referer()) ?>" style="text-align: left; padding: 0 0 0 5px">ATRAS</a>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#vertical").hide();

        $("#btnVertical").click(function() {
            $("#vertical").toggle('slow');
        });
        $("#btnImprimir").click(function() {
            console.log('<?php echo $this->webroot ?>');
            //printElem({leaveOpen: true, printMode: 'popup'});
            printElem({overrideElementCSS: ["<?php echo $this->webroot ?>/css/imprimetabla.css"]});
        });

    });
    function printElem(options) {
        $('#areaImprimir').printElement(options);
    }
</script>

