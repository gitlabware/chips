<section role="main" id="main">
    <noscript class="message black-gradient simpler">Your browser does not support JavaScript! Some features won't work as expected...</noscript>
    <hgroup id="main-title" class="thin">
        <h1>Listado Categorias Productos</h1>
    </hgroup>
    <div class="with-padding">
        <table class="table responsive-table" id="sorting-advanced">
            <thead>
                <tr>
                    <th scope="col" width="5%" class="align-center hide-on-mobile">No.</th>
                    <th scope="col" width="30%" class="align-center hide-on-mobile">Nombre</th>
                    <th scope="col" width="40%" class="align-center hide-on-mobile">Descripcion</th>
                    <th scope="col" width="10" class="align-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($tiposproductos as $tip): ?>
                    <tr>
                        <td><?php echo $i;
                    $i++; ?></td>
                        <td><?php echo $tip['Tiposproducto']['nombre']; ?></td>
                        <td><?php echo $tip['Tiposproducto']['desc'] ?></td>
                        <td  scope="col" width="20%" class="align-center">
                            <a href="<?php echo $this->Html->url(array('action' => 'edit', $tip['Tiposproducto']['id'])); ?>" class="button orange-gradient compact icon-pencil">Editar</a>
                            
                            <a href="<?php echo $this->Html->url(array('action' => 'delete', $tip['Tiposproducto']['id'])); ?>" onclick="if (confirm( & quot; Desea eliminar realmente?? & quot; )) {
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
<?php echo $this->element('sidebar/administrador'); ?>

