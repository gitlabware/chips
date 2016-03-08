<section role="main" id="main">
    <hgroup id="main-title" class="thin">
        <h1>Listado de Colores</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col">id</th>
                    <th scope="col" >nombre</th>

                    <th scope="col" >Actions</th>
                </tr>
            </thead>          

            <tbody>
                <?php foreach ($colores as $p): ?>
                    <tr>                      
                        <td><?php echo $p['Colore']['id']; ?></td>
                        <td><?php echo $p['Colore']['nombre']; ?></td>

                        <td scope="col" width="20%" class="align-center">
                            <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('action' => 'color', $p['Colore']['id'])); ?>','Formulario Color',200)" class="button orange-gradient compact icon-pencil">Editar</a>
                            
                            <a href="<?php echo $this->Html->url(array('action' => 'eliminar', $p['Colore']['id'])); ?>" onclick="if (confirm( & quot; Desea eliminar realmente?? & quot; )) {
                                  return true;
                                }
                                return false;" class="button red-gradient compact icon-cross-round">Eliminar</a>
                        </td>  
                    </tr>               
                <?php endforeach; ?>
            </tbody>
        </table> 
        <td><?php //echo $this->html->link('insertar', array('action' => 'insertar'), array('class' => 'button green-gradient glossy')); ?> </td>
    </div>
</section>	

<?php echo $this->element('sidebar/administrador');?>