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
        <div class="columns">
            <div class="eight-columns">
                <h1>Lista de Metas segun Mes </h1>
            </div>
            <div class="four-columns">
                <button class="button huge full-width green-gradient glossy" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Rutas', 'action' => 'metas')) ?>');">NUEVAS METAS</button>
            </div>
        </div>

    </hgroup>

    <div class="with-padding">
        <div class="columns">
            <div class="seven-columns">
                <table class="table responsive-table" id="sorting-advanced">
                    <thead>
                        <tr>                      
                            <th>Fecha</th>
                            <th>A&ntilde;o</th>
                            <th>Mes</th>
                            <th>Meta</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($metas as $me): ?>
                          <tr>
                              <td><?php echo $me[0]['creado'] ?></td>
                              <td><?php echo $me['Meta']['anyo'] ?></td>
                              <td><?php echo $meses[$me['Meta']['mes']] ?></td>
                              <td><?php echo $me[0]['total'] ?></td>
                              <td>
                                  <a href="javascript:" onclick="$('#vermetas').load('<?php echo $this->Html->url(array('controller' => 'Rutas', 'action' => 'vermetas', $me['Meta']['anyo'], $me['Meta']['mes'])) ?>');" class="button blue-gradient glossy">VER</a>
                                  <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Rutas', 'action' => 'metas', $me['Meta']['anyo'], $me['Meta']['mes'])) ?>');" class="button green-gradient glossy">EDITAR</a>

                                  <?php echo $this->Html->link("Eliminar",array('controller' => 'Rutas','action' => 'eliminametas', $me['Meta']['anyo'], $me['Meta']['mes']),array('class' => 'button red-gradient glossy','confirm' => 'Esta seguro de eliminar las metas??')); ?>
                              </td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table> 
            </div>
            <div class="five-columns" id="vermetas">

            </div>
        </div>


    </div>
</section>

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

<?php if (!empty($metas[0])): ?>
  <script>

    $('#vermetas').load('<?php echo $this->Html->url(array('controller' => 'Rutas', 'action' => 'vermetas', $metas[0]['Meta']['anyo'], $metas[0]['Meta']['mes'])) ?>');

  </script>
<?php endif;
F ?>