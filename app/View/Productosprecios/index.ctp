<section role="main" id="main">

    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>

    <hgroup id="main-title" class="thin">
        <h1>Listado de Precios</h1>
    </hgroup>

    <div class="with-padding">                   

        <table class="table responsive-table" id="sorting-advanced">

            <thead>
                <tr>                      
                    <th scope="col" width="30%" class="align-center hide-on-mobile">Nombre</th>
                    <th scope="col" width="20%" class="align-center hide-on-mobile">Escala</th>
                    <th scope="col" width="20%" class="align-center hide-on-mobile">Precio</th>
                    <th scope="col" width="10" class="align-center ">Acciones</th>
                </tr>

            </thead>          

            <tbody>
                <?php foreach ($productosprecios as $pe): ?>
                    <tr> 


                        <td><?php echo $pe['Producto']['nombre']; ?></td>                 
                        <td><?php echo $pe['Productosprecio']['escala']; ?></td>
                        <td><?php echo $pe['Productosprecio']['precio'] ?></td>
                        <td scope="col" width="20%" class="align-center">
                            <a href="<?php echo $this->html->url(array('action' => 'editar', $pe['Productosprecio']['id'])); ?>" class="button orange-gradient compact icon-pencil">Editar</a>
                            <a href="<?php echo $this->Html->url(array('action' => 'delete', $pe['Productosprecio']['id'])); ?>" onclick="if (confirm( & quot; Desea eliminar realmente?? & quot; )) {
                                  return true;
                                }
                                return false;" class="button red-gradient compact icon-cross-round">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>       
    </div>
</section>	

<!-- Sidebar/drop-down menu -->
<?php echo $this->element('sidebar/almacenero'); ?>
<!-- End sidebar/drop-down menu --> 

