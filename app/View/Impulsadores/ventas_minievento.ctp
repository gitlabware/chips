<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Minievento</h1>
    </hgroup>

    <div class="with-padding">
        <div class="columns">
            <div class="twelve-columns" style="font-size: 18px;">
                <b>Direccion: </b><?php echo $minievento['Minievento']['direccion']; ?> 
                <b>Fecha: </b><?php echo $minievento['Minievento']['fecha']; ?> 
            </div>
        </div>
        <?php echo $this->Form->create('Impulsadore', array('action' => 'registra_venta')); ?>
        <div class="columns">
            <div class="four-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Numero</label>
                    <?php echo $this->Form->hidden('Ventasimpulsadore.minievento_id', array('value' => $minievento['Minievento']['id'])); ?>
                    <?php echo $this->Form->text('Ventasimpulsadore.numero', array('class' => 'input full-width', 'required', 'type' => 'number')); ?>
                </p>
            </div>
            <div class="four-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Nombre cliente</label>
                    <?php echo $this->Form->text('Ventasimpulsadore.nombre_cliente', array('class' => 'input full-width', 'required')); ?>
                </p>
            </div>
            <div class="four-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Monto</label>
                    <?php echo $this->Form->select('Ventasimpulsadore.monto', $precios,array('class' => 'select full-width', 'required')); ?>
                </p>
            </div>
            <div class="new-row four-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Premio</label>
                    <?php echo $this->Form->select('Ventasimpulsadore.premio_id',$premios, array('class' => 'select full-width')); ?>
                </p>
            </div>
            <div class="four-columns new-row-mobile twelve-columns-mobile">
                <p class="block-label button-height">
                    <label for="block-label-1" class="label">Telf. Referencia</label>
                    <?php echo $this->Form->text('Ventasimpulsadore.tel_referencia', array('class' => 'input full-width')); ?>
                </p>
            </div>
            <div class="two-columns new-row-mobile six-columns-mobile">
                <p class="block-label button-height" align="center">
                    <label for="block-label-1" class="label">Movil</label>
                    <?php echo $this->Form->checkbox('Ventasimpulsadore.movil') ?>
                </p>
            </div>
            <div class="two-columns six-columns-mobile">
                <p class="block-label button-height" align="center">
                    <label for="block-label-1" class="label">4G</label>
                    <?php echo $this->Form->checkbox('Ventasimpulsadore.4g') ?>
                </p>
            </div>
            <div class="new-row twelve-columns">
                <p class="block-label button-height" align="center">
                    <button type="submit" class="button green-gradient glossy huge full-width">REGISTRAR</button>
                </p>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
        <br>
        
        <table class="table responsive-table">
            <thead>
                <tr>
                    <th class="hide-on-mobile">#</th>
                    <th>Numero</th>
                    <th class="hide-on-mobile">Movil</th>
                    <th class="hide-on-mobile">4G</th>
                    <th>Nombre Cliente</th>
                    <th>Monto</th>
                    <th class="hide-on-mobile">Premio</th>
                    <th class="hide-on-mobile">Telf. Refer.</th>
                    <th>Quitar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $key => $ve): ?>
                  <tr>
                      <td class="hide-on-mobile"><?php echo $key + 1; ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['numero'] ?></td>
                      <td class="hide-on-mobile"><?php
                          if ($ve['Ventasimpulsadore']['movil']) {
                            echo 'X';
                          }
                          ?></td>
                      <td class="hide-on-mobile"><?php
                          if ($ve['Ventasimpulsadore']['4g']) {
                            echo 'X';
                          }
                          ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['nombre_cliente'] ?></td>
                      <td><?php echo $ve['Ventasimpulsadore']['monto'] ?></td>
                      <td class="hide-on-mobile"><?php echo $ve['Ventasimpulsadore']['premio'] ?></td>
                      <td class="hide-on-mobile"><?php echo $ve['Ventasimpulsadore']['tel_referencia'] ?></td>
                      <td>
                          <?php echo $this->Html->link("",array('action' => 'quita_venta',$ve['Ventasimpulsadore']['id']),array('class' => 'button red-gradient glossy icon-trash','title' => 'Quitar de venta','confirm' => 'Esta seguro de quitar de la venta???'))?>
                      </td>
                  </tr>
<?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>	
<?php echo $this->element('sidebar/distribuidor'); ?>
