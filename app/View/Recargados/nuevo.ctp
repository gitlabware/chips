<!DOCTYPE html>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>MOVIMIENTOS RECARGAS</h1>
    </hgroup>

    <div class="with-padding">        

        <div class="columns">

            <div class="new-row three-columns">
                <?php
          echo $this->Form->create('Recargado', array('action' => 'nuevo', 'id' => 'formID'));
        ?>

                <h3 class="thin underline">Recargas</h3>
                <p class="button-height">
                    <input type="checkbox" name="data[Recargado][tipo]" id="switch-custom-3" class="switch wider green-active mid-margin-right" value="1" checked data-text-on="RECARGA" data-text-off="CARGA">                    
                </p>                
                <p class="block-label button-height">
                    <label for="validation-select" class="label">Distribuidor<small>(Requerido)</small></label>
                    <?php echo $this->Form->select('user_id', $distribuidor, array('class' => 'select full-width')); ?>
                </p>

                <p class="block-label button-height">
                    <label for="small-label-2" class="label"># Celular</label>
                    <?php echo $this->Form->text('num_celular', array('class' => 'input full-width')); ?>
                </p> 

                <p class="block-label button-height">
                    <label for="selct1" class="label">Porcentaje</label>
                    <?php echo $this->Form->select('porcentaje_id', $porcentaje, array('class' => 'select full-width', 'id' => 'porcentaje')); ?>
                </p>

                <p class="block-label button-height">
                    <label for="small-label-3" class="label">Monto</label>
                    <?php echo $this->Form->text('salida', array('class' => 'input validate[required, custom[integer]]', 'value' => 0, 'id' => 'monto')); ?>
                </p>
                <p id="montoporcentaje">
                </p>
                <div class="new-row six-columns">

                    <button type="submit" class="button glossy mid-margin-right" onClick="javascript:verificar()">
                        <span class="button-icon"><span class="icon-tick"></span></span>
                        Guardar
                    </button>

                    <button type="submit" class="button glossy">
                        <span class="button-icon red-gradient"><span class="icon-cross-round"></span></span>
                        Cancelar
                    </button>

                </div>
            </form>
            </div>
            <div class="nine-columns twelve-columns-tablet">

                <h3 class="thin underline">Detalle</h3>
                <table class="table responsive-table" id="sorting-advanced">
                    <thead>
                        <tr>
                            <th scope="col" width="10" class="align-center hide-on-mobile">Distribuidor</th>
                            <th scope="col" width="15%" class="align-center hide-on-mobile">Celular</th>
                            <th scope="col" width="8%" class="align-center hide-on-mobile">%</th>
                            <th scope="col" width="12%" class="align-center hide-on-mobile">Monto</th>
                            <th scope="col" width="10" class="align-center hide-on-mobile">Rec. %</th>
                            <th scope="col" width="10" class="align-center hide-on-mobile">Total</th>
                            <th scope="col" width="10" class="align-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimientosHoy as $rec): ?>
                          <?php
                          $salida = $rec['Recarga']['salida'];
                          if ($salida != 0) {
                            $color = '#f00';
                          } else {
                            $color = '#000';
                          }
                          ?>
                          <tr>
                              <td><?php echo $rec['Persona']['nombre']; ?></td>
                              <td><?php echo $rec['Recarga']['num_celular']; ?></td>
                              <td><?php echo $rec['Porcentaje']['nombre']; ?></td>
                              <td><?php echo $rec['Recarga']['salida'] ?></td>
                              <td><?php echo $rec['Recarga']['monto'] ?></td>
                              <td><?php echo $rec['Recarga']['total'] ?></td>
                              <td  scope="col" width="20%" class="align-center">
                                  <?php if ($ultimo['Recarga']['id'] == $rec['Recarga']['id']): ?>

                                    <a href="<?php echo $this->Html->url(array('action' => 'delete', $rec['Recarga']['id'])); ?>" onclick="if (confirm( & quot; Desea eliminar realmente?? & quot; )) {
                                              return true;
                                          }
                                          return false;" class="button red-gradient compact icon-cross-round">Eliminar</a>

                                  <?php endif; ?>
                              </td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>

    </div>

</section>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Almaceneros'): ?>
  <?php echo $this->element('sidebar/almacenero'); ?>
<?php endif; ?>


<script>
  $(document).ready(function () {

      $("#formID").validationEngine();

      $("#monto").keyup(function () {
          var porcentaje = $('#porcentaje :selected').text();
          var numpor = parseFloat(porcentaje);
          var monto = $('#monto').val();
          var montonum = parseFloat(monto);
          var monto_total = montonum + (montonum * (numpor / 100));
          $('#montoporcentaje').html(monto_total);
      });
  });
</script>