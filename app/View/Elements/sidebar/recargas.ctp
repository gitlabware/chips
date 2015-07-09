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
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'editar', $this->Session->read('Auth.User.id'))) ?>" title="Mis Datos"><span class="icon-user"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'salir')) ?>" title="Salir"><span class="icon-extract"></span></a></li>    
        </ul>
        <section class="navigable">            
            <ul class="big-menu">    
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Recargados', 'action' => 'nuevo')); ?>">Nueva Recarga</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Recargados', 'action' => 'reporte')); ?>">Reporte</a></li>
            </ul>
        </section>
    </div>
</section>