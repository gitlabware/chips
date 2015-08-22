<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            Administrator
        </header>

        <div id="profile">
            <img src="<?php echo $this->webroot; ?>img/user.png" width="64" height="64" alt="User name" class="user-icon">
            Bienvenido
            <span class="name"><?php echo $this->Session->read('Auth.User.Persona.nombre');?>
             <b><?php echo $this->Session->read('Auth.User.Persona.ap_paterno');?></b>
             </span>
        </div>

        <!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
        <ul id="access" class="children-tooltip">
            <li><a href="#" title="Mensajes"><span class="icon-inbox"></span><span class="count">0</span></a></li>
            <li><a href="#" title="Calendario"><span class="icon-calendar"></span></a></li>
            <li><a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'salir'))?>" title="Cerrar Session"><span class="icon-user"></span></a></li>
            <li class="disabled"><span class="icon-gear"></span></li>
        </ul>

        <section class="navigable">            
            <ul class="big-menu">
                <li class="with-right-arrow">
                    <span>Usuarios</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'index')); ?>">Listado de Usuarios</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller'=>'Users', 'action'=>'add')); ?>">Insertar Nuevo Usuario</a></li>    
                    </ul>
                </li>    
                <li><a href="<?php echo $this->Html->url(array('controller'=>'almacenes', 'action'=>'listadistribuidores')); ?>">Repartir personal</a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'almacenes', 'action'=>'listaalmacenes'))?>">Repartir almacenes</a></li>	
                <li class="with-right-arrow">
                    <span>Productos</span>
                    <ul class="big-menu">
                        <li><a href="<?php echo $this->Html->url(array('controller'=>'Productos', 'action'=>'insertar')); ?>">Nuevo Producto</a></li>
                        <li><a href="<?php echo $this->Html->url(array('controller'=>'Productos', 'action'=>'index')); ?>">Productos</a></li>                                                                        
                      
                        <li class="with-right-arrow">
                            <span><span class="list-count">2</span>Agenda &amp; Calendars</span>
                            <ul class="big-menu">
                                <li><a href="agenda.html">Agenda</a></li>
                                <li><a href="calendars.html">Calendars</a></li>
                            </ul>
                        </li>
                        <li><a href="blocks.html">Blocks &amp; infos</a></li>
                    </ul>
                </li>  
                    <li><a href="<?php echo $this->Html->url(array('controller'=>'Reportes', 'action'=>'reporte')); ?>">Reporte Almacenes</a></li>
                                             
            </ul>
        </section>

        

    </div>

</section>