<!-- glDatePicker -->
<link rel="stylesheet" href="<?php echo $this->webroot; ?>js/libs/glDatePicker/developr.fixed.css?v=1">
<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Caja chica
            </h1>
    </hgroup>

    <div class="with-padding">       
        <div class="columns">
            <div class="four-columns">

                <fieldset class="fieldset">
                    <?php echo $this->Form->create('Cajachica', array('id' => 'form-caja')); ?>
                    <legend class="legend">Registro caja</legend>
                    <input name="data[Cajachica][tipo]" id="UserGender_" value="" type="hidden" class="validate[required]"/>
                    <p class="inline-label">
                        <input type="radio" name="data[Cajachica][tipo]" value="Ingreso" class="radio mid-margin-left validate[required]"> <label class="label">Tipo Ingreso</label>
                    </p>
                    <p class="inline-label">
                        <input type="radio" name="data[Cajachica][tipo]" value="Gasto" class="radio mid-margin-left"> <label class="label">Tipo Gasto</label>
                    </p>
                    <p class="inline-label detalle" id="pdetalle">
                        <label class="label version-new" onclick="$('.detalle').toggle(400);
                              $('#input_detalle').val('');
                              $('#input_detalle').addClass('validate[required]');
                              $('#select_detalle').removeClass('validate[required]');">Nuevo detalle</label>
                               <?php echo $this->Form->select("cajadetalle_id", $detalles, array('class' => 'select expandable-list anthracite-gradient glossy full-width validate[required]', 'empty' => 'Detalle', 'id' => 'select_detalle')) ?> 
                    </p>
                    <p class="inline-label detalle" id="pnuevodet" style="display: none;">
                        <label class="label version-new" onclick="$('.detalle').toggle(400);
                              $('#select_detalle').val('');
                              $('#select_detalle').addClass('validate[required]');
                              $('#input_detalle').removeClass('validate[required]');">Select. Detalle</label>
                               <?php echo $this->Form->text('Cajadetalle.nombre', array('class' => 'input full-width', 'id' => 'input_detalle', 'placeholder' => 'Detalle')); ?>
                    </p>
                    <p class="inline-label">
                        <label class="label">Banco</label>
                        <?php echo $this->Form->select('banco_id',$bancos, array('class' => 'select expandable-list anthracite-gradient glossy full-width validate[required]', 'empty' => 'Seleccione Banco')); ?>
                    </p>
                    <p class="inline-label">
                        <label class="label">Monto</label>
                        <?php echo $this->Form->text('monto', array('class' => 'input full-width validate[required]', 'placeholder' => 'Monto', 'type' => 'numer', 'step' => 'any')); ?>
                    </p>
                    <p class="inline-label">
                        <label class="label">Nota</label>
                        <?php echo $this->Form->text('nota', array('class' => 'input full-width', 'placeholder' => 'Nota')); ?>
                    </p>
                    <p class="inline-label">
                        <label class="label">Fecha</label>
                        <?php echo $this->Form->text('fecha', array('class' => 'input full-width datepicker validate[required]', 'value' => date('Y-m-d'))); ?>
                    </p>
                    <p class="inline-label">
                        <label class="label">Observacion</label>
                        <?php echo $this->Form->textarea('observacion', array('class' => 'input full-width', 'placeholder' => 'Observacion')); ?> 
                    </p>

                    <p class="button-height">
                        <button type="submit" class="button green-gradient glossy full-width">REGISTRAR</button>
                    </p>
                    <?php echo $this->Form->hidden("sucursal_id",array('value' => $this->Session->read('Auth.User.sucursal_id')))?>
                    <?php echo $this->Form->end(); ?>
                </fieldset>

            </div>
            <div class="eight-columns">

                <fieldset class="fieldset">
                    <?php echo $this->Form->create('Cajachica') ?>
                    <p class="button-height">
                    <div class="columns">
                        <label class="label two-columns">De</label>
                        <?php echo $this->Form->text('Dato.fecha_ini', array('class' => 'input two-columns datepicker')); ?>
                        <label class="label two-columns">hasta</label>
                        <?php echo $this->Form->text('Dato.fecha_fin', array('class' => 'input two-columns datepicker')); ?>
                        <?php echo $this->Form->select('Dato.banco_id',$bancos, array('class' => 'select three-columns')); ?>
                        <button type="submit" class="button black-gradient two-columns">GENERAR</button>
                    </div>
                    </p>
                    <?php echo $this->Form->end(); ?>
                </fieldset>

                <?php if (!empty($cajachica_ing)): ?>
                  <div class="block margin-bottom">
                      <h3 class="block-title green-gradient glossy">Ingresos</h3>
                      <div class="with-padding">
                          <table  class="simple-table responsive-table">
                              <thead>
                                  <tr>
                                      <th>Fecha</th>
                                      <th>Nota</th>
                                      <th>Detalle</th>
                                      <th>Monto</th>
                                      <th>Accion</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $total = 0.00; ?>
                                  <?php foreach ($cajachica_ing as $ca): ?>
                                    <?php $total = $total + $ca['Cajachica']['monto']; ?>
                                    <tr>
                                        <td><?php echo $ca['Cajachica']['fecha'] ?></td>
                                        <td><?php echo $ca['Cajachica']['nota'] ?></td>
                                        <td><?php echo $ca['Cajadetalle']['nombre'] ?></td>
                                        <td><?php echo $ca['Cajachica']['monto'] ?></td>
                                        <td>
                                            <?php echo $this->Html->link("ELiminar", array('action' => 'elimina', $ca['Cajachica']['id'], 'Ingreso'), array('confirm' => 'Esta seguro de eliminar??', 'class' => 'button red-gradient glossy')) ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; ?>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                      <td><b>TOTAL</b></td>
                                      <td><?php echo $total; ?></td>
                                      <td></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                <?php endif; ?>
                <?php if (!empty($cajachica_gas)): ?>
                  <div class="block margin-bottom">
                      <h3 class="block-title blue-gradient glossy">Gastos</h3>
                      <div class="with-padding">
                          <table  class="simple-table responsive-table">
                              <thead>
                                  <tr>
                                      <th>Fecha</th>
                                      <th>Nota</th>
                                      <th>Detalle</th>
                                      <th>Monto</th>
                                      <th>Accion</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $total = 0.00; ?>
                                  <?php foreach ($cajachica_gas as $ca): ?>
                                    <?php $total = $total + $ca['Cajachica']['monto']; ?>
                                    <tr>
                                        <td><?php echo $ca['Cajachica']['fecha'] ?></td>
                                        <td><?php echo $ca['Cajachica']['nota'] ?></td>
                                        <td><?php echo $ca['Cajadetalle']['nombre'] ?></td>
                                        <td><?php echo $ca['Cajachica']['monto'] ?></td>
                                        <td>
                                            <?php echo $this->Html->link("ELiminar", array('action' => 'elimina', $ca['Cajachica']['id'], 'Gasto'), array('confirm' => 'Esta seguro de eliminar??', 'class' => 'button red-gradient glossy')) ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; ?>
                                  <tr>
                                      <td></td>
                                      <td></td>
                                      <td><b>TOTAL</b></td>
                                      <td><?php echo $total; ?></td>
                                      <td></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</section>	

<!-- Sidebar/drop-down menu -->

<?php echo $this->element('sidebar/administrador'); ?>
<!-- End sidebar/drop-down menu --> 

<!-- End sidebar/drop-down menu --> 
<script>
  $(document).ready(function () {
      $("#form-caja").validationEngine();
  });
</script>

<?php
echo $this->Html->script(array(
  'libs/glDatePicker/glDatePicker.min.js?v=1',
  'ini_lg_datepicker.js'
  ), array('block' => 'js_add'));
?>