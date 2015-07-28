<section id="menu" role="complementary" class="no-imprime">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            Administrador
        </header>

        <div id="profile">
            <img src="<?php echo $this->webroot; ?>img/user.png" width="64" height="64" alt="User name" class="user-icon">
            Bienvenido
            <span class="name"><?php echo $this->Session->read('Auth.User.Persona.nombre'); ?>
                <?php $idUsuario = $this->Session->read('Auth.User.id'); ?>
                <b><?php echo $this->Session->read('Auth.User.Persona.ap_paterno'); ?></b>
            </span>
        </div>

        <!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
        <ul id="access" class="children-tooltip">
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'principal')) ?>" title="Estadisticas"><span class="icon-line-graph"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'editar', $idUsuario)) ?>" title="Mis Datos"><span class="icon-user"></span></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'productos', 'action' => 'index')) ?>" title="Productos"><span class="icon-clipboard"></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'salir')) ?>" title="Salir"><span class="icon-extract"></span></a></li>            
        </ul>

        <section class="navigable">            
            <ul class="big-menu">

                <li class="with-right-arrow">
                    <span>Administracion</span>
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
                            <span>Productos</span>
                            <ul class="big-menu">
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Productos', 'action' => 'index')); ?>">Listado de Productos</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Productos', 'action' => 'insertar')); ?>">Nuevo Producto</a></li>
                                <!--<li><a href="<?php //echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'index'));              ?>">Listado de Precio</a></li>-->
                                <!--<li><a href="<?php //echo $this->Html->url(array('controller' => 'Productosprecios', 'action' => 'nuevoprecio'));              ?>">Nuevos Precios</a></li>-->
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiposproductos', 'action' => 'index')); ?>">Listado de Categorias</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiposproductos', 'action' => 'add')); ?>">Nueva Categoria</a></li>
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
                            <span>Almacenes</span>
                            <ul class="big-menu">
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'add')); ?>">Insertar Almacen</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'index')); ?>">Listado de Almacenes</a></li>                                                                        
                            </ul>
                        </li>
                        <li><a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'ajaxprecios')) ?>', 'Precios chip/4g');">Precios Chip/4g</a></li>

                    </ul>
                </li>                                                                

                <li class="with-right-arrow">
                    <span>Pedidos</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Pedidos', 'action' => 'pedido')); ?>">Nuevo Pedido</a></li>

                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Pedidos', 'action' => 'index')); ?>">Listado de Pedidos</a></li>                                                                        

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
                    <span>Chips</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Chips', 'action' => 'subirexcel')); ?>">Subir excel chips</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Chips', 'action' => 'asigna_distrib')); ?>">Asignar Chips</a></li>	
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Chips', 'action' => 'asignados')); ?>">Chips asignados</a></li>                                                
                        <li><a href="<?php echo $this->Html->url(array('controller' => 'Chips', 'action' => 'todos')); ?>">Todos los chips</a></li>
                    </ul>
                </li>

                <li class="with-right-arrow">
                    <span>Recargas</span>
                    <ul class="big-menu">
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Recargados', 'action' => 'nuevo')); ?>">Registrar recarga</a></li>
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Recargas', 'action' => 'estadorecargas2')); ?>">Reporte Recargas</a>

                        </li>                        
                    </ul>
                </li>

                <!--<li class="with-right-arrow">
                    <span>Depositos</span>
                    <ul class="big-menu">
                        <li><a href="<?php //echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'listadepositos'))      ?>">Listado depositos</a></li>	
                        <li><a href="<?php //echo $this->Html->url(array('controller' => 'Almacenes', 'action' => 'deposito'));      ?>">Nuevo Deposito</a></li>
                        <li><a href="<?php //echo $this->Html->url(array('controller' => 'Bancos', 'action' => 'index'))      ?>">Listado de Bancos</a></li>
                        <li><a href="<?php //echo $this->Html->url(array('controller' => 'Bancos', 'action' => 'add'));      ?>">Nuevo Banco</a></li>
                    </ul>
                </li>-->


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
                <li class="with-right-arrow">
                    <span>Minievento</span>
                    <ul class="big-menu">
                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minieventos')); ?>">Listado de Minieventos</a>
                        </li>
                        <li>
                            <a href="javascript:" onclick="cargarmodal('<?php echo $this->Html->url(array('controller' => 'Impulsadores', 'action' => 'minievento')); ?>', 'Minievento')">Nuevo Minievento</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'Informes', 'action' => 'index')); ?>">Informes</a>
                </li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'Ventas', 'action' => 'distribuidores')); ?>">Ventas</a>
                </li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'Cajachicas', 'action' => 'index')); ?>">Caja chica</a>
                </li>
            </ul>
        </section>

    </div>

</section>

<script>
$(".big-menu a[href='"+String(window.location.pathname)+"']").addClass('current navigable-current');
</script>
