<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Entregas <?php echo $premio['Premio']['nombre']?></h1>
    </hgroup>
    <div class="with-padding"> 
        <?php echo $this->Form->create('Impulsadore',array('action' => 'registra_entrega_pre'));?>
        <div class="columns">
            <div class="six-columns twelve-columns-mobile">
              <p class="block-label button-height">
                  <label for="block-label-1" class="label">Cantidad <label class="tag">(Total <?php echo $premio['Premio']['total']?>)</label></label>
                <?php echo $this->Form->hidden("Movimientospremio.premio_id",array('value' => $premio['Premio']['id']));?>
                <?php echo $this->Form->hidden("Movimientospremio.user_id",array('value' => $this->Session->read('Auth.User.id')));?>
                <?php echo $this->Form->text("Movimientospremio.ingreso",array('class' => 'input full-width','placeholder' => 'Nombre del premio','required','type' => 'number'));?>
              </p>
            </div>
            <div class="six-columns twelve-columns-mobile">
              <p class="block-label button-height">
                  <label for="block-label-1" class="label">&nbsp;</label>
                  <button class="button green-gradient glossy full-width" type="submit">REGISTRAR</button>
              </p>
            </div>
        </div>
        <?php echo $this->Form->end();?>
        <table class="simple-table responsive-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimientos as $mo): ?>
                <tr>
                    <td><?php echo $mo['Movimientospremio']['created'];?></td>
                    <td><?php echo $mo['Movimientospremio']['ingreso'];?></td>
                    <td>
                      <?php echo $this->Html->link("Quitar",array('action' => 'cancela_ent_pre',$mo['Movimientospremio']['id']),array('class' => 'button red-gradient glossy','confirm' => 'Esta seguro de eliminar??'));?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>	

<?php echo $this->element('sidebar/distribuidor'); ?>
