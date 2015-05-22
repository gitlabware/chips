<section id="menu" role="complementary">
    <!-- This wrapper is used by several responsive layouts -->
    <div id="menu-content">
        <header>
            Administrator
        </header>

        <div id="profile">
            <img src="<?php echo $this->webroot; ?>img/user.png" width="64" height="64" alt="User name" class="user-icon">
            Bienvenido
            <span class="name">Roger <b>Sanchez</b></span>
        </div>

        <!-- By default, this section is made for 4 icons, see the doc to learn how to change this, in "basic markup explained" -->
        <ul id="access" class="children-tooltip">
            <li><a href="#" title="Mensajes"><span class="icon-inbox"></span><span class="count">0</span></a></li>
            <li><a href="#" title="Calendario"><span class="icon-calendar"></span></a></li>
            <li><a href="#" title="Perfil"><span class="icon-user"></span></a></li>
            <li class="disabled"><span class="icon-gear"></span></li>
        </ul>

        <section class="navigable">            
            <ul class="big-menu">    
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Productos', 'action'=>'insertar')); ?>">Nuevo Producto</a></li>
                <li><a href="#">Listado Productos</a></li>	
                <li class="with-right-arrow">
                    <span>Menu Principal</span>
                    <ul class="big-menu">
                        <li><a href="#">Nuevo Producto</a></li>
                        <li><a href="#">Listado Productos</a></li>                                                                        
                        <li class="with-right-arrow">
                            <span><span class="list-count">4</span>Forms &amp; buttons</span>
                            <ul class="big-menu">
                                <li><a href="buttons.html">Buttons</a></li>
                                <li><a href="form.html">Form elements</a></li>
                                <li><a href="textareas.html">Textareas &amp; WYSIWYG</a></li>
                                <li><a href="form-layouts.html">Form layouts</a></li>
                                <li><a href="wizard.html">Wizard</a></li>
                            </ul>
                        </li>
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
            </ul>
        </section>

        <ul class="unstyled-list">
            <li class="title-menu">Hoy es</li>
            <li>
                <ul class="calendar-menu">
                    <li>
                        <a href="#" title="See event">
                            <time datetime="2011-02-24"><b>24</b> Feb</time>
                            <small class="green">10:30</small>
                            Event's description
                        </a>
                    </li>
                </ul>
            </li>
            <li class="title-menu">Ayudas</li>
            <li>
                <ul class="message-menu">
                    <li>
                        <span class="message-status">
                            <a href="#" class="starred" title="Starred">Starred</a>
                            <a href="#" class="new-message" title="Mark as read">New</a>
                        </span>
                        <span class="message-info">
                            <span class="blue">17:12</span>
                            <a href="#" class="attach" title="Download attachment">Attachment</a>
                        </span>
                        <a href="#" title="Read message">
                            <strong class="blue">John Doe</strong><br>
                            <strong>Mail subject</strong>
                        </a>
                    </li>
                    <li>
                        <a href="#" title="Read message">
                            <span class="message-status">
                                <span class="unstarred">Not starred</span>
                                <span class="new-message">New</span>
                            </span>
                            <span class="message-info">
                                <span class="blue">15:47</span>
                            </span>
                            <strong class="blue">May Starck</strong><br>
                            <strong>Mail subject a bit longer</strong>
                        </a>
                    </li>
                    <li>
                        <span class="message-status">
                            <span class="unstarred">Not starred</span>
                        </span>
                        <span class="message-info">
                            <span class="blue">15:12</span>
                        </span>
                        <strong class="blue">May Starck</strong><br>
                        Read message
                    </li>
                </ul>
            </li>
        </ul>

    </div>
    <!-- End content wrapper -->

    <!-- This is optional -->
    <footer id="menu-footer">
        <p class="button-height">
            <input type="checkbox" name="auto-refresh" id="auto-refresh" checked="checked" class="switch float-right">
            <label for="auto-refresh">Auto-refresh</label>
        </p>
    </footer>

</section>