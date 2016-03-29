<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            Distribuidor
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
            <li><a href="<?php echo $this->Html->url(array('controller' => 'ventasdistribuidor', 'action' => 'mismetas')) ?>" title="INICIO"><span class="icon-gear"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'edit_distribuidor', $this->Session->read('Auth.User.id'))) ?>" title="Mis Datos"><span class="icon-user"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'salir')) ?>" title="Salir"><span class="icon-extract"></span></a></li>     
        </ul>
        <section class="navigable">
            <ul class="big-menu">
                <?php $id = $this->Session->read("Auth.User.id") ?>
                <!--<li class="with-right-arrow">
                    <span>Reportes</span>
                    <ul class="big-menu">
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'reporte_detallado_precio')); ?>">Reporte x precios</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'reporte_cliente')); ?>">Reporte x Clientes</a>
                        </li>
                    </ul>
                </li>
                <li class="with-right-arrow">
                    <span>Clientes</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'clientes')); ?>">Listado de Clientes</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'cliente')); ?>">Nuevo Cliente</a></li>                                                                        

                    </ul>
                </li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'entregados')); ?>">Chips entregados</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'asignados')); ?>">Mis chips</a></li>
                <li class="with-right-arrow">
                    <span>Pedidos</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'pedido')); ?>">Nuevo Pedido</a></li>

                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'lista_pedidos')); ?>">Listado de Pedidos</a></li>                                                                        

                    </ul>
                </li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'ventas')); ?>">Ventas Hoy</a></li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minieventos')); ?>">Listado de Minieventos</a>
                </li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'premios')); ?>">Premios</a></li>-->
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'mismetas')); ?>">Metas</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'clientes')); ?>">Clientes</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Ventasdistribuidor', 'action' => 'entregados')); ?>">Chips entregados</a></li>
            </ul>
        </section>
    </div>

</section>