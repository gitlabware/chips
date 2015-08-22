<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Minieventos</h1>
    </hgroup>

    <div class="with-padding">                   
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($minieventos as $mi): ?>
                  <tr>
                      <td><?php echo $mi['Minievento']['fecha']; ?></td>
                      <td><?php echo $mi['Minievento']['direccion']; ?></td>
                      <td>
                          <?php if ($this->Session->read('Auth.User.group_id') == 1): ?>
                            <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minievento', $mi['Minievento']['id'])); ?>', 'Minievento')" class="button orange-gradient glossy">Editar</a>
                            <?php echo $this->Html->link("Excel", ['action' => 'genera_excel', $mi['Minievento']['id']], ['class' => 'button green-gradient glossy']); ?>
                          <?php else: ?>
                            <?php echo $this->Html->link("Ventas", array('action' => 'ventas_minievento', $mi['Minievento']['id']), ['class' => 'button green-gradient glossy']); ?>
                          <?php endif; ?>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php
if ($this->Session->read('Auth.User.group_id') == 1) {
  echo $this->element('sidebar/administrador');
} else {
  echo $this->element('sidebar/distribuidor');
}
?>