<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            TIENDAS
        </header>
        <div id="profile">
            <img src="<?php echo $this->webroot; ?>img/user.png" width="64" height="64" alt="User name" class="user-icon">
            Bienvenido

            <span class="name"><?php echo $this->Session->read('Auth.User.Persona.nombre'); ?>
                <b><?php echo $this->Session->read('Auth.User.Persona.ap_paterno'); ?></b><br/>
                <small><?php echo $this->Session->read("Auth.User.Sucursal.nombre") ?></small>
            </span>

        </div>
        <!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
        <ul id="access" class="children-tooltip">
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'index')) ?>" title="PANEL VENTAS"><span class="icon-gear"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'salir')) ?>" title="Cerrar Session"><span class="icon-user"></span></a></li>
            <!--<li><a href="<?php //echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'listacabinas')) ?>" title="CARGAS CABINAS"><span class="icon-inbox"></span></span></a></li>-->
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'clientes')) ?>" title="Venta mayor"><span class="icon-calendar"></span></a></li>
        </ul>

        <section class="navigable">            
            <ul class="big-menu">    
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'cambiopass',$this->Session->read('Auth.User.id'))); ?>">Cambiar Password</a></li>
                <!--<li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'registrocabinas')); ?>">Control cabinas</a></li>-->
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'registrardeposito')); ?>">Registrar deposito</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'lista_celulares')); ?>">Venta celulares</a></li>
                <li class="with-right-arrow">
                    <span>Reportes</span>
                    <ul class="big-menu">
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Tiendas','action' => 'reportes_tienda'));?>">Reporte general</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Tiendas','action' => 'reporte_detallado_precio'));?>">Reporte x precios</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Tiendas','action' => 'reporte_cliente'));?>">Reporte x Clientes</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Tiendas','action' => 'reporte_celular'));?>">Reporte Celular</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Tiendas','action' => 'reporte_celular_cliente'));?>">Reporte Celular Clientes</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Tiendas','action' => 'reporte_pagos'));?>">Reporte Celular x pagos</a>
                        </li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Tiendas','action' => 'report_control_ven'));?>">Control ventas equipos</a>
                        </li>
                    </ul>
                </li> 
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'ventas')); ?>">Ventas x Mayor</a></li>
            </ul>
        </section>
    </div>

</section>