    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Detalle de <?php echo $cantidades[0]['Insumo']['nombre'] ?></h4>
    </div>
    <div class="modal-body">
        <p>Muestra las cantidades del insumo distribuidos por almacen</p>
        <div class="well well-nice">
            <table class="table table-hover">
                <caption>
                Detalle del insumo <span><?php echo $cantidades['0']['Insumo']['nombre'] ?></span>
                </caption>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Almacen</th>
                        <th class="hidden-phone" scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                <?php $i=1; ?>
                <?php foreach ($cantidades as $c): ?>                       
                   <tr>
                      <td>
                      <?php echo $i; $i++;?>                                    
                      </td>
                      <td><?php echo $c['Lugare']['nombre']; ?></td>   
                      <td>
                      <?php echo $c['Movimiento']['totalp'] ?>
                      </td>
                   </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-boo">Close</button>
        <!--<button type="button" class="btn btn-green">Save changes</button>-->
    </div>
