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
                  <?php
                  $clase = '';
                  if ($mi['Minievento']['estado'] == 1) {
                    $clase = 'style="background-color: lightgreen;"';
                  }
                  ?>
                  <tr>
                      <td <?php echo $clase; ?>><?php echo $mi['Minievento']['fecha']; ?></td>
                      <td <?php echo $clase; ?>><?php echo $mi['Minievento']['direccion']; ?></td>
                      <td <?php echo $clase; ?>>
                          <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minievento', $mi['Minievento']['id'])); ?>', 'Minievento')" class="button orange-gradient glossy">Editar</a>
                          <?php echo $this->Html->link("Eliminar", array('action' => 'elimina_minievento', $mi['Minievento']['id']), array('class' => 'button red-gradient glossy', 'confirm' => 'Esta seguro de eliminar el Minievento???')) ?>
                      </td>
                  </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php
echo $this->element('sidebar/administrador');
?>