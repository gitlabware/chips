
<table class="simple-table responsive-table" id="sorting-example2">
    <thead>
        <tr>
            <th>
                No.
            </th>
            <th>
                Prod
            </th>
            <th>
                Cant.
            </th>
            <th>
                Costo
            </th>
        </tr>
    </thead>
    <tfoot>
       <tr>
                <td colspan="2">Total</td>
                <td style="font-size: 22px; font-weight: bold"><?php echo $cantidades[0][0]['cantidad']?></td>
                <td  style="font-size: 22px; font-weight: bold; text-align: right;">
                    <?php echo $cantidades['0'][0]['total']?>
                </td>
            </tr>
            <tr>
            <td colspan="4">
                <a href="<?php echo $this->Html->url(array('action'=>'cerrarventa'))?>" class="button">
                    <span class="button-icon"><span class="icon-download"></span></span>
                    Cerrar venta actual
                </a>

            </td>
        </tr>
    </tfoot>
    <tbody>
        <?php $c = 0; ?>
        <?php foreach ($ventas as $v): ?>
            <tr>
                <th scope="row">
                    <?php echo $c + 1; ?>
                </th>
                <td>
                    <?php echo $v['Producto']['nombre']; ?>
                </td>
                <td  style="font-size: 22px; font-weight: bold">
                    <?php echo $v['Ventastienda']['cantidad'] ?>
                </td>
                <td  style="font-size: 22px; font-weight: bold; text-align: right;"><?php echo $v['Ventastienda']['total']?></td>
                <td class="align-right vertical-center">
                    <!--<a href="#" class="button icon-trash with-tooltip confirm" title="Eliminar"></a>-->
                   <?php echo $this->Ajax->link(null, 
                                                array(
                                                    'controller' => 'Tiendas', 
                                                    'action' => 'ajaxquita', $v['Ventastienda']['id'], $v['Ventastienda']['cantidad'], $v['Ventastienda']['precio']), 
                                                array(
                                                    'update' => 'cargaDatos',
                                                    'escape' => false,
                                                    'class' => 'button icon-trash with-tooltip confirm',
                                                    'style' => 'margin-bottom: 10px; text-transform: uppercase; font-size: 113%;'
                                                    )
                                        );?>
                </td>					
            </tr>
            <?php $c++; ?>
        <?php endforeach; ?>
            
    </tbody>
</table>