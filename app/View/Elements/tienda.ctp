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
            <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'pidecodigo')) ?>" title="Venta mayor"><span class="icon-calendar"></span></a></li>
        </ul>

        <section class="navigable">            
            <ul class="big-menu">    
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'cambiopass',$this->Session->read('Auth.User.id'))); ?>">Cambiar Password</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'registrocabinas')); ?>">Control cabinas</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'registrardeposito')); ?>">Registrar deposito</a></li>
                <li class="with-right-arrow">
                    <span>Reportes</span>
                    <ul class="big-menu">
                        <?php
                        $idusuario = $this->Session->read("Auth.User.id");
                        $fecha = date('Y-m-d');
                        ?>
                        <li class="with-right-arrow">
                            <span>Reporte ventas x mayor</span>
                            <ul class="big-menu">
                                <?php
                                $idusuario = $this->Session->read("Auth.User.id");
                                $fecha = date('Y-m-d');
                                ?>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'reporteventasxmayorproductos')); ?>">Productos</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'reporte149', $this->Session->read('Auth.User.sucursal_id'))); ?>">Clientes</a></li>                                                                        

                            </ul>
                        </li>
                        <li class="with-right-arrow">
                            <span>Reporte ventas al detalle</span>
                            <ul class="big-menu">
                                <?php
                                $idusuario = $this->Session->read("Auth.User.id");
                                $fecha = date('Y-m-d');
                                ?>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'reporteventashoy', $this->Session->read("Auth.User.sucursal_id"))); ?>">Resumen</a></li>
                                <li><a href="<?php echo $this->Html->url(array('controller' => 'Tiendas', 'action' => 'reporteventastienda', $this->Session->read('Auth.User.sucursal_id'))); ?>">detalle</a></li>                                                                        

                            </ul>
                        </li>
                                                                                                

                    </ul>
                </li> 

            </ul>
        </section>


    </div>

</section>