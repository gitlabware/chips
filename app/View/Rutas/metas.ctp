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

<div class="with-padding">
    <?php echo $this->Form->create('Ruta', array('id' => 'form_precio')); ?>
    <?php 
    $year = date('Y');
    $month = '';
    if (!empty($ano)){
      $year = $ano;
    }
    if (!empty($mes)){
      $month = $mes;
    }
    ?>

    <div class="columns">

        <div class="new-row four-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">A&ntilde;o <small>(requerido)</small></label> 

                <?php echo $this->Form->year('Meta.anyo', date('Y') - 2, date('Y') + 2, array('class' => 'select full-width', 'value' => $year,'required'));
                ?>
            </p>
        </div>
        <div class="four-columns">
            <p class="block-label button-height">
                <label for="block-label-1" class="label">Mes <small>(requerido)</small></label> 

                <?php echo $this->Form->select('Meta.mes', $meses, array('class' => 'select full-width','required','value' => $month)); ?>
            </p>
        </div>
        <div class="four-columns">
            <p class="block-label button-height">
                <?php echo $this->Form->submit('Registrar', array('class' => 'button green-gradient glossy big')); ?>
            </p>
        </div>
    </div>
    

    <table class="simple-table responsive-table" id="datatable4">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Mercado</th>
                <th>Meta</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rutas as $key => $ru): ?>
            <?php 
            $meta = '';
            if (!empty($ru['Meta']['meta'])){
              $meta = $ru['Meta']['meta'];
            }
            ?>
              <tr>
                  <td><?php echo $ru['Ruta']['cod_ruta'] ?></td>
                  <td><?php echo $ru['Ruta']['nombre'] ?></td>
                  <td>
                      <?php echo $this->Form->hidden("Metas.$key.ruta_id",array('value' => $ru['Ruta']['id']))?>
                      <?php echo $this->Form->text("Metas.$key.meta", array('class' => 'input', 'size' => 12, 'type' => 'number', 'min' => 0,'value' => $meta)) ?>
                  </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $this->Form->end(); ?>
</div>
