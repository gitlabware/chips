<div data-role="content">	
    <?php echo $this->Session->flash(); ?>
    <div align="center">
    <?php echo $this->Html->image('logoprint.png'); ?>
        </div>
    <ul data-role="listview" data-divider-theme="b" data-inset="true">
        <li data-role="list-divider" role="heading">
            MENU PRINCIPAL
        </li>
        <li><a href="#">Pedidos</a></li>
        <li><a href="#">Cuestionarios</a></li>
        <li><a href="#">Ventas</a></li>   
        <!--<li><a href="mobileindex">Rutas</a></li>-->
        <li><?php echo $this->Html->link('Rutas', array('action' => 'mobilerutas')); ?></li>
    </ul>
    <div>
        <b>
            Seleccione una opcion
            <br />
        </b>
    </div>
</div>