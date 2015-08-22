
<?php 
App::Import('Model', 'Ventasdistribuidore', 'Movimiento', 'Productosprecio');
$venta = new Ventasdistribuidore();
$mov = new Movimiento();
$valores = new Productosprecio();
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
<h1>REPORTE GENERAL POR PRODUCTO</h1>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
<b>Distribuidor:</b>
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo $nombre; ?>
</div>
</div>
</div>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
<b>Fecha:</b>
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo $fecha; ?>
</div>
</div>
</div>

<?php 
                    $totalgeneral =0;
                    $totalventabs = 0;
                    foreach ($rows as $r): 
                    $idProducto = $r['Producto']['id'];
                    $i=1;
                    ?>
<div data-role="collapsible" data-theme="b" data-content-theme="b">
    <h4><?php echo $r['Producto']['nombre']?></h4>
    
    <?php
                        $dato = $mov->find('first', array(
                                    'conditions'=>array(
                                                       'Movimiento.producto_id'=>$idProducto,
                                                       'Movimiento.persona_id'=>$idDistribuidor
                                                       ),
                                    'order'=>array('Movimiento.id DESC'),
                                    'recursive'=>-1
                            ));
                           //debug($dato);
                            if(!empty($dato)){
                                $ingreso = $dato['Movimiento']['ingreso'];
                                $saldo = $dato['Movimiento']['saldo'];
                                $total = $dato['Movimiento']['total'];
                            }else{
                               $saldo = 0;
                               $ingreso = 0;
                               $total = 0;
                            }
                        ?>
    <div class="ui-grid-a">
    <div class="ui-block-a">
    <div class="ui-bar-a">
    SALDO:
    </div>
    </div>
    <div class="ui-block-b">
    <div class="ui-bar-a">
    <?php echo $saldo?>
    </div>
    </div>
    </div>
    <div class="ui-grid-a">
    <div class="ui-block-a">
    <div class="ui-bar-a">
    INGRESO:
    </div>
    </div>
    <div class="ui-block-b">
    <div class="ui-bar-a">
    <?php echo $ingreso?>
    </div>
    </div>
    </div>
    <div class="ui-grid-solo">
    <div class="ui-block-a">
    <div class="ui-bar-b">
    VENTAS
    </div>
    </div>
    </div>
    <?php $precios = $valores->find('all', array(
                       'conditions'=>array('Productosprecio.producto_id'=>$idProducto, 'Productosprecio.tipousuario_id'=>3),
                       'recursive'=>-1)) ?>
    <?php 
                        $totalcantidad=0;
                        $totalbs = 0;
                        $cantidadcolumnas =0;
                        foreach($precios as $val):?>

<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-a">
<?php echo $val['Productosprecio']['precio']?>
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php 
                        $ventad = $venta->find('all', array(
                                                        'conditions'=>array(
                                                            'Ventasdistribuidore.producto_id'=>$idProducto,
                                                            'Ventasdistribuidore.persona_id'=>$idDistribuidor,
                                                            'Ventasdistribuidore.precio'=>$val['Productosprecio']['precio'], 
                                                            'Ventasdistribuidore.fecha'=>$fecha),
                                                        'fields'=>array('sum(Ventasdistribuidore.cantidad) as cantidad', 'sum(Ventasdistribuidore.total) as total'),
                                                        'group'=>array('Ventasdistribuidore.producto_id')
                                                        ));
                            
                            $cantidad = $ventad['0']['0']['cantidad'];
                            
                            $totalcantidad += $cantidad;
                            $totalbs += $ventad['0']['0']['total'];
                            echo $cantidad;
                        ?>
</div>
</div>
</div>

    <?php 
                        $cantidadcolumnas++;
                        endforeach;
                        //debug($cantidadcolumnas);
                        ?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
SALDO ACTUAL:
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php
                        
                        echo $total;
                        ?>
</div>
</div>
</div>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
TOTAL:
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo number_format($totalbs,2,',', '.'); 
                        $totalventabs += $totalbs;?>
</div>
</div>
</div>

</div>
<?php endforeach;?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
Total venta:
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo number_format($totalventabs, 2, ',', '.')?>
</div>
</div>
</div>
<?php if (!empty($recargas)): ?>
<?php
                    $totalrecargas = 0;
                    foreach ($recargas as $r):
                        $totalrecargas += $r['Recarga']['monto'];
?>
<div data-role="collapsible" data-theme="b" data-content-theme="b">
    <h4>Detalle Recarga</h4>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-a">
Cliente: 
</div>
</div>
<div class="ui-grid-b">
<div class="ui-bar-a">
<?php echo $r['Cliente']['num_registro']; ?> <?php echo $r['Cliente']['nombre']; ?>
</div>
</div>
</div>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-a">
Numero: 
</div>
</div>
<div class="ui-grid-b">
<div class="ui-bar-a">
<?php echo $r['Recarga']['numero'] ?>
</div>
</div>
</div>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-a">
Monto: 
</div>
</div>
<div class="ui-grid-b">
<div class="ui-bar-a">
<?php echo number_format($r['Recarga']['monto'],2,',', '.') ?>
</div>
</div>
</div>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-a">
Porcentaje: 
</div>
</div>
<div class="ui-grid-b">
<div class="ui-bar-a">
<?php echo $r['Recarga']['porcentaje'] ?>
</div>
</div>
</div>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-a">
Recarga Real: 
</div>
</div>
<div class="ui-grid-b">
<div class="ui-bar-a">
<?php echo $r['Recarga']['total'] ?>
</div>
</div>
</div>

</div>
<?php endforeach;?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
Total Recargas: 
</div>
</div>
<div class="ui-grid-b">
<div class="ui-bar-a">
<?php echo number_format($totalrecargas,2,',', '.') ?>
</div>
</div>
</div>
<?php endif;?>
<?php
                //debug($totalrecargas);
                //debug($totalventa);
                $ventahoy = 0;
                $ventahoy = $totalrecargas + $totalventabs;
                //debug($ventahoy);

?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
Total Ventas y Recargas: 
</div>
</div>
<div class="ui-grid-b">
<div class="ui-bar-a">
<?php echo number_format($ventahoy, '2', '.', ',') ?>
</div>
</div>
</div>