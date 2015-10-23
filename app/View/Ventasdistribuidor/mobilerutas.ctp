<!--<div id="choisir_restau" data-role="page" data-add-back-btn="true">  -->
<div data-role="header">
    <h1>RUTAS</h1>
</div><!-- /header -->
<div data-role="content">
<?php //debug($lista); ?>
<ul data-role="listview" data-inset="true" data-filter="true">
    <li data-role="list-divider">Listado de rutas</li>
    <?php foreach($lista as $li):?>
    <li>
            <a href="mobileveruta/<?php echo $li['Ruteo']['id']?>">
                <?php echo $li['Ruteo']['orden'];?>: 
                <?php echo $li['Cliente']['nombre'];?>
                 <span class="ui-li-count">Cod: <?php echo $li['Cliente']['num_registro'];?></span>                               
            </a>
            
    </li>
    <?php endforeach; ?>
</ul>
</div>
<!--</div>-->