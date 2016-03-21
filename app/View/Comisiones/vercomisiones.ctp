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
<?php
$gestion = unserialize($excel['Excel']['detalles']);
?>
<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Comisiones (<?php echo $meses[(int) $gestion['mes']] . '-' . $gestion['gestion']; ?>)</h1>
    </hgroup>
    <div class="with-padding">
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th scope="col" class="align-center">CODIGO</th>
                    <th scope="col" class="align-center">SUBDILER</th>
                    <th scope="col" class="align-center">ZONA</th>
                    <th>SUBDEALER RECONOCIDO</th>
                    <th scope="col" class="align-center">MONTO A PAGAR</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comisiones as $co): ?>
                    <?php
                    $estilo = '';
                    if (empty($co['Comisione']['cliente_id'])) {
                        $estilo = 'style="background-color: #FFDACC;"';
                    }
                    ?>
                    <tr <?php echo $estilo; ?>>
                        <td><?php echo $co['Comisione']['codigo'] ?></td>
                        <td><?php echo $co['Comisione']['subdealer'] ?></td>
                        <td><?php echo $co['Comisione']['zona'] ?></td>
                        <td><?php echo $co['Cliente']['nombre'] ?></td>
                        <td><?php echo $co['Comisione']['monto_a_pagar'] ?></td>
                        <td>
                            <?php echo $this->Html->link('<span class="icon-trash"></span>', array('action' => 'eliminar', $co['Comisione']['id']), array('class' => 'button red-gradient glossy', 'confirm' => 'Esta seguro de eliminar la comision??', 'escape' => false, 'title' => 'Eliminar Comision')) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php echo $this->element('sidebar/administrador'); ?>
