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
    <hgroup id="main-title" class="thin">
        <h1>METAS CHIP'S</h1>
    </hgroup>
    <div class="with-padding">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4" style="text-align: center;"><?php echo $ano . ' - ' . $meses[(int)$mes] ?></th>
                </tr>
                <tr>
                    <th>Mercado</th>
                    <th>Meta</th>
                    <th>Ventas</th>
                    <th>Cumpl.</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($metas as $me): ?>
                    <tr>
                        <td><?php echo $me['Ruta']['cod_ruta'] . '-' . $me['Ruta']['nombre']; ?></td>

                        <td><?php echo $me['Meta']['meta']; ?></td>
                        <td><?php echo $me['Meta']['ventas']; ?></td>
                        <td><?php 
                        if(!empty($me['Meta']['meta'])){
                            echo round((($me['Meta']['ventas']/$me['Meta']['meta'])*100),2).' %';
                        }else{
                            echo '0 %';
                        }
                        ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table> 
    </div>
</section>

<?php echo $this->element('sidebar/distribuidor'); ?>