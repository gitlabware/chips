<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            Administrador
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
            <li><a href="<?php echo $this->Html->url(array('controller' => 'productos', 'action' => 'index')) ?>" title="INICIO"><span class="icon-gear"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'salir')) ?>" title="Cerrar Session"><span class="icon-user"></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'productos', 'action' => 'index')) ?>" title="PRODUCTOS"><span class="icon-inbox"></span></a></li>
        </ul>

        <section class="navigable">            
            <ul class="big-menu">
                <li class="with-right-arrow">
                    <span>Usuarios</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'index')); ?>">Listado de Usuarios</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'add')); ?>">Insertar Nuevo Usuario</a></li>    
                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Clientes</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Clientes', 'action' => 'index')); ?>">Listado de Clientes</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Clientes', 'action' => 'insertar')); ?>">Nuevo cliente</a></li>
                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Lugares</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Lugares', 'action' => 'index')); ?>">Listado de Lugares</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Lugares', 'action' => 'add')); ?>">Nuevo lugar</a></li>
                    </ul>
                </li>
                 <li class="with-right-arrow">
                    <span>Rutas</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Rutas', 'action' => 'index')); ?>">Listado de Rutas</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Rutas', 'action' => 'add')); ?>">Nueva Ruta</a></li>
                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Entregas</span>
                    <ul class="big-menu">

                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'listadistribuidores')); ?>">Repartir personal</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'listaalmacenes')) ?>">Repartir Almacenes</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Chips', 'action' => 'asigna_distrib')); ?>">Asignar Chips</a></li>	
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Chips', 'action' => 'subirexcel')); ?>">Subir excel chips</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'filtra')); ?>">Reporte entrega</a></li>

                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Recargas</span>
                    <ul class="big-menu">
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Recargas', 'action' => 'nuevo')); ?>">Registrar recarga</a></li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Recargas', 'action' => 'estadorecargas2')); ?>">Reporte Recargas</a>

                        </li>                        
                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Depositos</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'listadepositos')) ?>">Listado depositos</a></li>	
                        <li><a href="<?php echo $this->Html->url(array('controller'=>'Almacenes', 'action'=>'deposito'));?>">Nuevo Deposito</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller'=>'Bancos', 'action'=>'index'))?>">Listado de Bancos</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller'=>'Bancos', 'action'=>'add'));?>">Nuevo Banco</a></li>
                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Productos</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Productos', 'action' => 'index')); ?>">Listado de Productos</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Productos', 'action' => 'insertar')); ?>">Nuevo Producto</a></li>
                        <!--<li><a href="<?php //echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'index')); ?>">Listado de Precio</a></li>-->
                        <!--<li><a href="<?php //echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'nuevoprecio')); ?>">Nuevos Precios</a></li>-->
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiposproductos', 'action' => 'index')); ?>"></a>Listado de Categorias</li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiposproductos', 'action' => 'add')); ?>">Nueva Categoria</a></li>
                    </ul>
                </li> 
                
                <li class="with-right-arrow">
                    <span>Tiendas</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Sucursals', 'action' => 'index')); ?>">Listado de tiendas</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Sucursals', 'action' => 'insertar')); ?>">Nueva tienda</a></li>

                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Sucursals', 'action' => 'addrecargacabina')); ?>">Nuevo Producto Cabina</a></li>
                    </ul>
                </li> 
                
                <li class="with-right-arrow">
                    <span>Reportes</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reportes_tienda')); ?>">General de tiendas</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_detallado_precio_tienda')); ?>">Tiendas detallado por precio</a></li>                                                                       
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_cliente_tienda')); ?>">Tiendas por Cliente</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_detallado_precio_dist')); ?>">Distribuidor detallado por precio</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_cliente_dist')); ?>">Distribuidor por cliente</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_chips')); ?>">Chips</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Reportes', 'action' => 'reporte_chips_clientes')); ?>">Chips x clientes</a></li>
                    </ul>
                </li>
                
                <li class="with-right-arrow">
                    <span>Almacenes</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'add')); ?>">Insertar Almacen</a></li>

                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'index')); ?>">Listado de Almacenes</a></li>                                                                        

                    </ul>
                </li>
                
            </ul>
        </section>
        
    </div>

</section>