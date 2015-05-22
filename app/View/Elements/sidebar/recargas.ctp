<?php
App::Import('Model', 'Recarga');
$carga = new Recarga();
$dato = $carga->find('count', array('conditions' => array('Recarga.estado' => 0)));
?>
<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            Recargas
        </header>

        <div id="profile">
            <img src="<?php echo $this->webroot; ?>/app/webroot/img/user.png" width="64" height="64" alt="User name" class="user-icon">
            Bienvenido
            <span class="name"><?php echo $this->Session->read('Auth.User.Persona.nombre'); ?>
                <b><?php echo $this->Session->read('Auth.User.Persona.ap_paterno'); ?></b>
            </span>
        </div>

        <!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
        <ul id="access" class="children-tooltip">

            <li>
                <a href="<?php echo $this->Html->url(array('action' => 'listarecargas')) ?>" title="Mensajes">
                    <span class="icon-inbox"></span>
                    <span class="count">
                        <div id="cargaNotificaciones"></div>                            
                    </span>
                </a>
                <?php
                echo $this->Ajax->remoteTimer(
                        array(
                            'url' => array('controller' => 'Recargas', 'action' => 'ajaxanunciarecargas'),
                            'update' => 'cargaNotificaciones', 'frequency' => 30
                        )
                );
                ?>
            </li>
            <li><a href="#" title="Calendario"><span class="icon-calendar"></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'salir')) ?>" title="Cerrar Session"><span class="icon-user"></span></a></li>
            <li class="disabled"><span class="icon-gear"></span></li>

        </ul>
        <section class="navigable">            
            <ul class="big-menu">    
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Recargas', 'action' => 'listarecargas')); ?>">Recargas diario</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Recargas', 'action' => 'todas')); ?>">Lista Recargas</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Recargas', 'action' => 'estadorecargas')); ?>">Recarga</a></li>
            </ul>
        </section>


    </div>

</section>