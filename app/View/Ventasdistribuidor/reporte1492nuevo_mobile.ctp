<?php
App::Import('Model', 'Ventasdistribuidore');
$venta = new Ventasdistribuidore();
$totalventa = 0;
$totalrecargas = 0;
$ventashoy = 0;
?>
<h1>Reporte <?php echo $hoy ?></h1>
<h3>ventas del dia reporte por 149</h3>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
<b>Distribuidor:</b>
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo $distribuidor; ?>
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
<?php echo $hoy; ?>
</div>
</div>
</div>
<?php if (!empty($ventas)): ?>
<?php
    $totalventa = 0;
    foreach ($clientes as $c):
?>
<div data-role="collapsible" data-theme="b" data-content-theme="b">
    <h4>Cliente: <?php echo $c['Cliente']['num_registro']; ?> <?php echo $c['Cliente']['nombre']; ?></h4>
<?php
        $subtotal = 0;
        foreach ($precios as $p):
?>
<?php
            $ventacliente = $venta->find('all', array('conditions' => array(
                    'Ventasdistribuidore.precio' => $p['Productosprecio']['precio'],
                    'Ventasdistribuidore.cliente_id' => $c['Cliente']['id'],
                    'Ventasdistribuidore.user_id' => $this->Session->read('Auth.User.id'),
                    'Ventasdistribuidore.fecha' => $hoy)));
?>
<?php if (!empty($ventacliente)): ?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-a">
<?php echo $p['Producto']['nombre'].' - '.$p['Productosprecio']['precio']?>
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">

                                        <?php
                $cantidadventacliente = 0.00;
                foreach($ventacliente as $ven):
                    $cantidadventacliente = $ven['Ventasdistribuidore']['cantidad'] + $cantidadventacliente;
                    $subtotal += $ven['Ventasdistribuidore']['total'];
                endforeach;
                echo $cantidadventacliente;
?>                               
</div>
</div>
</div>
<?php endif; ?>
<?php endforeach; //fin de precios ?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
SubTotal
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php
                echo $subtotal;
                $totalventa += $subtotal;
?>
</div>
</div>
</div>
</div>
<?php endforeach;?>
<?php endif;?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
Total en ventas:
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo $totalventa ?>
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
    <h4>Detalle Recargas</h4>
    
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
Total en Recargas:
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo $totalrecargas ?>
</div>
</div>
</div>
<?php endif;?>
<?php
                //debug($totalrecargas);
                //debug($totalventa);
                $ventahoy = 0;
                $ventahoy = $totalrecargas + $totalventa;
                //debug($ventahoy);

?>
<div class="ui-grid-a">
<div class="ui-block-a">
<div class="ui-bar-b">
Total monto en Bs:
</div>
</div>
<div class="ui-block-b">
<div class="ui-bar-a">
<?php echo number_format($ventahoy, '2', '.', ',') ?>
</div>
</div>
</div>