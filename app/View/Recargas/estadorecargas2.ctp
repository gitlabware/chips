<section  role="main" id="main">
    <div class="with-padding">
        <div class="columns">
            <div class="four-columns six-columns-tablet twelve-columns-mobile">
                <h3>Saldos y recargas a la fecha</h3>
                <p>
                    El saldo es el monto restante para recargas <br/>
                    El ingreso es el monto del ultimo ingreso a la fecha
                </p>
                <ul class="list spaced">
                    <li>
                        <strong>SALDO</strong>
                        <div class="absolute-right">
                            <?php echo number_format($recarga['Movimientosrecarga']['saldo'], '2', ',', '.') ?>
                        </div>
                    </li>
                    <li>
                        <strong>TOTAL INGRESOS DIA</strong> 
                        <?php
                        $fecha = split('-', $recarga['Movimientosrecarga']['fecha']);
                        echo $fecha['2'] . '/' . $fecha['1'] . '/' . $fecha['0']
                        ?>
                        <div class="absolute-right compact">
                            <?php echo number_format($recarga['Movimientosrecarga']['ingreso'], '2', ',', '.') ?>
                        </div>
                    </li>
                    <li>
                        <strong>SALDO TOTAL</strong>
                        <div class="absolute-right">
                            <?php echo number_format($recarga['Movimientosrecarga']['saldo_total'], '2', ',', '.') ?>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="clear twelve-columns">

            </div>
            <div class="four-columns six-columns-tablet twelve-columns-mobile">
                <h3>listado recargas realizadas a la fecha</h3>
                <p>
                    Listado de recargas<br/>
                    Nombre del cliente fecha de la recarga y monto cargado

                </p>
                <ul class="list spaced">
                    <?php foreach ($realizados as $r): ?>
                      <li>
                          <strong><?php echo $r['Cliente']['nombre'] ?></strong> 
                          <?php
                          $fecha = split('-', $r['Recarga']['modified']);
                          echo $fecha['2'] . '/' . $fecha['1'] . '/' . $fecha['0']
                          ?>
                          <div class="absolute-right compact">
                              <?php echo number_format($r['Recarga']['total'], '2', ',', '.') ?>
                          </div>
                      </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 


