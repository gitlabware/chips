<?php
$meses = array(
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Sepetiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Disciembre'
);
?>

<section role="main" id="main">
    <div class="with-padding">
        <details class="details margin-bottom" >
            <summary><b><?php echo strtoupper($cliente['Cliente']['nombre']); ?></b></summary>
            <div class="with-padding">
                <p><?php echo $cliente['Cliente']['direccion'] ?></p>
                <?php $entregados = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_chips_cli_v_ent', $cliente['Cliente']['id'])); ?>
                <p><?php echo '<span class="tag">' . $entregados . '</span> chips entregados en el mes.'; ?></p>
                <?php $vendidos = $this->requestAction(array('controller' => 'Chips', 'action' => 'get_chips_cli_v_ven', $cliente['Cliente']['id'])); ?>
                <p><?php echo '<span class="tag">' . $vendidos . '</span>  chips vendidos en el mes'; ?></p>
                <p><?php echo '<span class="tag">' . ($entregados - $vendidos) . '</span>  chips restantes'; ?></p>
            </div>
        </details>
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Gestion</th>
                    <th>Monto</th>
                    <th></th>
                </tr>
            </thead>          
            <tbody>
                <?php foreach ($comisiones as $co): ?>
                    <tr>
                        <td><?php echo $meses[(int) $co['Comisione']['mes']] . '-' . $co['Comisione']['gestion']; ?></td>
                        <td><?php echo $co['Comisione']['monto_a_pagar']; ?></td>
                        <td>
                            <a href="javascript:" class="button green-gradient icon-star" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Comisiones','action' => 'ajax_comision',$co['Comisione']['id'])); ?>');"></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>  
    </div>
</section>
<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/distribuidor'); ?>
<!-- End sidebar/drop-down menu --> 

