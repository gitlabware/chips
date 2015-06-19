<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Listado de Premios</h1>
    </hgroup>
    <div class="with-padding"> 
        <?php echo $this->Form->create('Impulsadore',array('action' => 'registra_n_premio'));?>
        <div class="columns">
            <div class="four-columns twelve-columns-mobile">
              <p class="block-label button-height">
                <label for="block-label-1" class="label">Nuevo Premio</label>
                <?php echo $this->Form->text("Premio.nombre",array('class' => 'input full-width','placeholder' => 'Nombre del premio','required'));?>
              </p>
            </div>
            <div class="four-columns twelve-columns-mobile">
              <p class="block-label button-height">
                <label for="block-label-1" class="label">Cantidad</label>
                <?php echo $this->Form->text("Premio.total",array('class' => 'input full-width','placeholder' => 'Cantidad a ingresar','required', 'type' => 'number'));?>
              </p>
            </div>
            <div class="four-columns twelve-columns-mobile">
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
                    <th>Premio</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($premios as $pre): ?>
                <tr>
                    <td><?php echo $pre['Premio']['nombre'];?></td>
                    <td><?php echo $pre['Premio']['total'];?></td>
                    <td>
                      <?php echo $this->Html->link("Entregas",array('action' => 'movimientospremios',$pre['Premio']['id']));?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>	

<?php echo $this->element('sidebar/distribuidor'); ?>
