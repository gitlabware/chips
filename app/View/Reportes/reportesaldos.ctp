<?php //echo $this->Html->script(array('jquery-1.6.min','print'))?>
<?php 
App::Import('Model', 'Ventasdistribuidore', 'Movimiento');
$venta = new Ventasdistribuidore();
$mov = new Movimiento();
?>
<script>
    function sacatotal() {
        var totalpago = 0;
        //console.log($("#grandTotal").text());
        totalpago = Number($("#grandTotal").text()) + Number($("#totalrecargas").text());
        //console.log('suma total ' + totalpago);
        $("#total").html(totalpago);
    }
</script>

<section role="main" id="main">

    <div class="with-padding">
        <div class="grid-4">
            <div class="title-grid">
                <span>Reporte de venta por producto</span>
            </div>
            <div class="content-gird">
                <div id="areaImprimir">
                    <?php $id = $precios['0']['Producto']['id']; ?>
                   
                    <table class="titulos">
                        <tr>
                            <th class="txt">Distribuidor:</th>
                            <td class="txt"><?php echo $nombre; ?></td>
                            <th>Fecha: </th>
                            <td><?php echo date("y-m-d"); ?></td>
                        </tr>
                       
                    </table>
                    
                    <?php 
                    $totalgeneral =0;
                    foreach ($rows as $r): 
                    $idProducto = $r['Producto']['id'];
                    $i=1;
                    ?>
                    <?php if ($r['0']['cantidad'] == 1): ?>
                       <?php $filas = 1; ?>
                    <?php else: ?>
                       <?php $filas = $r['0']['cantidad']; ?>
                    <?php endif; 
                       $producto = 4 + $filas;
                       $cantidadProducto = 0;
                       $totalventaproducto = 0;
                    ?>
                    <table class="vertical">
                       <tr>
                          <td rowspan="<?php echo $producto?>" style="width: 10%; font-size: 14px; font-weight: bold; padding: 0 0 0 40px;">
                             <?php 
                             echo $r['Producto']['nombre'];
                             $bandera = 1;
                             $saldoactual = 0; 
                             ?>
                          </td>
                          <th colspan="2" style="width: 10% font-weight: bold; text-align: left; padding: 0 0 0 5px;">Saldo</th>
                          <td style="width: 10% font-weight: bold;">
                            <?php
                            
                            $saldo = $mov->find('first', array(
                                                   'conditions'=>array(
                                                       'Movimiento.producto_id'=>$idProducto,
                                                       'Movimiento.persona_id'=>$idDistribuidor, 
                                                       'Movimiento.ingreso !='=>'0',
                                                       ),
                                                   'fields'=>array(
                                                       'MAX(Movimiento.id) as id', 
                                                       )));
                            $dato = $mov->find('first', array(
                                                    'conditions'=>array('Movimiento.id'=>$saldo['0']['id']),
                                                    'recursive'=>-1));
                            //debug($dato);
                            if(!empty($dato)){
                                $ingreso = $dato['Movimiento']['ingreso'];
                                $saldo = $dato['Movimiento']['ingreso'] - $dato['Movimiento']['saldo'];
                            }else{
                               $saldo = 0;
                               $ingreso = 0;
                            } 
                            echo $saldo;
                            ?>
                          </td>
                       </tr>
                       <tr>
                          <th colspan="2">Ingreso</th>
                          <td>
                          <?php 
                          
                          echo $ingreso;?>
                          </td>
                       </tr>
                       
                          <?php
                            $totalventas = 0;
                            $totalbs=0;
                            foreach ($precios as $p): 
                            $precio = $p['Productosprecio']['precio'];
                            
                            $cantidad2 = $venta->find('all', array(
                                                        'conditions'=>array(
                                                            'Ventasdistribuidore.producto_id'=>$idProducto,
                                                            'Ventasdistribuidore.persona_id'=>$idDistribuidor,
                                                            'Ventasdistribuidore.precio'=>$precio, 
                                                            'Ventasdistribuidore.fecha'=>$fecha),
                                                        'fields'=>array('sum(Ventasdistribuidore.cantidad) as cantidad', 'sum(Ventasdistribuidore.total) as total'),
                                                        'group'=>array('Ventasdistribuidore.producto_id')
                                                        ));
                            
                            $cantidad = $cantidad2['0']['0']['cantidad'];
                            
                            $totalventas += $cantidad;
                            $totalbs += $cantidad2['0']['0']['total'];
                            
                            
                        ?>
                            <?php 
                            if ($p['Productosprecio']['producto_id'] == $r['Producto']['id']):
                            if($bandera == 1):
                            $bandera = 0;
                             ?>
                            <tr>
                               <th rowspan="<?php echo $filas;?>">ventas</th>
                               <td> 
                                  <?php
                                  echo "$" . number_format($precio, '2', ',', '.'); ?>
                               </td>
                               <td>
                                  <?php echo $cantidad;?>
                               </td>                           
                            </tr>
                            <?php else:?>
                            <tr>             
                               <td>
                               <?php 
                               echo "$" . number_format($precio, '2', ',', '.'); ?>
                               </td>
                               <td>
                               <?php echo $cantidad;?>
                               </td>
                            </tr>
                            <?php endif; ?>
                            <?php endif;?>    
                            <?php 
                            $i++;
                            endforeach; ?>
                            
                            
                            
                            <tr>
                            <th colspan="2">saldo actual</th>
                            <td>
                            <?php $saldoactual = $ingreso + $saldo - $totalventas;
                            echo $saldoactual;
                            ?>
                            </td>
                            </tr>
                            <tr>
                            <th colspan="2">Total Bs</th>
                            <td><?php echo number_format($totalbs, '3', ',','.')?></td>
                            </tr>
                            <tr>
                            <th style="font-weight: bold;">
                            Cantidad total <?php echo $r['Producto']['nombre'];?>
                            </th>
                            <th>
                            <?php echo $cantidadProducto?>
                            </th>
                            <th>
                            Total Bs <?php echo $r['Producto']['nombre'];?>
                            </th>
                            <th>
                            <?php echo $totalventaproducto?> 
                            </th>
                            </tr>
                        </table>
                        <?php $totalgeneral += $totalbs;?>
                    <?php endforeach; ?>
                    <table class="vertical">

                        <tr>
                            <th align="right" class="text" colspan="3">
                                <strong>Total ventas:</strong>
                            </th>

                            <th align="center" id="grandTotal">
                            <?php echo number_format($totalgeneral, '3', ',','.')?>
                            </th>
                        </tr>


                    </table> 
                    
                     <?php if (!empty($recargas)): ?>
                <h4>Detalle recargas</h4>
                <table class="vertical" id="sorting-example4">
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
                                <?php echo $r['Cliente']['num_registro']; ?><br/>
                                <small><?php echo $r['Cliente']['nombre']; ?></small>
                                <small>
                                Hrs:
                                <?php
                                $hora = explode(" ", $r['Recarga']['created']); 
                                echo $hora[1]?>
                                </small>
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
                $ventahoy = $totalrecargas + $totalgeneral;
                //debug($ventahoy);

?>
            <table class="vertical">
                <th>
                    Total monto en Bs
                </th>
                <th>
<?php echo number_format($ventahoy, '2', '.', ',') ?>
                </th>
            </table>
            <?php if(!empty($deposito)):?>
            <table class="vertical">
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
                <tr>
                    <th>
                        Total Bs 
                    </th>
                    <td>
    <?php echo number_format($deposito['Deposito']['efectivo'], '2', '.', ',') ?>
                    </td>    
                    <td>
                        Recibo <?php echo $deposito['Deposito']['recibo'] ?>
                    </td>
                    
                </tr>
            </table>
            <?php endif;?>
                </div>

            </div>

            <!--*************************************************************************************************************************************
                     //botoneria-->
            <div class="grid-buttons">

                <?php echo $this->Html->link('ATRAS', array('action' =>
'saldos'), array('class' => 'button blue-gradient')); ?>
<a href="#" id="btnImprimir">IMPRIMIR</a>


                <div class="clear"> </div>
            </div>
            <!--/*************************************************************************************************************************************-->         
        </div>
    </div>

</section>
<!-- Sidebar/drop-down menu -->
<?php //echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu -->
<script>
    $(document).ready(function() {
       
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