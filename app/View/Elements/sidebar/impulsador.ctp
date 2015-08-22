<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            IMPULSADOR
        </header>
        <div id="profile">
            <img src="<?php echo $this->webroot; ?>img/user.png" width="64" height="64" alt="User name" class="user-icon">
            Bienvenido

            <span class="name"><?php echo $this->Session->read('Auth.User.Persona.nombre'); ?>
                <b><?php echo $this->Session->read('Auth.User.Persona.ap_paterno'); ?></b>
            </span>
        </div>
        <!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
        <ul id="access" class="children-tooltip">
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minieventos')) ?>" title="Minieventos"><span class="icon-gear"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'salir')) ?>" title="Cerrar Session"><span class="icon-user"></span></a></li>
        </ul>

        <section class="navigable">            
            <ul class="big-menu">    
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'cambiopass', $this->Session->read('Auth.User.id'))); ?>">Cambiar Password</a></li>

                <li class="with-right-arrow">
                    <span>Minievento</span>
                    <ul class="big-menu">
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minieventos')); ?>">Listado de Minieventos</a>
                        </li>
                        <li>
                            <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minievento')); ?>','Minievento')">Nuevo Minievento</a>
                        </li>
                    </ul>
                </li> 

            </ul>
        </section>
    </div>

</section>