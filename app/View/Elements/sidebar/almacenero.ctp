
<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            Almacenes
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
            <li><a href="<?php echo $this->Html->url(array('controller' => 'almacenes', 'action' => 'listadistribuidores')) ?>" title="INICIO"><span class="icon-gear"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'salir')) ?>" title="Cerrar Session"><span class="icon-user"></span></a></li>

            <li><a href="<?php echo $this->Html->url(array('controller' => 'Productos', 'action' => 'index')) ?>" title="PRODUCTOS"><span class="icon-inbox"></span></a></li>

        </ul>
        <section class="navigable">            
            <ul class="big-menu"> 
                
                <li class="with-right-arrow">
                    <span>Productos</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Productos', 'action' => 'index')); ?>">Listado</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Productos', 'action' => 'insertar')); ?>">Nuevo</a></li>                                                                                                
                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Almacenes</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'add')); ?>">Insertar Almacen</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'index')); ?>">Listado de Almacenes</a></li>                                                                                                
                    </ul>
                </li>
                
                 <li class="with-right-arrow">
                            <span>Tiendas</span>
                            <ul class="big-menu">
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Sucursals', 'action' => 'index')); ?>">Listado de tiendas</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Sucursals', 'action' => 'insertar')); ?>">Nueva tienda</a></li>                                
                            </ul>
                        </li>
                
                <li class="with-right-arrow">
                    <span>Distribuir</span>
                    <ul class="big-menu">

                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'listadistribuidores')); ?>">Personal</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'listaalmacenes')) ?>">Almacen</a></li>                                                

                    </ul>
                </li>
                                

                <li class="with-right-arrow">
                    <span>Reportes</span>
                    <ul class="big-menu">

                        <li class="with-right-arrow">
                            <span>Tiendas</span>
                            <ul class="big-menu">
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reportes_tienda')); ?>">General</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_detallado_precio_tienda')); ?>">Ventas</a></li>                                                                       
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_cliente_tienda')); ?>">Clientes</a></li>                       
                            </ul>
                        </li>   

                        <li class="with-right-arrow">
                            <span>Distribuidores</span>
                            <ul class="big-menu">
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_detallado_precio_dist')); ?>">Ventas</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_cliente_dist')); ?>">Cliente</a></li>
                            </ul>
                        </li>  

                        <li class="with-right-arrow">
                            <span>Chips</span>
                            <ul class="big-menu">
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_chips')); ?>">General</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_chips_clientes')); ?>">Clientes</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_chips_c_total')); ?>">Totales</a></li>
                            </ul>
                        </li>  
                        
                        <li class="with-right-arrow">
                            <span>Celulares</span>
                            <ul class="big-menu">
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_celular')); ?>">General</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_celular_cliente')); ?>">Clientes</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_pagos')); ?>">Pagos</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>               

            </ul>
        </section>



    </div>

</section>

