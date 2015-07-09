<?php App::uses('CakeNumber', 'Utility'); ?>
<!DOCTYPE html>
<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>MOVIMIENTOS RECARGAS <span style="font-size: 19px;color: #01ab01;">TOTAL: <?php echo $this->requestAction(array('action' => 'get_total'));?></span></h1>
    </hgroup>

    <div class="with-padding">        

        <div class="columns">

            <div class="new-row three-columns">
                <?php
                echo $this->Form->create('Recargado', array('action' => 'nuevo', 'id' => 'formID'));
                ?>
                <?php echo $this->Form->hidden('Recargado.user_id', array('value' => $this->Session->read('Auth.User.id'))); ?>

                <h3 class="thin underline">Recargas </h3>
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
                    <?php echo $this->Form->text('salida', array('class' => 'input validate[required, custom[integer]]', 'id' => 'monto')); ?>
                </p>
                <p id="montoporcentaje">
                </p>
                <div class="new-row twelve-columns">

                    <button type="submit" class="button green-gradient full-width" onClick="javascript:verificar()">                        
                        RECARGAR
                    </button>                                      

                </div>
                </form>
            </div>
            <div class="nine-columns twelve-columns-tablet">

                <h3 class="thin underline">Detalle</h3>
                <table class="table responsive-table">
                    <thead>
                        <tr>
                            <th scope="col" width="5">Id.</th>
                            <th scope="col" width="18%" class="align-center hide-on-mobile">Distribuidor</th>
                            <th scope="col" width="16%" class="align-center hide-on-mobile">Celular</th>                            
                            <th scope="col" width="10" class="align-center hide-on-mobile">Ing.</th>
                            <th scope="col" width="12%" class="align-center hide-on-mobile">Monto</th>
                            <th scope="col" width="8%" class="align-center hide-on-mobile">%</th>
                            <th scope="col" width="10" class="align-center hide-on-mobile">Rec</th>
                            <!--<th scope="col" width="10" class="align-center hide-on-mobile">Total</th>-->
                            <th scope="col" width="8%" class="align-center">Eliminar</th>
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
                              <td><?php echo $rec['Recargado']['id']; ?></td>
                              <td><?php echo $rec['Persona']['nombre']; ?></td>
                              <td><?php echo $rec['Recargado']['num_celular']; ?></td>                                
                              <td><?php echo $this->Number->currency($rec['Recargado']['entrada'], ''); ?></td>
                              <td><?php echo $this->Number->currency($rec['Recargado']['salida'], ''); ?></td>
                              <td><?php echo $rec['Porcentaje']['nombre']; ?></td>
                              <td><?php echo $this->Number->currency($rec['Recargado']['monto'], ''); ?> </td>
                              <!--<td><?php //echo $this->Number->currency($rec['Recargado']['total'], ''); ?></td>-->
                              <td scope="col" width="8%" class="align-center">
                                  <?php echo $this->Html->link("", array('action' => 'elimina', $rec['Recargado']['id']), array('class' => 'button red-gradient compact icon-cross-round','confirm' => 'Esta seguro de eliminar el registro de recarga??')) ?>
                              </td>
                          </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

            <div class="nine-columns twelve-columns-tablet">
                <table class="table responsive-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Porcentaje</th>
                            <th>Efectivo</th>
                            <th>Recargado</th>       
                        </tr>
                    </thead>          

                    <tbody>
                        <?php
                        $sumEfectivo = 0;
                        $sumRecargado = 0;
                        ?>
                        <?php foreach ($movimientosHoy2 as $rec): ?>
                          <tr>
                              <td>Al <b><?php echo $rec['Porcentaje']['nombre'] ?></b> %</td>
                              <td><?php echo $rec[0]['recargados'] ?></td>
                              <td><?php echo $rec[0]['rec_porcentaje'] ?></td>
                              <?php
                              $sumEfectivo += $rec[0]['recargados'];
                              $sumRecargado += $rec[0]['rec_porcentaje'];
                              ?>
                          </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>SALDO TOTAL</td>
                            <td>
                                <?php echo $sumEfectivo; ?>
                            </td>
                            <td><?php echo $sumRecargado; ?></td>
                        </tr>
                    </tbody>
                </table> 
            </div>

            <div class="nine-columns twelve-columns-tablet">
                <table class="table responsive-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Distribuidor</th>
                            <th>Efectivo</th>
                            <th>Recargado</th>       
                        </tr>
                    </thead>          

                    <tbody>
                        <?php
                        $sumEfectivo = 0;
                        $sumRecargado = 0;
                        ?>
                        <?php foreach ($movimientosDistribuidor as $md): ?>
                          <tr>
                              <td><b><?php echo $md['Persona']['nombre'] ?></b></td>
                              <td><?php echo $md[0]['recargados'] ?></td>
                              <td><?php echo $md[0]['rec_porcentaje'] ?></td>
                              <?php
                              $sumEfectivo += $md[0]['recargados'];
                              $sumRecargado += $md[0]['rec_porcentaje'];
                              ?>
                          </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>SALDO TOTAL</td>
                            <td>
                                <?php echo $sumEfectivo; ?>
                            </td>
                            <td><?php echo $sumRecargado; ?></td>
                        </tr>
                    </tbody>
                </table> 
            </div>

        </div>

    </div>

</section>
<?php if ($this->Session->read('Auth.User.Group.name') == 'Administradores'): ?>
  <?php echo $this->element('sidebar/administrador'); ?>
<?php elseif ($this->Session->read('Auth.User.Group.name') == 'Recargas'): ?>
  <?php echo $this->element('sidebar/recargas'); ?>
<?php endif; ?>


<script>
  $(document).ready(function () {

      var tabla = $('#orden1');
      tabla.dataTable({
          "order": [[0, "desc"]],
          "oLanguage": {
              "sUrl": "https://cdn.datatables.net/plug-ins/1.10.7/i18n/Spanish.json"
          },
          'fnInitComplete': function (oSettings)
          {
              // Style length select
              tabla.closest('.dataTables_wrapper').find('.dataTables_length select').addClass('select blue-gradient glossy').styleSelect();
              tableStyled = true;
          }
      });

      $("#formID").validationEngine();

      $("#monto").keyup(function () {
          var porcentaje = $('#porcentaje :selected').text();
          var numpor = parseFloat(porcentaje);
          var monto = $('#monto').val();
          var montonum = parseFloat(monto);
          var monto_total = montonum + (montonum * (numpor / 100));
          $('#montoporcentaje').html('<h3>' + monto_total + '</h3>');
      });


  });
</script>
