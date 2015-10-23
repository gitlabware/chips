<div class="centered">
<div class="grid-1">
<div class="title-grid"><span>ventas del dia reporte por 149</span></div>
<div class="content-gird">
   <div id="imprimir">
      <table>
         <thead>
           <th>Distribuidor</th>
           <td><?php echo $distribuidor; ?></td>
           <th>fecha</th>
           <td><?php echo $hoy; ?></td>
         </thead>
      </table>
      <div>
      &nbsp;
      </div>   
      <div>
      <?php if (!empty($clientes)): ?>
      <table>
                  <thead>
                    <tr>
                       <th rowspan="2">149</th>
                       <th rowspan="2">Nombre cliente</th>
                       <th rowspan="2">Producto</th>
                       <th rowspan="2">Cantidad</th>
                       <th rowspan="2">escala</th>
                       <th rowspan="2">precio</th>
                       <th rowspan="2">Bs</th>
                       <th colspan="2">Observacion</th>
                       <th colspan="3">Recargas</th>
                    </tr>
                    <tr>
                       <th>Tipo</th>
                       <th>Descripcion</th>
                       <th>Numero</th>
                       <th>Monto</th>
                       <th>Porcentaje</th>
                    </tr>
                  </thead>
                  <tbody>
          <?php $totalventa=0; $totalrecargas=0; $totalparcial=0;?>
          <?php foreach ($clientes as $id): ?>                    
                     <tr>
                      <!--impresion de las ventas-->
                        <td><?php echo $id['Cliente']['num_registro']; ?></td>
                        <td><?php echo $id['Cliente']['nombre'];?></td>
                        <?php $a = 0; ?>
                        <td colspan="5">
                        <table>
                        <?php foreach ($ventas as $v): ?>
                           <?php $totalparcial =0;?>
                           <?php if ($v['Ventaa']['cliente_id'] == $id['Listacliente']['cliente_id']): ?>
                           <?php $totalparcial += $v['Ventaa']['precio'] * $v['Ventaa']['cantidad'];?>
                           <?php $totalventa += $totalparcial;?>
                           <tr>
                             <td><?php echo $v['Producto']['nombre']; ?></td>
                             <td><?php echo $v['Ventaa']['cantidad']; ?></td>
                             <td><?php echo $v['Ventaa']['escala']; ?></td>
                             <td><?php echo $v['Ventaa']['precio']; ?></td>
                             <td><?php echo $totalparcial;?></td>
                             <?php $a =1;?>
                           </tr>
                          <?php endif;?>
                       <?php endforeach; ?>
                          
                       <?php if($a == 0):?>
                          <tr>
                           <td colspan="6">no hubo venta</td>
                          </tr>
                       <?php endif;?>
                        </table>
                     
                        </td>
                        <td colspan="2">
                           <table>
                              <?php if(!empty($obs)):
                                $a=0;
                              ?>
                                 <?php foreach($obs as $ob):?>
                                 <?php if($ob['Detalleobservacione']['cliente_id'] == $id['Listacliente']['cliente_id']):?>
                                  <tr>
                                     <td><?php echo $ob['Tipoobservacione']['nombre'];?></td>
                                     <td><?php echo $ob['Detalleobservacione']['descripcion'];?></td>
                                  </tr>
                                  <?php $a=1;?>
                                  <?php endif;?>
                                 <?php endforeach;?>
                                 <?php if($a == 0):?>
                                    <tr>
                                       <td colspan="2">No hay observaciones</td>
                                    </tr>
                                 <?php endif;?>
                              <?php else:?>
                                <tr>
                                   <td colspan="2">No hay observaciones</td>
                                </tr>
                              <?php endif;?>
                           </table>
                        </td>
                        <td colspan="3">
                           <table>
                              <?php if(!empty($recargas)):?>
                                 <?php
                                 $a=0;
                                 foreach($recargas as $re):
                                  if($re['recargas']['cliente_id'] == $id['Listacliente']['cliente_id']):
                                  $totalrecargas += $re['recargas']['montobs'];
                                 ?>
                                 <tr>
                                    <td><?php echo $re['recargas']['num_abonado'];?></td>
                                    <td><?php echo $re['recargas']['montobs'];?></td>
                                    <td><?php echo $re['recargas']['porcentaje'];?></td>
                                 </tr>
                                 <?php $a=1;?>
                                 <?php endif;?>
                                 <?php endforeach;?>
                                 <?php if($a == 0):?>
                                    <tr>
                                      <td colspan="3">sin recargas</td>
                                    </tr>
                                 <?php endif;?>
                              <?php else:?>
                                 <tr>
                                    <td colspan="3">sin recargas</td>
                                 </tr>
                              <?php endif;?>
                           </table>
                        </td>
                     </tr>
                  
              
          <?php endforeach; ?>
          <table>
             <tr>
                <th class="totals">Total venta de hoy: </th>
                <td class="total"><?php echo $totalventa;?></td>
             </tr>
             <tr>
                <th class="totals">Total recargas de hoy: </th>
                <td class="total"><?php echo $totalrecargas;?></td>
             </tr>
          </table>
          </tbody>
          </table>
      <?php endif; ?>
      </div><!--fin div imprimir-->
   <div class="grid-buttons">
   </div>
</div><!--fin div contenedor -->
</div>
</div>